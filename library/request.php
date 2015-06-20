<?php
/*
    HTTPrequestを処理するクラス
*/

class Request {

    public static function getQuery($name = ""){
        if($name){
            if(Request::issetQuery($name)){
                return $_GET[$name];
            }
            return null;
        }
        else{
            if(Request::issetQuery()){
                return $_GET;
            }
            return array();
        }
    }

    public static function getPost($name){
        if($name){
            if(Request::issetPost($name)){
                return $_POST[$name];
            }
            return null;
        }
        else{
            if(Request::issetPost()){
                return $_POST;
            }
            return array();
        }
    }

    public static function getServer($name){
        if(isset($_SERVER[$name])){
            return $_SERVER[$name];
        }
        return null;
    }

    public static function issetServer($name){
        return isset($_SERVER[$name]);
    }

    public static function issetQuery($name = ""){
        if($name){
            return isset($_GET[$name]);
        }
        else{
            return isset($_GET);
        }
    }

    public static function issetPost($name = ""){
        if($name){
            return isset($_POST[$name]);
        }
        else{
            return isset($_POST);
        }
    }

    public static function getFile($name){
      if (self::issetFile($name))
        return $_FILES[$name];

      return array();
    }

    public static function issetFile($name){
      return isset($_FILES[$name]["tmp_name"]) && is_uploaded_file($_FILES[$name]["tmp_name"]);
    }

    public static function requestType(){
      return self::getServer('REQUEST_METHOD');
    }

    public static function isPostRequest(){
      return self::requestType() == 'POST';
    }

    public static function isGetRequest(){
      return self::requestType() == 'GET';
    }

    /*
      通信がAjaxで行われているかどうかを取得します
     */
    public static function isXHR(){
        //$xhr = $_SERVER['HTTP_X_REQUESTED_WITH'];
        $xhr = self::getServer('HTTP_X_REQUESTED_WITH');
        return $xhr != null && strtolower($xhr) === 'xmlhttprequest';
    }
}
