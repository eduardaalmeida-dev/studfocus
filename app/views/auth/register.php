<?php $pageTitle = 'Criar Conta — StudyFocus'; ?>
<?php require __DIR__ . '/../layouts/header.php'; ?>

<div class="sf-auth-wrap">
  <div class="sf-auth-card">
    <div class="sf-auth-logo">
      <div class="logo-icon"><i class="bi bi-mortarboard-fill"></i></div>
      <span>StudyFocus</span>
    </div>

    <h2>Criar conta</h2>
    <p>Comece a organizar seus estudos hoje.</p>

    <?php if (!empty($flash)): ?>
      <div class="sf-alert <?= $flash['type'] ?>">
        <i class="bi bi-exclamation-circle"></i>
        <?= htmlspecialchars($flash['message']) ?>
      </div>
    <?php endif; ?>

    <form method="POST" action="<?= BASE_URL ?>/register">
      <div class="sf-form-group">
        <label for="name">Nome completo</label>
        <input type="text" id="name" name="name" placeholder="Seu nome" required>
      </div>

      <div class="sf-form-group">
        <label for="email">E-mail</label>
        <input type="email" id="email" name="email" placeholder="seu@email.com" required>
      </div>

      <div class="sf-form-group">
        <label for="password">Senha</label>
        <input type="password" id="password" name="password"
               placeholder="Mínimo 6 caracteres" required minlength="6">
      </div>

      <div class="sf-form-group">
        <label for="password_confirmation">Confirmar senha</label>
        <input type="password" id="password_confirmation" name="password_confirmation"
               placeholder="Repita a senha" required>
      </div>

      <button type="submit" class="sf-btn-full">Criar conta</button>
    </form>

    <div class="sf-auth-link">
      Já tem conta? <a href="<?= BASE_URL ?>/login">Entrar</a>
    </div>
  </div>
</div>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
