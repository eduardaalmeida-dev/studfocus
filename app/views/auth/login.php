<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<title>StudFocus - Login</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>

body{
height:100vh;
}

.login-container{
height:100vh;
}

.bg-study{
background:linear-gradient(rgba(0,150,80,0.7),rgba(0,150,80,0.7)),
url('https://images.unsplash.com/photo-1522202176988-66273c2fd55f');
background-size:cover;
background-position:center;
color:white;
display:flex;
align-items:center;
justify-content:center;
flex-direction:column;
text-align:center;
padding:40px;
}

.quote{
font-size:28px;
font-weight:600;
margin-bottom:20px;
}

.tag{
background:rgba(255,255,255,0.2);
padding:6px 14px;
border-radius:20px;
margin:5px;
display:inline-block;
}

.logo{
font-weight:bold;
color:#1fa55b;
font-size:22px;
}

</style>

</head>

<body>

<div class="container-fluid login-container">
<div class="row h-100">

<!-- LOGIN -->

<div class="col-md-5 d-flex align-items-center justify-content-center">

<div style="width:350px">

<div class="logo mb-4">⚡ StudFocus</div>

<h2 class="fw-bold">Hora de seguir.</h2>

<p class="text-muted mb-4">
Entre para gerenciar seus ciclos Pomodoro e atingir suas metas hoje.
</p>

<form>

<div class="mb-3">
<label class="form-label">Seu e-mail</label>
<input type="email" class="form-control" placeholder="aluno@studfocus.com">
</div>

<div class="mb-3">
<label class="form-label">Sua senha</label>
<input type="password" class="form-control">
</div>

<div class="d-flex justify-content-between mb-3">

<div class="form-check">
<input class="form-check-input" type="checkbox">
<label class="form-check-label">
Manter conectado
</label>
</div>

<a href="#" class="small">Esqueceu a senha?</a>

</div>

<button class="btn btn-success w-100 mb-3">
Acessar Plataforma
</button>

<button class="btn btn-outline-secondary w-100">
Entrar com Google
</button>

<p class="text-center mt-3">
Ainda não tem conta?
<a href="#" class="text-success fw-bold">Criar conta grátis</a>
</p>

</form>

</div>

</div>

<!-- IMAGEM -->

<div class="col-md-7 d-none d-md-flex bg-study">

<div>

<div class="quote">
"O segredo do sucesso é a constância do propósito."
</div>

<div>
<span class="tag">Pomodoro</span>
<span class="tag">Estatísticas</span>
<span class="tag">Metas</span>
</div>

</div>

</div>

</div>
</div>

</body>
</html>