<?php

/*
  キャッシュを管理するためのクラスです
  基本的にRedisを用いているのでサーバーにRedisをインストールする必要があります。
 */
class Cache {

  private static $_redis = null;

  const HOST = "127.0.0.1";
  const PORT = 6379;

  /*
    singleton
   */
  private static function getInstance(){
    // redisのモジュールが読み込まれてなかった場合
    if ( !self::isLoadedModule('redis') ){
      echo "redis is not loaded. please load redis module¥n";
      exit;
    }

    // if ( !isset(self::_redis) || is_null(self::_redis) ) {
      self::$_redis = new Redis();
      $redis->connect(self::HOST,self::PORT);
    // }
    return self::$_redis;
  }

  private static function isLoadedModule($moduleName){
    return extension_loaded($moduleName) && dl("{$moduleName}.so");
  }

  public static function get($key){
    $redis = self::getInstance();
    return $redis->get($key);
  }

  /*
    キャッシュにデータを保存します
   */
  public static function set($key, $value){
    $redis = self::getInstance();
    $redis->set($key, $value);
  }

  /*
    期限つきでキャッシュを保存します
   */
  public static function setWithLimit($key, $value, $limit){
    $redis = self::getInstance();
    $redis->setEx($key, $limit, $value);
  }

}
