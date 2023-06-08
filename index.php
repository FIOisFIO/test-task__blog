<?php
require_once 'db.php';
require_once 'controller.php';
require_once 'mySQLRepo.php';

$db = new DB();
$db->setConnection();


$action = $_SERVER['REQUEST_URI'];

if ($action == '/index.php/' or $action == '/index.php') {
   return readfile('public/index.html');
    
}


require_once 'controllers/users.controller.php';
require_once 'controllers/auth.controller.php';
require_once 'controllers/posts.controller.php';
require_once 'controllers/comments.controller.php';

