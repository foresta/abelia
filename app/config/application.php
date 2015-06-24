<?php

/*
 * アプリケーションの設定をおこないます
 */
class Application{

    // デバッグモードかどうか
    const IS_DEBUG = true;


    /*
     * アプリケーションの設定を行います
     */
    public function configurate(){

        // for less php ver 5.2.7
        if (!defined('PHP_VERSION_ID')) {
            $version = explode('.', PHP_VERSION);
            define('PHP_VERSION_ID', ($version[0] * 10000 + $version[1] * 100 + $version[2]));
        }

        // for less php ver 5.3.0
        if (PHP_VERSION_ID < 503000 && !defined('__DIR__')){
            define('__DIR__', dirname(__FILE__));
        }

        if (self::IS_DEBUG)
        {    
            // エラー表示の設定
            ini_set('error_reporting', E_ALL);
            ini_set('display_errors', '1');
        }
        
        // タイムゾーンの設定
        ini_set('date.timezone', 'Asia/Tokyo');
        
        // メモリ等の設定
        ini_set('memory_limit', '40M');
        ini_set('post_max_size', '32M');
        ini_set('upload_max_filesize', '32M');
    }

}
