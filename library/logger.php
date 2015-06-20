<?php


class Logger {

  public static function debug($str){
    $str = "[DEBUG]" . DateUtil::now() . "\t" . $str;
    file_put_contents(LOG_DIR . 'log.txt', $str . PHP_EOL, FILE_APPEND);
  }

  public static function info($str){
    $str = "[INFO]" . DateUtil::now() . "\t" . $str;
    file_put_contents(LOG_DIR . 'log.txt', $str . PHP_EOL, FILE_APPEND);
  }

  // TODO : 実行されているファイル名とか行数とか欲しい
  public static function error($str){
    $str = "[ERROR]" . DateUtil::now() . "\t" . $str;
    file_put_contents(LOG_DIR . 'error.txt', $str . PHP_EOL, FILE_APPEND);
  }

  public static function dump($var){
    ob_start();
    var_dump($var);
    $out = ob_get_contents();
    ob_end_clean();
    file_put_contents(LOG_DIR . 'log.txt', "[DUMP]" . DateUtil::now() . "\t" . $out . PHP_EOL, FILE_APPEND);
  }
}
