<?php

class ErrorJson {

  private $_view;

  public function __construct($view){
    $this->_view = $view;
  }

  public function code($httpStatusCode){
    $message = '';
    switch ($httpStatusCode){
      case 400 :
        $message = 'Bad Request';
        break;
      case 401 :
        $message = 'Unauthorized';
        break;
      case 402 :
        $message = 'Payment Required';
        break;
      case 403 :
        $message = 'Forbidden';
        break;;
      case 404 :
        $message = 'Not Found';
        break;
      default:
        return;
    }

    header('HTTP/1.1 ' . $httpStatusCode ' ' . $message);
    $return = $this->_view->setVar('code', $httpStatusCode)
                   ->setVar('message', $message)
                   ->outputJson();
    exit;
  }
}
