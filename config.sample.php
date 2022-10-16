<?php

//Setting timezone
date_default_timezone_set('America/Sao_Paulo');

//Setting directory separator
define('DS', DIRECTORY_SEPARATOR);

define('MODE', 'production');
define('PATH_ROOT', dirname(__FILE__) . DS);
define('PATH_PUBLIC', PATH_ROOT . 'public' . DS);
define('PATH_CACHE', PATH_ROOT . 'cache' . DS);
define('PATH_LOGS', PATH_ROOT . 'logs' . DS);
define('PATH_TMP', PATH_ROOT . 'tmp' . DS);
define('PATH_CRON', PATH_ROOT . 'cron' . DS);
define('PATH_UPLOADS', PATH_PUBLIC . 'uploads' . DS);
define('PATH_MIGRATIONS', PATH_ROOT . 'migrations' . DS);
define('PATH_ROUTES', PATH_ROOT . 'routes' . DS);
define('BASE_URL', 'http://localhost:8004');

// url_sdk = https://authfast.com.br/
// url_api = https://authfast.com.br/
// app_key = 1435a7f7f7fd6cd8cee1c1649c32c1f0
// app_secret = D76AC0C7D45E1433FBC429542AC1C3484CD6572C1425FF2885F03CA10DBC34F8

define('SESSION_LIFETIME', (60 * 30));
define('SESSION_NAME', 'authfast');

require PATH_ROOT . 'vendor/autoload.php';
