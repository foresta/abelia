<?php

abstract class RESTApiBase extends BaseController{

  const ID = 'id';

  public function Init(){
    parent::Init();
    $method = Request::requestType();
    switch ($method) {
      case 'GET':
        if (Request::issetQuery(self::ID))
          $this->get(Request::getQuery(self::ID));
        else
          $this->query();
        break;
      case 'POST':
        $this->create();
        break;

      case 'PUT':
        if (Request::issetQuery(self::ID))
          $this->update(Request::getQuery(self::ID));
        break;

      case 'DELETE':
        if (Request::issetQuery(self::ID))
          $this->remove(Request::getQuery(self::ID));
        break;
      default:
        break;
    }
  }

  protected function error404($msg = "not found"){
    header('HTTP/1.1 404 Not Found');
    $this->view->setVar("code", 404)->setVar("message", $msg)->outputJson();
    exit;
  }

  protected function error403($msg = "forbidden"){
    header('HTTP/1.1 403 Forbidden');
    $this->view->setVar("code", 403)->setVar("message", $msg)->outputJson();
    exit;
  }

  protected abstract function query();     // GET
  protected abstract function get($id);    // GET
  protected abstract function create();      // POST
  protected abstract function remove($id); // DELETE
  protected abstract function update($id); // PUT
}
