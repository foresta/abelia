<?php

class Credentials{
  protected $apiKey = "your api key";
  protected $apiSecret = "your api secret key";
  protected $callbackUrl = "your server callback url";
  protected $owner = "";
  protected $ownerId = "";
  protected $ownerAccessToken = "";
  protected $ownerAccessTokenSecret = "";
  protected $readonlyProperties = array("apiKey", "apiSecret", "callbackUrl", "owner", "ownerId", "ownerAccessToken", "ownerAccessTokenSecret");

  public function __get($name){
    if (in_array($name, $this->readonlyProperties)) return $this->$name;

    return null;
  }
}
