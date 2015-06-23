<?php

/*
  テンプレートを表示するクラス
*/
class View {

    private $templateName;
    private $vars;
    private $sanitizedVars;

    private $isSeperate;


    const DEVICE_PC = 1;
    const DEVICE_SP = 2;

    public function __construct(){
        $this->vars = array();
        $this->sanitizedVars = array();
    }

    public function output($isSeperateAssets = false){
        $deviceStr = $this->getDeviceStr($isSeperateAssets);
        
        // define assets directroy path
        define('IMG_DIR',  HOST . $deviceStr . '/images/');
        define('JS_DIR',   HOST . $deviceStr . '/javascripts/');
        define('CSS_DIR',  HOST . $deviceStr . '/stylesheets/');
        define('FONT_DIR', HOST . $deviceStr . '/fonts/');
        $this->sanitizeHtml();
        if($this->sanitizedVars) extract($this->sanitizedVars);
        require_once($this->templateName);
        exit();
    }

    public function setVar($name, $var){
        $this->vars[$name] = $var;
        return $this;
    }

    public function setVars(array $vars){
        if (is_array($vars)){
            $this->vars = array_merge($this->vars, $vars);
        }
        return $this;
    }

    /*
     * htmlのテンプレートファイルを設定します
     * @param : name 
     *     テンプレートファイル名
     * @param : isSeperateDevice
     *     スマートフォンとPCでテンプレートを分けるかどうかのフラグ
     * @return : this
     */
    public function setTemplate($name, $isSeperateDevice = false) {
        $deviceStr = $this->getDeviceStr($isSeperateDevice); 
        $this->templateName = VIEW_DIR . $deviceStr . '/' . $name . '.html';
        return $this;
    }

    protected function getDevice(){
        $ua = $this->getUA();
        if (    strpos($ua, 'iPhone') !== false ||
                (strpos($ua, 'Android') !== false && strpos($ua, 'Mobile') !== false) ||
                strpos($ua, 'Windows Phone') !== false ||
                strpos($ua, 'BlackBerry') !== false
        ) {
            return self::DEVICE_SP; 
        }

        return self::DEVICE_PC;
    }

    private function getDeviceStr($isSeperate){

        if ( !$isSeperate )
            return '';
    
        switch($this->getDevice()){
            case self::DEVICE_PC:
                return 'pc';
            case self::DEVICE_SP:
                return 'sp';
            default:
                return '';
        }
    }

    private function getUA(){
        return Request::getServer('HTTP_USER_AGENT');
    }

    protected function sanitizeHtml(){
        foreach($this->vars as $k => $v){
            $this->sanitizedVars[$k] = $this->h($v);
        }
    }

    protected function h($str){
        if (is_array($str)) {
            return array_map(array($this, "h"), $str);
        } else {
            return htmlspecialchars($str, ENT_QUOTES);
        }
    }

    public function outputJson($isAllowCrossDomain = true){
        header('Content-Type: application/json; charset=utf-8');
        if ($isAllowCrossDomain){
          // API用にクロスドメインを許可
          header('Access-Control-Allow-Origin: *');
          header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept');
        }
        echo json_encode_ex($this->vars, false); // slash is not encoded
        exit();
    }
}
