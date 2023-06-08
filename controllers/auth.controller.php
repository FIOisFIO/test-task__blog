<?php
// Контроллер на данный момент не используется
$usersRepo = new mySqlRepo();
$usersRepo->setDB($db);
$usersRepo->setTable('users');

$loginController = new Controller();
$loginController->init('login', 'users', $usersRepo);
$loginController->router->post(function () {
    class SQLFilters {
        public $login = '';
        public $password = '';
    }
    $creds = new SQLFilters();

    global $usersRepo;
    $creds->login = $_REQUEST['login'];
    $creds->password = $_REQUEST['password'];

    $user = $usersRepo->selectWithFilters($creds);
    if (boolval($user)) {
        return 'Hello, '.$user->name.'!';
    } else {
        return 'Wrong Login or Password';
    }

});

class User {
    public $name;
    public $password;
    public $login;
    
    function create($name, $login, $password) {
        $this->name = $name;
        $this->login = $login;
        $this->password = $password;        
    }
}

$signUpController = new Controller();
$signUpController->init('sign-up', 'users', $usersRepo);
$signUpController->router->post(function () {
    global $usersRepo;

    $user = new User();
    $user->create($_REQUEST['name'], $_REQUEST['login'], $_REQUEST['password']);
    $userId = $usersRepo->createRow($user);

    return $userId;
});
