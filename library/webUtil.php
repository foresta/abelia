<?php

class WebUtil {

  public static function redirectTo($url){
      header("Location: " . HOST . '/' . $url);
      exit();
  }

  public static function redirectToFullPath($url){
    header("Location: " . $url);
    exit;
  }

  public static function redirectRawUrl(){
      header("Location: " . HOST . Request::getServer("REQUEST_URI"));
  }

  public static function encodeUrl($url){
      return urlencode($url);
  }

  public static function decodeUrl($url){
      return urldecode($url);
  }

  public static function currentUrl(){
      return HOST . Request::getServer("REQUEST_URI");
  }

  public static function beforeUrl(){
      return Request::getServer("HTTP_REFERER");
  }

  public static function isCorrectUrl($url){
    $header = @get_headers($url);
    return preg_match('/^HTTP¥/.*¥s+200¥s/i',$header[0]);
  }


}
