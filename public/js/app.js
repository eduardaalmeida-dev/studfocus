/* =============================================
   StudyFocus - Main JS
   ============================================= */

'use strict';

/* ── UTILS ──────────────────────────────────── */
const $ = (sel, ctx = document) => ctx.querySelector(sel);
const $$ = (sel, ctx = document) => [...ctx.querySelectorAll(sel)];

function debounce(fn, ms = 300) {
  let t;
  return (...args) => { clearTimeout(t); t = setTimeout(() => fn(...args), ms); };
}

/* ── FLASH AUTO-DISMISS ─────────────────────── */
$$('.sf-alert').forEach(el => {
  setTimeout(() => el.style.opacity = '0', 3500);
  setTimeout(() => el.remove(), 4000);
  el.style.transition = 'opacity .5s';
});

/* ── RICH TEXT TOOLBAR ──────────────────────── */
function initToolbar() {
  const toolbar  = $('.sf-toolbar');
  const editor   = $('.sf-editor-content');
  if (!toolbar || !editor) return;

  editor.setAttribute('contenteditable', 'true');
  editor.setAttribute('spellcheck', 'true');

  toolbar.addEventListener('click', e => {
    const btn = e.target.closest('[data-cmd]');
    if (!btn) return;

    const cmd   = btn.dataset.cmd;
    const value = btn.dataset.value || null;

    e.preventDefault();
    editor.focus();
    document.execCommand(cmd, false, value);
    updateToolbarState();
    syncHidden();
  });

  editor.addEventListener('keyup', updateToolbarState);
  editor.addEventListener('mouseup', updateToolbarState);
  editor.addEventListener('input', debounce(syncHidden, 200));

  function updateToolbarState() {
    $$('[data-cmd]', toolbar).forEach(btn => {
      const cmd = btn.dataset.cmd;
      try {
        btn.classList.toggle('active', document.queryCommandState(cmd));
      } catch (_) {}
    });
  }

  function syncHidden() {
    const hidden = $('[name="content"]');
    if (hidden) hidden.value = editor.innerHTML;
  }

  // Keyboard shortcuts
  editor.addEventListener('keydown', e => {
    if (!e.ctrlKey && !e.metaKey) return;
    const map = { b: 'bold', i: 'italic', u: 'underline' };
    if (map[e.key]) { e.preventDefault(); document.execCommand(map[e.key]); syncHidden(); }
  });
}

/* ── AUTOSAVE ───────────────────────────────── */
function initAutosave() {
  const form   = $('#noteForm');
  const status = $('#saveStatus');
  if (!form) return;

  let dirty = false;
  let timer;

  const markDirty = () => {
    dirty = true;
    if (status) { status.textContent = 'Não salvo'; status.className = 'sf-save-status unsaved'; }
    clearTimeout(timer);
    timer = setTimeout(autoSave, 2000);
  };

  $$('[data-watch]', form).forEach(el => {
    el.addEventListener('input', markDirty);
    el.addEventListener('change', markDirty);
  });

  $('.sf-editor-content')?.addEventListener('input', markDirty);

  async function autoSave() {
    if (!dirty) return;
    const data = new FormData(form);
    const url  = form.action;

    try {
      const res = await fetch(url, {
        method: 'POST',
        body: data,
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
      });
      const json = await res.json();
      if (json.success) {
        dirty = false;
        if (status) { status.textContent = 'Salvo ✓'; status.className = 'sf-save-status saved'; }
      }
    } catch (_) {
      if (status) { status.textContent = 'Erro ao salvar'; status.className = 'sf-save-status error'; }
    }
  }

  // Manual save button
  $('#btnSave')?.addEventListener('click', () => { clearTimeout(timer); autoSave(); });
}

/* ── NEW NOTE MODAL ─────────────────────────── */
function initNewNoteModal() {
  const overlay = $('#newNoteModal');
  if (!overlay) return;

  const openBtn  = $$('[data-open-modal="newNoteModal"]');
  const closeBtn = $$('[data-close-modal]', overlay);

  openBtn.forEach(btn => btn.addEventListener('click', () => overlay.classList.add('open')));
  closeBtn.forEach(btn => btn.addEventListener('click', () => overlay.classList.remove('open')));
  overlay.addEventListener('click', e => { if (e.target === overlay) overlay.classList.remove('open'); });
}

/* ── DELETE CONFIRM ─────────────────────────── */
function initDeleteConfirm() {
  $$('[data-confirm]').forEach(btn => {
    btn.addEventListener('click', e => {
      if (!confirm(btn.dataset.confirm)) e.preventDefault();
    });
  });
}

/* ── POMODORO TIMER ─────────────────────────── */
function initPomodoro() {
  const display  = $('#timerDisplay');
  const label    = $('#timerLabel');
  const btnStart = $('#btnStart');
  const btnPause = $('#btnPause');
  const btnReset = $('#btnReset');
  const typeBtns = $$('[data-duration]');
  const subjectIn= $('#pomodoroSubject');
  const form     = $('#pomodoroForm');

  if (!display) return;

  const MODES = {
    focus:       { label: 'Foco',          minutes: 25 },
    short_break: { label: 'Pausa Curta',   minutes: 5  },
    long_break:  { label: 'Pausa Longa',   minutes: 15 },
  };

  let currentMode  = 'focus';
  let totalSeconds = 25 * 60;
  let remaining    = totalSeconds;
  let interval     = null;
  let running      = false;
  let completed    = false;

  function fmt(s) {
    const m = String(Math.floor(s / 60)).padStart(2, '0');
    const sec = String(s % 60).padStart(2, '0');
    return `${m}:${sec}`;
  }

  function render() {
    display.textContent = fmt(remaining);
    document.title      = running ? `${fmt(remaining)} - StudyFocus` : 'StudyFocus';
    updateProgressRing();
  }

  function updateProgressRing() {
    const ring = $('#progressRing');
    if (!ring) return;
    const pct  = 1 - (remaining / totalSeconds);
    const circ = 2 * Math.PI * 90;
    ring.style.strokeDashoffset = circ * (1 - pct);
  }

  function setMode(mode) {
    stop();
    currentMode  = mode;
    totalSeconds = MODES[mode].minutes * 60;
    remaining    = totalSeconds;
    if (label) label.textContent = MODES[mode].label;
    typeBtns.forEach(b => b.classList.toggle('active', b.dataset.duration === mode));
    render();
    completed = false;
  }

  function start() {
    if (running) return;
    running  = true;
    interval = setInterval(() => {
      remaining--;
      render();
      if (remaining <= 0) {
        clearInterval(interval);
        running   = false;
        completed = true;
        display.textContent = '00:00';
        playDone();
        saveSession();
      }
    }, 1000);
    btnStart?.setAttribute('disabled', '');
    btnPause?.removeAttribute('disabled');
  }

  function pause() {
    clearInterval(interval);
    running = false;
    btnStart?.removeAttribute('disabled');
    btnPause?.setAttribute('disabled', '');
  }

  function stop() {
    clearInterval(interval);
    running  = false;
    interval = null;
    btnStart?.removeAttribute('disabled');
    btnPause?.setAttribute('disabled', '');
  }

  async function saveSession() {
    if (!form) return;
    const data = new FormData(form);
    data.set('type',             currentMode);
    data.set('duration_minutes', MODES[currentMode].minutes);
    data.set('completed',        '1');
    if (subjectIn) data.set('subject', subjectIn.value);

    await fetch(form.action, {
      method: 'POST',
      body:   data,
      headers: { 'X-Requested-With': 'XMLHttpRequest' }
    }).catch(() => {});
  }

  function playDone() {
    try {
      const ctx  = new (window.AudioContext || window.webkitAudioContext)();
      [523, 659, 784].forEach((freq, i) => {
        const osc = ctx.createOscillator();
        const gain = ctx.createGain();
        osc.connect(gain); gain.connect(ctx.destination);
        osc.frequency.value = freq;
        osc.type = 'sine';
        gain.gain.setValueAtTime(0.3, ctx.currentTime + i * 0.3);
        gain.gain.exponentialRampToValueAtTime(0.001, ctx.currentTime + i * 0.3 + 0.5);
        osc.start(ctx.currentTime + i * 0.3);
        osc.stop(ctx.currentTime + i * 0.3 + 0.5);
      });
    } catch (_) {}
  }

  btnStart?.addEventListener('click', start);
  btnPause?.addEventListener('click', pause);
  btnReset?.addEventListener('click', () => setMode(currentMode));
  typeBtns.forEach(b => b.addEventListener('click', () => setMode(b.dataset.duration)));

  render();
}

/* ── SEARCH DEBOUNCE ────────────────────────── */
function initSearch() {
  const input = $('.sf-search-box input');
  if (!input) return;
  const form = input.closest('form');
  if (!form) return;
  input.addEventListener('input', debounce(() => form.submit(), 400));
}

/* ── INIT ───────────────────────────────────── */
document.addEventListener('DOMContentLoaded', () => {
  initToolbar();
  initAutosave();
  initNewNoteModal();
  initDeleteConfirm();
  initPomodoro();
  initSearch();
});
