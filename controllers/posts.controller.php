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
    $post = new PostModel();

    $post->text = $_REQUEST['text'];
    $post->userName = $_REQUEST['userName'];
    $post->userId = $_REQUEST['userId'];

    return $postsRepo->createRow($post);
});
$postsController->router->put(function () {
    global $postsRepo;
    $id = $_REQUEST['id'];
    $likesCount = $_REQUEST['likesCount'];
    $post = $postsRepo->getByID($id);
    $post->likesCount = $post->likesCount + $likesCount;
    $postsRepo->updateById($post);

    return $post;
});