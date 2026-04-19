<?php
$pageTitle = 'Cronômetro — StudyFocus';
require __DIR__ . '/../layouts/header.php';
require __DIR__ . '/../layouts/sidebar.php';

$todayFocus = array_filter($todaySessions ?? [], fn($s) => $s->type === 'focus' && $s->completed);
$todayMinutes = array_sum(array_column(iterator_to_array((function() use ($todayFocus) { yield from $todayFocus; })()), 'duration_minutes'));
?>

<div class="sf-main">
  <div class="sf-page-wrap" style="max-width:680px;">
    <div class="sf-page-title">Cronômetro Pomodoro</div>
    <div class="sf-page-sub">Mantenha o foco em blocos de tempo estruturados.</div>

    <?php if (!empty($flash)): ?>
      <div class="sf-alert <?= $flash['type'] ?>"><?= htmlspecialchars($flash['message']) ?></div>
    <?php endif; ?>

    <!-- Timer card -->
    <div class="sf-card" style="text-align:center;padding:40px 32px;">

      <!-- Modo buttons -->
      <div style="display:flex;gap:8px;justify-content:center;margin-bottom:36px;flex-wrap:wrap;">
        <button class="sf-timer-btn outline active" data-duration="focus">🎯 Foco (25min)</button>
        <button class="sf-timer-btn outline" data-duration="short_break">☕ Pausa Curta (5min)</button>
        <button class="sf-timer-btn outline" data-duration="long_break">🌿 Pausa Longa (15min)</button>
      </div>

      <!-- SVG ring -->
      <div style="position:relative;width:220px;height:220px;margin:0 auto 10px;">
        <svg width="220" height="220" viewBox="0 0 220 220" style="transform:rotate(-90deg);">
          <circle cx="110" cy="110" r="90" fill="none" stroke="var(--sf-border)" stroke-width="10"/>
          <circle id="progressRing" cx="110" cy="110" r="90" fill="none"
                  stroke="var(--sf-green)" stroke-width="10"
                  stroke-linecap="round"
                  stroke-dasharray="<?= 2 * M_PI * 90 ?>"
                  stroke-dashoffset="<?= 2 * M_PI * 90 ?>"
                  style="transition:stroke-dashoffset .5s linear;"/>
        </svg>
        <div style="position:absolute;inset:0;display:flex;flex-direction:column;align-items:center;justify-content:center;">
          <div id="timerDisplay" class="sf-timer-display">25:00</div>
          <div id="timerLabel" style="font-size:13px;color:var(--sf-muted);margin-top:4px;">Foco</div>
        </div>
      </div>

      <!-- Matéria -->
      <div style="max-width:280px;margin:16px auto;">
        <input type="text" id="pomodoroSubject" placeholder="Qual matéria você está estudando?"
               style="width:100%;padding:9px 14px;border:1.5px solid var(--sf-border);border-radius:8px;font-size:13px;font-family:inherit;outline:none;text-align:center;">
      </div>

      <!-- Controles -->
      <div class="sf-timer-controls" style="margin-top:20px;">
        <button id="btnStart" class="sf-timer-btn primary">▶ Iniciar</button>
        <button id="btnPause" class="sf-timer-btn outline" disabled>⏸ Pausar</button>
        <button id="btnReset" class="sf-timer-btn outline">↺ Resetar</button>
      </div>
    </div>

    <!-- Sessões de hoje -->
    <div class="sf-card">
      <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:14px;">
        <div style="font-size:14px;font-weight:700;">Sessões de Hoje</div>
        <span style="font-size:12px;color:var(--sf-green);font-weight:600;">
          <?= count($todaySessions) ?> sessões · <?= $todayMinutes ?>min
        </span>
      </div>

      <?php if (empty($todaySessions)): ?>
        <p style="color:var(--sf-muted);font-size:13px;text-align:center;padding:16px 0;">
          Nenhuma sessão registrada hoje. Comece agora!
        </p>
      <?php else: ?>
        <?php foreach (array_slice($todaySessions, 0, 8) as $s): ?>
          <div style="display:flex;align-items:center;gap:10px;padding:8px 0;border-bottom:1px solid var(--sf-border);">
            <span style="font-size:18px;">
              <?= $s->type === 'focus' ? '🎯' : ($s->type === 'short_break' ? '☕' : '🌿') ?>
            </span>
            <div style="flex:1;">
              <div style="font-size:13px;font-weight:600;">
                <?= htmlspecialchars($s->subject ?: 'Sessão de ' . ($s->type === 'focus' ? 'Foco' : 'Pausa')) ?>
              </div>
              <div style="font-size:11px;color:var(--sf-muted);">
                <?= $s->duration_minutes ?>min ·
                <?= (new DateTime($s->started_at))->format('H:i') ?>
                <?= $s->completed ? '· ✓ Concluída' : '· Interrompida' ?>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>
  </div>
</div>

<!-- Hidden form to save session via JS -->
<form id="pomodoroForm" method="POST" action="<?= BASE_URL ?>/cronometro/salvar" style="display:none;">
  <input type="hidden" name="type" value="focus">
  <input type="hidden" name="duration_minutes" value="25">
  <input type="hidden" name="completed" value="1">
  <input type="hidden" name="subject" value="">
</form>

<style>
[data-duration].active { background:var(--sf-green);color:white;border-color:var(--sf-green); }
#pomodoroSubject:focus { border-color:var(--sf-green); }
</style>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
