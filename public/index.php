<?php

require_once "../core/Router.php";

require_once "../app/controllers/AuthController.php";
require_once "../app/controllers/HomeController.php";
require_once "../app/controllers/CronogramaController.php";
require_once "../app/controllers/RelatorioController.php";

$router = new Router();

require_once "../routes/web.php";

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

$base = '/studfocus/public';
$uri = str_replace($base, '', $uri);

if($uri == ''){
    $uri = '/';
}

$router->dispatch($uri);