<?php

class Router {
    private $baseHref = '/index.php/';
    private $urlInfo;
    private $action;

    private $isNotCurrentAction = true;

    function init($url) {
        $this->urlInfo = parse_url($_SERVER['REQUEST_URI']);
        $this->action = str_replace($this->baseHref, '', $this->urlInfo['path']);
        $this->isNotCurrentAction = boolval($this->action != $url);

        return $this;
    }
    function get(Closure $callback) {
        if ($this->isNotCurrentAction or $_SERVER['REQUEST_METHOD'] != 'GET') {
            return;
        }
    
        echo json_encode(call_user_func($callback));
    }
    function post(Closure $callback) {
        if ($this->isNotCurrentAction or $_SERVER['REQUEST_METHOD'] != 'POST') {
            return;
        }
    
        echo json_encode(call_user_func($callback));
    }
    function put(Closure $callback) {
        if ($this->isNotCurrentAction or $_SERVER['REQUEST_METHOD'] != 'PUT') {
            return;
        }
        
        echo json_encode(call_user_func($callback));
    }
    function del(Closure $callback) {
        if ($this->isNotCurrentAction or $_SERVER['REQUEST_METHOD'] != 'DELETE') {
            return;
        }
    
        echo call_user_func($callback);
    }
}