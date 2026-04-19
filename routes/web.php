<?php

// =============================================
// StudyFocus - Routes
// =============================================

// AUTH
$router->get('/login',    'AuthController', 'loginForm');
$router->post('/login',   'AuthController', 'login');
$router->get('/register', 'AuthController', 'registerForm');
$router->post('/register','AuthController', 'register');
$router->get('/logout',   'AuthController', 'logout');

// HOME / DASHBOARD
$router->get('/',         'HomeController', 'index');
$router->get('/home',     'HomeController', 'index');

// NOTAS (ANOTAÇÕES)
$router->get('/notas',            'NotasController', 'index');
$router->post('/notas',           'NotasController', 'store');
$router->post('/notas/{id}',      'NotasController', 'update');
$router->post('/notas/{id}/delete','NotasController','destroy');
$router->get('/notas/busca',      'NotasController', 'search');

// CRONÔMETRO
$router->get('/cronometro',            'CronometroController', 'index');
$router->post('/cronometro/salvar',    'CronometroController', 'store');

// RELATÓRIOS
$router->get('/relatorios',  'RelatoriosController', 'index');

// ARQUIVOS
$router->get('/arquivos',    'ArquivosController', 'index');
