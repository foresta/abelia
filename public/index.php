<?php

// for less php ver 5.2.7
if (!defined('PHP_VERSION_ID')) {
    $version = explode('.', PHP_VERSION);

    define('PHP_VERSION_ID', ($version[0] * 10000 + $version[1] * 100 + $version[2]));
}

// for less php ver 5.3.0
if (PHP_VERSION_ID < 503000 && !defined('__DIR__')){
  define('__DIR__', dirname(__FILE__));
}

// エラー表示の設定
ini_set('error_reporting', E_ALL);
ini_set('display_errors', '1');
ini_set('date.timezone', 'Asia/Tokyo');

// メモリ等の設定
ini_set('memory_limit', '40M');
ini_set('post_max_size', '32M');
ini_set('upload_max_filesize', '32M');

// system DIR define
define('APP_DIR',  __DIR__ . '/../app/');
define('LIB_DIR',  __DIR__ . '/../library/');
define('CONF_DIR', APP_DIR . 'config/');
define('QUERY_DIR', APP_DIR . 'sqls/');
define('LOG_DIR', __DIR__ . '/../log/');
define('TEMP_DIR', __DIR__ . '/../temp/');
define('PUBLIC_DIR', __DIR__ . '/../public/');

// library file
require_once(LIB_DIR . 'request.php');
require_once(LIB_DIR . 'base.php');
require_once(LIB_DIR . 'apiBase.php');
require_once(LIB_DIR . 'restApiBase.php');
require_once(LIB_DIR . 'view.php');
require_once(LIB_DIR . 'database.php');
require_once(LIB_DIR . 'logger.php');
require_once(LIB_DIR . 'mailer.php');
require_once(LIB_DIR . 'session.php');
require_once(LIB_DIR . 'webUtil.php');
require_once(LIB_DIR . 'textUtil.php');
require_once(LIB_DIR . 'dateUtil.php');
require_once(LIB_DIR . 'functions.php');
require_once(LIB_DIR . 'query.php');
require_once(LIB_DIR . 'cache.php');

// UserAgentに応じて処理を切り分ける
$ua = Request::getServer('HTTP_USER_AGENT');
$carr = '';
if (strpos($ua, 'iPhone') !== false ||
    (strpos($ua, 'Android') !== false && strpos($ua, 'Mobile') !== false) ||
    strpos($ua, 'Windows Phone') !== false ||
    strpos($ua, 'BlackBerry') !== false
    ) {
    $carr = 'sp';
}
else {
    $carr = 'pc';
}

$http = "";
if ( Request::issetServer('HTTPS') && Request::getServer('HTTPS') == 'on')
    $http = "https://";
else
    $http = "http://";

define('VIEW_DIR', APP_DIR . 'views/');
define('CONTROLLER_DIR', APP_DIR . 'controllers/');
define('MODEL_DIR', APP_DIR . 'models');
define('MAIL_TEMPLATE', APP_DIR . 'views/mail/');
define('SHARE_DIR', VIEW_DIR . 'shared/');

// access host define
define('HOST',  $http . Request::getServer('HTTP_HOST'));

// リクエストされたURIに応じてコントローラを呼び出す
$uri = Request::getServer('REQUEST_URI');
$uri = preg_replace("/\/$/", "", $uri);

// QueryStringと分ける
$uris = explode('?', $uri);
$uri = $uris[0];
$uri = preg_replace('/^\//', '', $uri);

if(empty($uri)){
    $uri = 'index';
}

$className = str_replace(' ', '_', ucwords(str_replace('/', ' ', $uri)));
$filepath = CONTROLLER_DIR . $uri . '.php';
if(file_exists($filepath)){
    require_once($filepath);
    new $className;
}
else{
    header('HTTP/1.1 404 Not Found');
    require_once(__DIR__ . '/' . $carr . '/error.html');
}
