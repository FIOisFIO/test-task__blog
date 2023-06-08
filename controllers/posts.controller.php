<?php
$postsRepo = new mySqlRepo();
$postsRepo->setDB($db);
$postsRepo->setTable('posts');

$postsController = new Controller();
$postsController->init('posts', 'posts', $postsRepo);
$postsController->router->get(function () {
    global $postsRepo;
    $posts = $postsRepo->getAllRows($_REQUEST['limit'], $_REQUEST['offset']);

    return $posts;
});
$postsController->router->post(function () {
    class PostModel {
        public $text;
        public $userName;
        public $userId;
    }
    global $postsRepo;
    $_POST = json_decode(file_get_contents('php://input'), true);
    $post = new PostModel();
    $post->text = $_POST['text'];
    $post->userName = $_POST['userName'];
    $post->userId = $_POST['userId'];

    return $postsRepo->createRow($post);
});
$postsController->router->put(function () {
    global $postsRepo;
    $id = $_REQUEST['id'];
    $likesCount = $_REQUEST['likesCount'];
    $post = $postsRepo->getByID($id);
    $post->likesCount = $post->likesCount + $likesCount;
    $postsRepo->updateById($post);
    return $postsRepo->getByID($id);
});