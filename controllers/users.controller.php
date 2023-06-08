<?php
$usersRepo = new mySqlRepo();
$usersRepo->setDB($db);
$usersRepo->setTable('users');

$usersController = new Controller();
$usersController->init('users', 'users', $usersRepo);
$usersController->router->get(function () {
    global $usersRepo;
    $users = $usersRepo->getAllRows();

    return $users;
});
$usersController->router->del(function () {
    global $usersRepo;
    $id = $_GET['id'];
    $usersRepo->deleteRow($id);
});