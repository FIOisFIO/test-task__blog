<?php
require 'router.php';
class Controller {
    public $router;

    function init($url, $tableName, $repo) {
        $this->router = new Router();
        $this->router->init($url);
    }

}