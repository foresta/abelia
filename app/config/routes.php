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
//      '/users/list' => '/users/ListController',

        // ��L�̃��[�e�B���O�ɊY�����Ȃ��ꍇ�ȉ��̃f�t�H���g�̃R���g���[�����Ă΂��
        'default' => 'ErrorController'
    );



    /*
     * @params : $requestPath
     *  URI��HOST�������̂������p�X
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
