<?php
$currentUser = $user ?? (object)($_SESSION['user'] ?? []);
$initials = '';
if (!empty($currentUser->name)) {
    $parts = explode(' ', $currentUser->name);
    $initials = strtoupper(substr($parts[0], 0, 1) . (isset($parts[1]) ? substr($parts[1], 0, 1) : ''));
}

$navItems = [
    ['href' => '/home',       'icon' => 'bi-grid-1x2',        'label' => 'Painel'],
    ['href' => '/cronometro', 'icon' => 'bi-clock',            'label' => 'Cronômetro'],
    ['href' => '/relatorios', 'icon' => 'bi-bar-chart-line',   'label' => 'Relatórios'],
    ['href' => '/notas',      'icon' => 'bi-journal-text',     'label' => 'Anotações'],
    ['href' => '/arquivos',   'icon' => 'bi-folder2-open',     'label' => 'Arquivos'],
];

$currentUri = strtok($_SERVER['REQUEST_URI'], '?');
$base = parse_url(BASE_URL, PHP_URL_PATH);
$currentUri = substr($currentUri, strlen($base)) ?: '/';
?>

<aside class="sf-sidebar">
  <a href="<?= BASE_URL ?>/home" class="sf-sidebar-logo">
    <div class="logo-icon"><i class="bi bi-mortarboard-fill"></i></div>
    <span>StudyFocus</span>
  </a>

  <nav class="sf-nav">
    <div class="sf-nav-label">Menu</div>
    <?php foreach ($navItems as $item): ?>
      <?php
        $href    = $item['href'];
        $active  = str_starts_with($currentUri, $href) || ($href === '/home' && $currentUri === '/');
      ?>
      <a href="<?= BASE_URL . $href ?>" class="sf-nav-link <?= $active ? 'active' : '' ?>">
        <i class="bi <?= $item['icon'] ?>"></i>
        <?= $item['label'] ?>
      </a>
    <?php endforeach; ?>
  </nav>

  <div class="sf-sidebar-user">
    <div class="sf-avatar">
      <?php if (!empty($currentUser->avatar)): ?>
        <img src="<?= htmlspecialchars($currentUser->avatar) ?>" alt="Avatar">
      <?php else: ?>
        <?= $initials ?>
      <?php endif; ?>
    </div>
    <div class="sf-user-info">
      <div class="sf-user-name"><?= htmlspecialchars($currentUser->name ?? 'Usuário') ?></div>
      <div class="sf-user-plan"><?= htmlspecialchars($currentUser->plan ?? 'Estudante') ?></div>
    </div>
    <a href="<?= BASE_URL ?>/logout" class="sf-logout-btn" title="Sair">
      <i class="bi bi-box-arrow-right"></i>
    </a>
  </div>
</aside>
