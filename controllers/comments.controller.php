<?php
$commentsRepo = new mySqlRepo();
$commentsRepo->setDB($db);
$commentsRepo->setTable('comments');

$commentsController = new Controller();
$commentsController->init('comments', 'comments', $commentsRepo);
$commentsController->router->get(function () {
    global $commentsRepo;
    $comments = $commentsRepo->selectAllByFilters(['postId'=>$_REQUEST['postId']]);

    return $comments;
});
$commentsController->router->post(function () {
 
    global $commentsRepo;
    $comment = [
        'postId'=>$_REQUEST['postId'],
        'text'=>$_REQUEST['text'],
        'userId'=>$_REQUEST['userId'],
        'userName'=>$_REQUEST['userName'],
    ];

   return $commentsRepo->createRow($comment);
});