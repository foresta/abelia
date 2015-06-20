<?php

abstract class ApiBase extends Base{

  public function Init(){
    // if(!Request::isXHR()){
    //   WebUtil::RedirectTo('');
    // }
  }

  protected function getPostedJson($isArray = false){
    $json = file_get_contents("php://input");
    $data = json_decode($json, $isArray);

    return $data;
  }
}