<?php

// =============================================
// StudyFocus - Configuration
// =============================================

// Environment
define('ENV', 'development'); // 'production'

// Database
define('DB_HOST', 'localhost');
define('DB_NAME', 'studyfocus');
define('DB_USER', 'root');
define('DB_PASS', '');

// Application
define('BASE_URL', 'http://localhost/studyfocus/public');
define('APP_NAME', 'StudyFocus');

// Paths
define('ROOT_PATH',   dirname(__DIR__));
define('APP_PATH',    ROOT_PATH . '/app');
define('PUBLIC_PATH', ROOT_PATH . '/public');

// Error reporting
if (ENV === 'development') {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
} else {
    error_reporting(0);
    ini_set('display_errors', 0);
}

// Autoload core classes
spl_autoload_register(function (string $class) {
    $paths = [
        ROOT_PATH . "/core/{$class}.php",
        ROOT_PATH . "/app/models/{$class}.php",
        ROOT_PATH . "/app/controllers/{$class}.php",
    ];
    foreach ($paths as $path) {
        if (file_exists($path)) {
            require_once $path;
            return;
        }
    }
});

// Session
session_start();

// Load core
require_once ROOT_PATH . '/core/Database.php';
require_once ROOT_PATH . '/core/Model.php';
require_once ROOT_PATH . '/core/Controller.php';
require_once ROOT_PATH . '/core/Router.php';
