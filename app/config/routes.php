<?php


/*
 * ���[�e�B���O���Ǘ����邽�߂̃N���X�ł�
 */
class Routes {


    /*
     * URI�ƃR���g���[���̃}�b�s���O�p�z��
     */
    private static $map = array (
        '/' => 'IndexController',

        // ��L�̃��[�e�B���O�ɊY�����Ȃ��ꍇ�ȉ��̃f�t�H���g�̃R���g���[�����Ă΂��
        'default' => 'ErrorController'
    );



    /*
     * @params : $requestPath
     *  URI��HOST�������̂������p�X
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
