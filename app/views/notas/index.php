<?php
$pageTitle = 'Anotações — StudyFocus';
require __DIR__ . '/../layouts/header.php';
require __DIR__ . '/../layouts/sidebar.php';

function timeAgo(string $datetime): string {
    $now  = new DateTime();
    $then = new DateTime($datetime);
    $diff = $now->diff($then);

    if ($diff->days === 0) {
        if ($diff->h === 0) return 'Agora';
        return $diff->h . 'h atrás';
    }
    if ($diff->days === 1) return 'Ontem';
    if ($diff->days < 30)  return $diff->days . ' dias';
    return $then->format('d M');
}

function stripContent(string $html): string {
    return mb_substr(strip_tags($html), 0, 80);
}
?>

<div class="sf-main">
  <div class="sf-notas-wrap">

    <!-- ── PANEL ESQUERDO: Lista ─────────────────────── -->
    <div class="sf-list-panel">

      <div class="sf-list-header">
        <h5>Minhas Anotações</h5>
        <form method="GET" action="<?= BASE_URL ?>/notas" class="sf-search-box">
          <i class="bi bi-search"></i>
          <input type="text" name="busca" placeholder="Buscar registros..."
                 value="<?= htmlspecialchars($search) ?>" autocomplete="off">
          <?php if ($categoryId): ?>
            <input type="hidden" name="categoria" value="<?= $categoryId ?>">
          <?php endif; ?>
        </form>
      </div>

      <!-- Filtros por categoria -->
      <div class="sf-filter-chips">
        <a href="<?= BASE_URL ?>/notas<?= $search ? '?busca='.urlencode($search) : '' ?>"
           class="sf-chip <?= !$categoryId ? 'active' : '' ?>">Tudo</a>

        <?php foreach ($categories as $cat): ?>
          <?php
            $qs = http_build_query(['categoria' => $cat->id] + ($search ? ['busca' => $search] : []));
          ?>
          <a href="<?= BASE_URL ?>/notas?<?= $qs ?>"
             class="sf-chip <?= $categoryId === (int)$cat->id ? 'active' : '' ?>"
             style="<?= $categoryId === (int)$cat->id ? "background:{$cat->color};border-color:{$cat->color}" : '' ?>">
            <?= htmlspecialchars($cat->name) ?>
          </a>
        <?php endforeach; ?>
      </div>

      <!-- Flash na lista -->
      <?php if (!empty($flash)): ?>
        <div class="sf-alert <?= $flash['type'] ?>" style="margin:8px 10px;">
          <?= htmlspecialchars($flash['message']) ?>
        </div>
      <?php endif; ?>

      <!-- Lista de notas -->
      <div class="sf-notes-list">
        <?php if (empty($notas)): ?>
          <div style="text-align:center;padding:40px 16px;color:var(--sf-muted);">
            <i class="bi bi-journal" style="font-size:36px;display:block;margin-bottom:10px;opacity:.3;"></i>
            <p style="font-size:13px;">Nenhuma anotação encontrada.</p>
          </div>
        <?php else: ?>
          <?php foreach ($notas as $nota): ?>
            <?php
              $isActive = $activeNota && (int)$activeNota->id === (int)$nota->id;
              $qs       = http_build_query(array_filter(['nota' => $nota->id, 'categoria' => $categoryId, 'busca' => $search]));
            ?>
            <a href="<?= BASE_URL ?>/notas?<?= $qs ?>"
               class="sf-note-item <?= $isActive ? 'active' : '' ?>">
              <div class="sf-note-item-title"><?= htmlspecialchars($nota->title) ?></div>
              <div class="sf-note-item-preview">
                <?= htmlspecialchars(stripContent($nota->content ?? '')) ?>
              </div>
              <div class="sf-note-item-meta">
                <?php if (!empty($nota->category_name)): ?>
                  <span class="sf-category-dot" style="color:<?= htmlspecialchars($nota->category_color ?? '#aaa') ?>">
                    <?= htmlspecialchars($nota->category_name) ?>
                  </span>
                <?php else: ?>
                  <span></span>
                <?php endif; ?>
                <span class="sf-note-time"><?= timeAgo($nota->updated_at) ?></span>
              </div>
            </a>
          <?php endforeach; ?>
        <?php endif; ?>
      </div>

      <!-- Botão Nova Nota -->
      <button class="sf-new-note-btn" data-open-modal="newNoteModal">
        <i class="bi bi-plus-lg"></i> Nova Nota
      </button>
    </div>

    <!-- ── PANEL DIREITO: Editor ──────────────────────── -->
    <div class="sf-editor-panel">
      <?php if ($activeNota): ?>

        <form id="noteForm"
              method="POST"
              action="<?= BASE_URL ?>/notas/<?= (int)$activeNota->id ?>">
          <input type="hidden" name="_method" value="POST">
          <input type="hidden" name="content" value="<?= htmlspecialchars($activeNota->content ?? '') ?>">

          <!-- Editor Header -->
          <div class="sf-editor-header">
            <div class="sf-editor-header-left">
              <input type="text" name="title" data-watch
                     class="sf-editor-title-input"
                     value="<?= htmlspecialchars($activeNota->title) ?>"
                     placeholder="Título da anotação...">

              <div class="sf-editor-meta">
                <!-- Categoria -->
                <select name="category_id" data-watch>
                  <option value="">● Sem categoria</option>
                  <?php foreach ($categories as $cat): ?>
                    <option value="<?= $cat->id ?>"
                      <?= (int)($activeNota->category_id ?? 0) === (int)$cat->id ? 'selected' : '' ?>>
                      ● <?= htmlspecialchars($cat->name) ?>
                    </option>
                  <?php endforeach; ?>
                </select>

                <!-- Data -->
                <span class="sf-editor-date">
                  <i class="bi bi-clock" style="font-size:11px;"></i>
                  Última edição <?= (new DateTime($activeNota->updated_at))->format('d/m/Y \à\s H:i') ?>
                </span>

                <!-- Status autosave -->
                <span id="saveStatus" class="sf-save-status" style="font-size:11px;color:var(--sf-muted);"></span>
              </div>
            </div>

            <!-- Ações -->
            <div class="sf-editor-actions">
              <button type="button" id="btnSave" class="sf-btn-save">
                <i class="bi bi-floppy"></i> Salvar
              </button>

              <form method="POST"
                    action="<?= BASE_URL ?>/notas/<?= (int)$activeNota->id ?>/delete"
                    style="display:inline;"
                    onsubmit="return confirm('Tem certeza que deseja excluir esta nota?')">
                <input type="hidden" name="_method" value="POST">
                <button type="submit" class="sf-btn-delete" title="Excluir nota">
                  <i class="bi bi-trash3"></i>
                </button>
              </form>
            </div>
          </div>

          <!-- Toolbar -->
          <div class="sf-toolbar">
            <button type="button" class="sf-toolbar-btn" data-cmd="bold" title="Negrito (Ctrl+B)">
              <strong>B</strong>
            </button>
            <button type="button" class="sf-toolbar-btn" data-cmd="italic" title="Itálico (Ctrl+I)">
              <em>I</em>
            </button>
            <button type="button" class="sf-toolbar-btn" data-cmd="underline" title="Sublinhado (Ctrl+U)">
              <u>U</u>
            </button>

            <div class="sf-toolbar-sep"></div>

            <button type="button" class="sf-toolbar-btn" data-cmd="justifyLeft" title="Alinhar esquerda">
              <i class="bi bi-text-left"></i>
            </button>
            <button type="button" class="sf-toolbar-btn" data-cmd="justifyCenter" title="Centralizar">
              <i class="bi bi-text-center"></i>
            </button>
            <button type="button" class="sf-toolbar-btn" data-cmd="justifyRight" title="Alinhar direita">
              <i class="bi bi-text-right"></i>
            </button>

            <div class="sf-toolbar-sep"></div>

            <button type="button" class="sf-toolbar-btn" data-cmd="insertUnorderedList" title="Lista">
              <i class="bi bi-list-ul"></i>
            </button>
            <button type="button" class="sf-toolbar-btn" data-cmd="insertOrderedList" title="Lista numerada">
              <i class="bi bi-list-ol"></i>
            </button>

            <div class="sf-toolbar-sep"></div>

            <button type="button" class="sf-toolbar-btn"
                    data-cmd="formatBlock" data-value="h2" title="Título">
              <i class="bi bi-type-h2"></i>
            </button>
            <button type="button" class="sf-toolbar-btn"
                    data-cmd="formatBlock" data-value="h3" title="Subtítulo">
              <i class="bi bi-type-h3"></i>
            </button>
            <button type="button" class="sf-toolbar-btn"
                    data-cmd="removeFormat" title="Remover formatação">
              <i class="bi bi-eraser"></i>
            </button>
          </div>

          <!-- Editor body -->
          <div class="sf-editor-body">
            <div class="sf-editor-content" id="editorContent">
              <?= $activeNota->content ?? '' ?>
            </div>
          </div>
        </form>

      <?php else: ?>
        <!-- Estado vazio -->
        <div class="sf-editor-empty">
          <i class="bi bi-journal-text"></i>
          <h5>Selecione ou crie uma anotação</h5>
          <p>Suas anotações aparecerão aqui para edição.</p>
          <button class="sf-new-note-btn"
                  data-open-modal="newNoteModal"
                  style="width:auto;margin:16px auto 0;display:inline-flex;">
            <i class="bi bi-plus-lg"></i> Nova Nota
          </button>
        </div>
      <?php endif; ?>
    </div>

  </div><!-- /.sf-notas-wrap -->
</div><!-- /.sf-main -->

<!-- ── MODAL: Nova Nota ──────────────────────── -->
<div class="sf-modal-overlay" id="newNoteModal">
  <div class="sf-modal">
    <h5><i class="bi bi-plus-circle" style="color:var(--sf-green);margin-right:6px;"></i>Nova Anotação</h5>

    <form method="POST" action="<?= BASE_URL ?>/notas">
      <label for="newTitle">Título</label>
      <input type="text" id="newTitle" name="title" placeholder="Ex: Revolução Francesa..." required>

      <label for="newCategory">Categoria</label>
      <select id="newCategory" name="category_id">
        <option value="">Sem categoria</option>
        <?php foreach ($categories as $cat): ?>
          <option value="<?= $cat->id ?>"><?= htmlspecialchars($cat->name) ?></option>
        <?php endforeach; ?>
      </select>

      <input type="hidden" name="content" value="">

      <div class="sf-modal-footer">
        <button type="button" class="sf-btn-cancel" data-close-modal>Cancelar</button>
        <button type="submit" class="sf-btn-save" style="padding:8px 20px;">
          <i class="bi bi-plus-lg"></i> Criar
        </button>
      </div>
    </form>
  </div>
</div>

<style>
.sf-save-status.saved   { color: var(--sf-green); font-weight:600; }
.sf-save-status.unsaved { color: #f59e0b; }
.sf-save-status.error   { color: #e53e3e; }
</style>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
