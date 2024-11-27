<?php
$host = '127.0.0.1';
$db = 'blog';
$user = 'root';
$pass = '';
$charset = 'utf8';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$opt = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
];
$pdo = new PDO($dsn, $user, $pass, $opt);

$posts = json_decode(file_get_contents('https://jsonplaceholder.typicode.com/posts'), true);
$comments= json_decode(file_get_contents('https://jsonplaceholder.typicode.com/comments'), true);

$queryPosts = $pdo->prepare("INSERT INTO `posts`(`id`, `user_id`, `title`, `body`) VALUES (?, ?, ?, ?)");
foreach ($posts as $post) {
    $queryPosts->execute([$post['id'], $post['userId'], $post['title'], $post['body']]);
}

$queryComments = $pdo->prepare("INSERT INTO `comments`(`id`, `post_id`, `name`, `email`, `body`) VALUES (?, ?, ?, ?, ?)");
foreach ($comments as $comment) {
    $queryComments->execute([$comment['id'], $comment['postId'], $comment['name'], $comment['email'], $comment['body']]);
}

echo "Загружено " . count($posts) . " записей и " . count($comments) . " комментариев\n";
