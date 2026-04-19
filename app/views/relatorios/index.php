<?php
$pageTitle = 'Relatórios — StudyFocus';
require __DIR__ . '/../layouts/header.php';
require __DIR__ . '/../layouts/sidebar.php';

$weeklyHours = round($weeklyMinutes / 60, 1);

// Prepare chart data (last 7 days)
$days = [];
$today = new DateTime();
for ($i = 6; $i >= 0; $i--) {
    $d = clone $today;
    $d->modify("-{$i} days");
    $days[$d->format('Y-m-d')] = ['label' => $d->format('d/m'), 'minutes' => 0];
}
foreach ($dailyStats as $stat) {
    if (isset($days[$stat->day])) {
        $days[$stat->day]['minutes'] = (int)$stat->total_minutes;
    }
}
$chartLabels  = array_column($days, 'label');
$chartValues  = array_column($days, 'minutes');
$maxVal       = max($chartValues) ?: 60;
?>

<div class="sf-main">
  <div class="sf-page-wrap">
    <div class="sf-page-title">Relatórios</div>
    <div class="sf-page-sub">Acompanhe sua evolução nos estudos.</div>

    <!-- Summary cards -->
    <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(180px,1fr));gap:16px;margin-bottom:24px;">
      <div class="sf-card">
        <div class="sf-card-title">Esta Semana</div>
        <div class="sf-stat-value"><?= $weeklyHours ?>h</div>
        <div class="sf-stat-label"><?= $weeklyMinutes ?> minutos de foco</div>
      </div>
      <div class="sf-card">
        <div class="sf-card-title">Anotações</div>
        <div class="sf-stat-value"><?= $totalNotas ?></div>
        <div class="sf-stat-label">total acumulado</div>
      </div>
      <div class="sf-card">
        <div class="sf-card-title">Sessões (30 dias)</div>
        <div class="sf-stat-value"><?= count($dailyStats) ?></div>
        <div class="sf-stat-label">dias com estudo</div>
      </div>
    </div>

    <!-- Bar chart (pure CSS/SVG) -->
    <div class="sf-card">
      <div style="font-size:14px;font-weight:700;margin-bottom:20px;">
        Minutos de Estudo — Últimos 7 dias
      </div>

      <div style="display:flex;align-items:flex-end;gap:10px;height:160px;padding-bottom:8px;border-bottom:2px solid var(--sf-border);">
        <?php foreach (array_values($days) as $d): ?>
          <?php $h = $maxVal > 0 ? ($d['minutes'] / $maxVal) * 140 : 0; ?>
          <div style="flex:1;display:flex;flex-direction:column;align-items:center;gap:4px;height:100%;justify-content:flex-end;">
            <?php if ($d['minutes'] > 0): ?>
              <span style="font-size:10px;font-weight:600;color:var(--sf-green);"><?= $d['minutes'] ?>m</span>
            <?php endif; ?>
            <div style="width:100%;background:<?= $d['minutes'] > 0 ? 'var(--sf-green)' : 'var(--sf-border)' ?>;
                        height:<?= max($h, $d['minutes'] > 0 ? 4 : 0) ?>px;
                        border-radius:6px 6px 0 0;
                        transition:height .4s ease;
                        min-height:<?= $d['minutes'] > 0 ? '4px' : '0' ?>;">
            </div>
          </div>
        <?php endforeach; ?>
      </div>

      <div style="display:flex;gap:10px;margin-top:8px;">
        <?php foreach (array_values($days) as $d): ?>
          <div style="flex:1;text-align:center;font-size:11px;color:var(--sf-muted);"><?= $d['label'] ?></div>
        <?php endforeach; ?>
      </div>
    </div>

    <!-- Daily breakdown -->
    <?php if (!empty($dailyStats)): ?>
    <div class="sf-card">
      <div style="font-size:14px;font-weight:700;margin-bottom:16px;">Histórico Detalhado</div>
      <?php foreach (array_reverse($dailyStats) as $stat): ?>
        <div style="display:flex;align-items:center;gap:12px;padding:10px 0;border-bottom:1px solid var(--sf-border);">
          <div style="width:48px;height:48px;background:var(--sf-green-light);border-radius:10px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
            <i class="bi bi-calendar-check" style="color:var(--sf-green);font-size:18px;"></i>
          </div>
          <div style="flex:1;">
            <div style="font-weight:600;font-size:13.5px;">
              <?= (new DateTime($stat->day))->format('d/m/Y — l') ?>
            </div>
            <div style="font-size:12px;color:var(--sf-muted);">
              <?= $stat->sessions ?> sessão(ões) · <?= $stat->total_minutes ?>min
              (<?= round($stat->total_minutes / 60, 1) ?>h)
            </div>
          </div>
          <!-- Progress bar -->
          <div style="width:120px;height:8px;background:var(--sf-border);border-radius:4px;overflow:hidden;">
            <div style="width:<?= min(($stat->total_minutes / 120) * 100, 100) ?>%;height:100%;background:var(--sf-green);border-radius:4px;"></div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
    <?php endif; ?>

  </div>
</div>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
