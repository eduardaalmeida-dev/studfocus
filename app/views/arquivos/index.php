<?php
$pageTitle = 'Arquivos — StudyFocus';
require __DIR__ . '/../layouts/header.php';
require __DIR__ . '/../layouts/sidebar.php';
?>

<div class="sf-main">
  <div class="sf-page-wrap">
    <div class="sf-page-title">Arquivos</div>
    <div class="sf-page-sub">Gerencie documentos, PDFs e anexos dos seus estudos.</div>

    <?php if (!empty($flash)): ?>
      <div class="sf-alert <?= $flash['type'] ?>"><?= htmlspecialchars($flash['message']) ?></div>
    <?php endif; ?>

    <!-- Upload area -->
    <div class="sf-card" style="text-align:center;padding:48px 32px;border:2px dashed var(--sf-border);">
      <i class="bi bi-cloud-arrow-up" style="font-size:48px;color:var(--sf-muted);opacity:.4;display:block;margin-bottom:16px;"></i>
      <div style="font-size:15px;font-weight:700;margin-bottom:6px;">Arraste arquivos aqui</div>
      <div style="font-size:13px;color:var(--sf-muted);margin-bottom:20px;">
        PDF, DOCX, imagens, etc. (máx. 10MB)
      </div>
      <label style="background:var(--sf-green);color:white;padding:10px 24px;border-radius:8px;cursor:pointer;font-weight:600;font-size:13px;">
        <i class="bi bi-plus-lg"></i> Selecionar Arquivo
        <input type="file" style="display:none;" multiple>
      </label>
    </div>

    <!-- Coming soon notice -->
    <div class="sf-card" style="background:var(--sf-green-light);border-color:var(--sf-green);display:flex;align-items:center;gap:14px;">
      <i class="bi bi-info-circle-fill" style="color:var(--sf-green);font-size:22px;flex-shrink:0;"></i>
      <div>
        <div style="font-weight:700;font-size:14px;color:var(--sf-green-dark);">Funcionalidade em desenvolvimento</div>
        <div style="font-size:13px;color:var(--sf-green-dark);opacity:.85;margin-top:2px;">
          O upload e gerenciamento de arquivos estará disponível em breve. 
          Você poderá anexar arquivos diretamente às suas anotações.
        </div>
      </div>
    </div>

  </div>
</div>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
