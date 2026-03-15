<?php

$router->get('/', ['AuthController', 'login']);
$router->get('/login', ['AuthController', 'login']);
$router->get('/home', ['HomeController', 'index']);