<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<title>StudFocus - Painel</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>

body{
background:#f4f6f8;
}

.sidebar{
height:100vh;
background:white;
border-right:1px solid #ddd;
}

.timer{
width:220px;
height:220px;
border-radius:50%;
border:12px solid #1fa55b;
display:flex;
align-items:center;
justify-content:center;
font-size:42px;
font-weight:bold;
margin:auto;
}

.menu-link{
padding:12px;
display:block;
border-radius:6px;
text-decoration:none;
color:#555;
margin-bottom:8px;
}

.menu-link.active{
background:#1fa55b;
color:white;
}

.card{
border:none;
border-radius:10px;
}

</style>

</head>

<body>

<div class="container-fluid">
<div class="row">

<!-- SIDEBAR -->

<div class="col-md-2 sidebar p-3">

<h5 class="text-success fw-bold mb-4">⏱ StudyFocus</h5>

<a class="menu-link active">Painel</a>
<a class="menu-link">Cronômetro</a>
<a class="menu-link">Relatórios</a>
<a class="menu-link">Anotações</a>
<a class="menu-link">Arquivos</a>

</div>

<!-- CONTEÚDO -->

<div class="col-md-10 p-4">

<h5 class="mb-4">Sessão de foco</h5>

<div class="row">

<!-- TIMER -->

<div class="col-md-8">

<div class="card p-4 text-center">

<div class="row mb-3">

<div class="col">
<small class="text-muted">Meta diária</small>
<h6>03:00 horas</h6>
</div>

<div class="col">
<small class="text-muted">Ciclos calculados</small>
<h6>6 Pomodoros</h6>
</div>

<div class="col">
<small class="text-muted">Disciplina atual</small>
<h6 class="text-success">História Geral</h6>
</div>

</div>

<div class="timer">
25:00
</div>

<div class="mt-4">

<button class="btn btn-outline-secondary">
Reiniciar
</button>

<button class="btn btn-success mx-2">
Iniciar
</button>

<button class="btn btn-outline-secondary">
Pular
</button>

</div>

</div>

<div class="row mt-3">

<div class="col-md-3">
<div class="card p-3">
<small class="text-muted">Tempo hoje</small>
<h5>01:45</h5>
</div>
</div>

<div class="col-md-3">
<div class="card p-3">
<small class="text-muted">Ciclos completos</small>
<h5>3</h5>
</div>
</div>

<div class="col-md-3">
<div class="card p-3">
<small class="text-muted">Concluídas</small>
<h5>85%</h5>
</div>
</div>

<div class="col-md-3">
<div class="card p-3">
<small class="text-muted">Próxima pausa</small>
<h5>3 ciclos</h5>
</div>
</div>

</div>

</div>

<!-- CHECKLIST -->

<div class="col-md-4">

<div class="card p-3">

<h6 class="mb-3">Checklist da Sessão</h6>

<div class="form-check mb-2">
<input class="form-check-input" type="checkbox">
<label class="form-check-label">
Revisar antecedentes
</label>
</div>

<div class="form-check mb-2">
<input class="form-check-input" type="checkbox">
<label class="form-check-label">
Ler capítulo da Bastilha
</label>
</div>

<div class="form-check mb-2">
<input class="form-check-input" type="checkbox">
<label class="form-check-label">
Resumir declaração dos direitos
</label>
</div>

<div class="form-check mb-2">
<input class="form-check-input" type="checkbox">
<label class="form-check-label">
Fazer exercícios
</label>
</div>

</div>

</div>

</div>

</div>

</div>

</div>
</div>

</body>
</html>