<?php
$pageTitle = 'Painel — StudyFocus';
require __DIR__ . '/../layouts/header.php';
require __DIR__ . '/../layouts/sidebar.php';

$weeklyHours = round($weeklyMinutes / 60, 1);
$firstName   = explode(' ', $user->name ?? 'Estudante')[0];
?>

<div class="sf-main">
  <div class="sf-page-wrap">

    <div class="sf-page-title">Olá, <?= htmlspecialchars($firstName) ?>! 👋</div>
    <div class="sf-page-sub">Aqui está um resumo da sua semana de estudos.</div>

    <?php if (!empty($flash)): ?>
      <div class="sf-alert <?= $flash['type'] ?>" style="margin-bottom:16px;">
        <?= htmlspecialchars($flash['message']) ?>
      </div>
    <?php endif; ?>

    <!-- Stats -->
    <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(180px,1fr));gap:16px;margin-bottom:24px;">
      <div class="sf-card">
        <div class="sf-card-title">Anotações</div>
        <div class="sf-stat-value"><?= $totalNotas ?></div>
        <div class="sf-stat-label">total criadas</div>
      </div>
      <div class="sf-card">
        <div class="sf-card-title">Tempo esta semana</div>
        <div class="sf-stat-value"><?= $weeklyHours ?>h</div>
        <div class="sf-stat-label"><?= $weeklyMinutes ?> minutos de foco</div>
      </div>
      <div class="sf-card">
        <div class="sf-card-title">Categorias</div>
        <div class="sf-stat-value"><?= count($categories) ?></div>
        <div class="sf-stat-label">matérias cadastradas</div>
      </div>
    </div>

    <!-- Notas recentes -->
    <div class="sf-card">
      <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:16px;">
        <div style="font-size:14px;font-weight:700;">Anotações Recentes</div>
        <a href="<?= BASE_URL ?>/notas" style="font-size:13px;color:var(--sf-green);text-decoration:none;font-weight:600;">
          Ver todas →
        </a>
      </div>

      <?php if (empty($recentNotas)): ?>
        <p style="color:var(--sf-muted);font-size:13px;text-align:center;padding:20px 0;">
          Nenhuma anotação ainda.
          <a href="<?= BASE_URL ?>/notas" style="color:var(--sf-green);">Criar primeira nota</a>
        </p>
      <?php else: ?>
        <?php foreach ($recentNotas as $nota): ?>
          <a href="<?= BASE_URL ?>/notas?nota=<?= $nota->id ?>"
             style="display:flex;align-items:center;gap:12px;padding:10px 0;border-bottom:1px solid var(--sf-border);text-decoration:none;color:inherit;">
            <div style="width:36px;height:36px;border-radius:8px;background:<?= $nota->category_color ?? '#e5e7eb' ?>;opacity:.8;flex-shrink:0;"></div>
            <div style="flex:1;min-width:0;">
              <div style="font-weight:600;font-size:13.5px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                <?= htmlspecialchars($nota->title) ?>
              </div>
              <div style="font-size:11px;color:var(--sf-muted);">
                <?= htmlspecialchars($nota->category_name ?? 'Sem categoria') ?>
              </div>
            </div>
            <span style="font-size:11px;color:var(--sf-muted);flex-shrink:0;">
              <?= (new DateTime($nota->updated_at))->format('d/m') ?>
            </span>
          </a>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>

    <!-- Quick links -->
    <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:16px;">
      <a href="<?= BASE_URL ?>/cronometro" class="sf-card" style="text-decoration:none;display:flex;align-items:center;gap:14px;transition:box-shadow .2s;" onmouseover="this.style.boxShadow='0 4px 16px rgba(0,0,0,.1)'" onmouseout="this.style.boxShadow=''">
        <div style="width:44px;height:44px;background:var(--sf-green-light);border-radius:10px;display:flex;align-items:center;justify-content:center;color:var(--sf-green);font-size:20px;">
          <i class="bi bi-clock"></i>
        </div>
        <div>
          <div style="font-weight:700;font-size:14px;">Cronômetro</div>
          <div style="font-size:12px;color:var(--sf-muted);">Sessão Pomodoro</div>
        </div>
      </a>
      <a href="<?= BASE_URL ?>/relatorios" class="sf-card" style="text-decoration:none;display:flex;align-items:center;gap:14px;transition:box-shadow .2s;" onmouseover="this.style.boxShadow='0 4px 16px rgba(0,0,0,.1)'" onmouseout="this.style.boxShadow=''">
        <div style="width:44px;height:44px;background:#eff6ff;border-radius:10px;display:flex;align-items:center;justify-content:center;color:#3b82f6;font-size:20px;">
          <i class="bi bi-bar-chart-line"></i>
        </div>
        <div>
          <div style="font-weight:700;font-size:14px;">Relatórios</div>
          <div style="font-size:12px;color:var(--sf-muted);">Ver progresso</div>
        </div>
      </a>
    </div>

  </div>
</div>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
