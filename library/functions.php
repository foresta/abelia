<?php
if ( !function_exists('json_decode') ){
  function json_decode($content, $assoc=false){
    require_once(LIB_DIR . 'Services/JSON.php');
    if ( $assoc ){
      $json = new Services_JSON(SERVICES_JSON_LOOSE_TYPE);
    } else {
      $json = new Services_JSON;
    }
    return $json->decode($content);
  }
}

if ( !function_exists('json_encode') ){
  function json_encode($content){
    require_once(LIB_DIR . 'Services/JSON.php');
    $json = new Services_JSON;

    return $json->encode($content);
  }
}

// スラッシュはエンコードしない
function json_encode_ex($content, $isSlashEncode = true){
  $v = json_encode($content);
  if (!$isSlashEncode){
    // スラッシュのエスケープをアンエスケープする
    $v = preg_replace('/\\\\\//', '/', $v);
  }
  return $v;
}

/*
  文字列が数値に変換可能ならば、変換し不可能ならば変換しません。
 */
function str2int($str){
  $var = $str;
  if (is_numeric($var))
  {
    $var = intval($var);
  }
  return $var;
}

/*
  配列の要素一つ一つをみて、文字列を数値に変換する
 */
function strArr2intArr(array $arr){
  if (!is_array($arr))
    return $arr;

  $newArr = array();
  foreach($arr as $key => $value){
    $newArr[$key] = str2int($value);
  }
  return $newArr;
}
