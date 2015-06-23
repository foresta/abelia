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

define('VIEW_DIR', APP_DIR . 'views/');
define('CONTROLLER_DIR', APP_DIR . 'controllers/');
define('MODEL_DIR', APP_DIR . 'models');
define('MAIL_TEMPLATE', APP_DIR . 'views/mail/');
define('SHARE_DIR', VIEW_DIR . 'shared/');

// access host define
$isTLS =  Request::issetServer('HTTPS') && Request::getServer('HTTPS') == 'on';
$http = $isTLS ? "https://" : "http://";
define('HOST',  $http . Request::getServer('HTTP_HOST'));

// リクエストされたURIに応じてコントローラを呼び出す
$uri = Request::getServer('REQUEST_URI');
// QueryStringと分ける
$uris = explode('?', $uri);
$uri = $uris[0];

equire_once(CONF_DIR . 'routes.php');
Routes::exec($uri);
exit;
