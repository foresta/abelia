<?php


/*
 * ルーティングを管理するためのクラスです
 */
class Routes {


    /*
     * URIとコントローラのマッピング用配列
     */
    private static $map = array (
        '/' => 'IndexController',

        // 上記のルーティングに該当しない場合以下のデフォルトのコントローラが呼ばれる
        'default' => 'ErrorController'
    );



    /*
     * @params : $requestPath
     *  URIのHOST部分をのぞいたパス
     */ 
    public static function exec($requestPath){
        $controllerFilePath = 
            array_key_exists($requestPath, self::$map) 
                ? self::$map[$requestPath] 
                : self::$map['default'];

        $controllerPathes = explode('/', $controllerFilePath);
        $className = is_array($controllerPathes) 
                        ? array_pop($controllerPathes)
                        : $controllerPathes;

        $filePath = CONTROLLER_DIR . $controllerFilePath . '.php';
        if (file_exists($filePath))
        {
            require_once($filePath);
            new $className;
        }
        else {
            $filePath = CONTROLLER_DIR . self::$map['default'] . '.php';
            require_once($filePath);
            new self::$map['default'];
        }
    }        
}
