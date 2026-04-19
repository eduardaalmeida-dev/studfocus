<?php $pageTitle = 'Login — StudyFocus'; ?>
<?php require __DIR__ . '/../layouts/header.php'; ?>

<div class="sf-auth-wrap">
  <div class="sf-auth-card">
    <div class="sf-auth-logo">
      <div class="logo-icon"><i class="bi bi-mortarboard-fill"></i></div>
      <span>StudyFocus</span>
    </div>

    <h2>Entrar na conta</h2>
    <p>Bem-vindo(a) de volta! Informe seus dados.</p>

    <?php if (!empty($flash)): ?>
      <div class="sf-alert <?= $flash['type'] ?>">
        <i class="bi bi-exclamation-circle"></i>
        <?= htmlspecialchars($flash['message']) ?>
      </div>
    <?php endif; ?>

    <form method="POST" action="<?= BASE_URL ?>/login">
      <div class="sf-form-group">
        <label for="email">E-mail</label>
        <input type="email" id="email" name="email"
               placeholder="seu@email.com" required autocomplete="email">
      </div>

      <div class="sf-form-group">
        <label for="password">Senha</label>
        <input type="password" id="password" name="password"
               placeholder="••••••••" required autocomplete="current-password">
      </div>

      <button type="submit" class="sf-btn-full">Entrar</button>
    </form>

    <div class="sf-auth-link">
      Não tem conta? <a href="<?= BASE_URL ?>/register">Criar conta grátis</a>
    </div>

    <div class="sf-auth-link" style="margin-top:10px;font-size:12px;color:#aaa;">
      Demo: <strong>ana@studyfocus.com</strong> / <strong>password</strong>
    </div>
  </div>
</div>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
