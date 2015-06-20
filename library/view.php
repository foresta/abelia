<?php

/*
  テンプレートを表示するクラス
*/
class View {

    private $templateName;
    private $vars;
    private $sanitizedVars;

    public function __construct(){
        $this->vars = array();
        $this->sanitizedVars = array();
    }

    public function display(){
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

    public function setTemplate($name){
        $this->templateName = VIEW_DIR . $name . '.html';
        return $this;
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
