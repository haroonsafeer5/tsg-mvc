<?php
define('BASE_URL', 'http://localhost/tsg-mvc/public');
define('DB_HOST', '127.0.0.1:3307');
define('DB_NAME', 'tsg_mvc');
define('DB_USER', 'root');
define('DB_PASS', '');
define('APP_DEBUG', true);

ini_set('display_errors', APP_DEBUG ? 1 : 0);
error_reporting(E_ALL);