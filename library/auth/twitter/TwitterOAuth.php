<?php

class TwitterOAuth {

  private $_apiKey;
  private $_apiSecret;

  private $_accessToken;
  private $_accessTokenSecret;

  private $_callbackUrl;

  const OAUTH_VERSION = '1.0';
  const SIGNATURE_METHOD = 'HMAC-SHA1';

  const ACCESS_TOKEN_URL = "https://api.twitter.com/oauth/access_token";
  const REQUEST_TOKEN_URL = "https://api.twitter.com/oauth/request_token";
  const AUTH_URL = "https://api.twitter.com/oauth/authenticate";
  const INFO_URL = "https://api.twitter.com/1.0/account/settings.json";

  const TOKEN_KEY = "oauth_token";
  const TOKEN_SECRET_KEY = "oauth_token_secret";
  const VERIFIER_KEY = 'oauth_verifier';

  public function __construct($apiKey, $apiSecret, $accessToken = "", $accessTokenSecret = ""){
    $this->_apiKey = $apiKey;
    $this->_apiSecret = $apiSecret;
    $this->_accessToken = $accessToken;
    $this->_accessTokenSecret = $accessTokenSecret;
  }

  public function setCallbackUrl($url){
    $this->_callbackUrl = $url;
  }

  /*
   * Twitter API にアクセスし、request_token, request_token_secretを取得します
   * return $token array('request_token' => *****, 'request_token_secret' => ***)
   */
  public function getRequestToken(){
    $params = $this->getRequestTokenParams();
    $signatureKey = $this->getSignatureKey();
    $params['oauth_signature'] = $this->getSignatureData($params, $signatureKey, self::REQUEST_TOKEN_URL, 'POST');

    $header_params = http_build_query($params, "", ",");
    $response = @file_get_contents(
       self::REQUEST_TOKEN_URL, //[第1引数：リクエストURL]
       false,                   //[第2引数：リクエストURLは相対パスか？(違うのでfalse)]
       stream_context_create(   //[第3引数：stream_context_create()でメソッドとヘッダーを指定]
          array(
             "http" => array(
                "method" => "POST", //リクエストメソッド
                "header" => array(           //カスタムヘッダー
                   "Authorization: OAuth ".$header_params,
                ),
             )
          )
       )
    );

    parse_str($response, $token);
    $request_token[self::TOKEN_KEY] = $token[self::TOKEN_KEY];
    $request_token[self::TOKEN_SECRET_KEY] = $token[self::TOKEN_SECRET_KEY];
    return $request_token;
  }

  /*
   * Twitter API にアクセスし、access_token, access_token_secretを取得します
   * return $token array('access_token' => *****, 'access_token_secret' => *****)
   */
  public function getAccessToken($requestToken, $requestTokenSecret, $verifier){
    $params = $this->getAccessTokenParams($requestToken, $verifier);
    $signatureKey = $this->getSignatureKey($requestTokenSecret);
    $params['oauth_signature'] = $this->getSignatureData($params, $signatureKey, self::ACCESS_TOKEN_URL, 'POST');

    $header_params = http_build_query($params, "", ",");
    $response = @file_get_contents(
       self::ACCESS_TOKEN_URL, //[第1引数：リクエストURL]
       false,                   //[第2引数：リクエストURLは相対パスか？(違うのでfalse)]
       stream_context_create(   //[第3引数：stream_context_create()でメソッドとヘッダーを指定]
          array(
             "http" => array(
                "method" => "POST", //リクエストメソッド
                "header" => array(           //カスタムヘッダー
                   "Authorization: OAuth ".$header_params,
                ),
             )
          )
       )
    );

    parse_str($response, $token);
    return $token;
  }

  public function redirectToAuthUrl($requestToken){
    $params = array(
      'oauth_token' => $requestToken,
    );
    header("Location: " . self::AUTH_URL . '?' . http_build_query($params));
    exit;
  }

  protected function getSignatureKey($secret = ""){
    return rawurlencode($this->_apiSecret) . "&" . rawurlencode($secret);
  }

  protected function getSignatureData($params, $signatureKey, $requestUrl, $method){
    ksort($params);
    $requestParams = rawurlencode(http_build_query($params, "", "&"));
    $encodedRequestMethod = rawurlencode($method);
    $encodedRequestUrl = rawurlencode($requestUrl);
    $signatureData = "{$encodedRequestMethod}&{$encodedRequestUrl}&{$requestParams}";
    $hash = hash_hmac("sha1", $signatureData, $signatureKey, true);
    $signature = base64_encode($hash);
    return $signature;
  }

  private function getAccessTokenParams($requestToken, $verifier){
    $params = array(
      "oauth_consumer_key" => $this->_apiKey,
      "oauth_token" => $requestToken,
      "oauth_signature_method" => self::SIGNATURE_METHOD,
      "oauth_timestamp" => time(),
      "oauth_verifier" => $verifier,
      "oauth_nonce" => md5(microtime() . mt_rand()),
      "oauth_version" => self::OAUTH_VERSION,
    );
    return $this->encodeParamsUrl($params);
  }

  private function getRequestTokenParams(){
    $params = array(
      "oauth_callback" => $this->_callbackUrl,
      "oauth_consumer_key" => $this->_apiKey,
      "oauth_signature_method" => self::SIGNATURE_METHOD,
      "oauth_timestamp" => time(),
      "oauth_nonce" => md5(microtime() . mt_rand()),
      "oauth_varsion" => self::OAUTH_VERSION,
    );
    return $this->encodeParamsUrl($params);
  }

  private function encodeParamsUrl(array $params){
    //各パラメータをURLエンコードする
    foreach($params as $key => $value){
      //コールバックURLだけはここでエンコードしちゃダメ
      if($key == "oauth_callback"){
        continue;
      }
      //URLエンコード処理
      $params[$key] = rawurlencode($value);
    }
    return $params;
  }


}
