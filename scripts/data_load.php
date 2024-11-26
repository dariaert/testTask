<?php

$connect = mysqli_connect('localhost', 'root', '', 'blog');
if (!$connect) {
    die("Ошибка подключения к БД: " . mysqli_connect_error());
}
$posts = json_decode(file_get_contents('https://jsonplaceholder.typicode.com/posts'), true);
$comments= json_decode(file_get_contents('https://jsonplaceholder.typicode.com/comments'), true);

foreach ($posts as $post) {
    $connect->query("INSERT INTO `posts`(`id`, `user_id`, `title`, `body`) VALUES ('{$post['id']}','{$post['userId']}','{$post['title']}','{$post['body']}')");
}

foreach ($comments as $comment) {
    $connect->query("INSERT INTO `comments`(`id`, `post_id`, `name`, `email`, `body`) VALUES ('{$comment['id']}','{$comment['postId']}','{$comment['name']}','{$comment['email']}','{$comment['body']}')");
}

echo "Загружено " . count($posts) . " записей и " . count($comments) . " комментариев\n";
