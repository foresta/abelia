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
//      '/users/list' => '/users/ListController',

        // 上記のルーティングに該当しない場合以下のデフォルトのコントローラが呼ばれる
        'default' => 'ErrorController'
    );



    /*
     * @params : $requestPath
     *  URIのHOST部分をのぞいたパス
     */ 
    public static function exec($requestPath){
        $controllerClassName = 
            array_key_exists($requestPath, self::map) 
                ? self::map[$requestPath] 
                : self::map['default'];

        $controllerFileName = $controllerName . '.php';
        $filePath = CONTROLLER_DIR . $controllerFileName;
        if (file_exists($filePath))
        {
            require_once($filePath);
            new $controllerClassName;
        }
        else {
            $filePath = CONTROLLER_DIR . $map['default'] . '.php';
            require_once($filePath);
            new $map['default'];
        }
    }        
}
