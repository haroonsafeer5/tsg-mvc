<?php
session_start();

define('ROOT', dirname(__DIR__));
require ROOT . '/config/config.php';

spl_autoload_register(function (string $class) {
    foreach (['app/Core/', 'app/Controllers/', 'app/Models/'] as $dir) {
        $file = ROOT . '/' . $dir . $class . '.php';
        if (is_file($file)) {
            require $file;
            return;
        }
    }
});

(new Router())->dispatch();