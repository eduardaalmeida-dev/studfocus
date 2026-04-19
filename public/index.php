<?php

require_once __DIR__ . '/../core/config.php';

$router = new Router();
require_once __DIR__ . '/../routes/web.php';

$uri        = $_SERVER['REQUEST_URI'];
$base       = parse_url(BASE_URL, PHP_URL_PATH);
$uri        = substr($uri, strlen($base)) ?: '/';
$httpMethod = $_SERVER['REQUEST_METHOD'];

// Allow POST method override via _method field
if ($httpMethod === 'POST' && isset($_POST['_method'])) {
    $httpMethod = strtoupper($_POST['_method']);
}

$router->dispatch($uri, $httpMethod);
