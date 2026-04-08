<?php

$router->get('/', ['AuthController', 'login']);
$router->get('/login', ['AuthController', 'login']);
$router->get('/home', ['HomeController', 'index']);
$router->get('/cronograma', ['CronogramaController', 'index']);
$router->get('/relatorio', ['RelatorioController', 'index']);