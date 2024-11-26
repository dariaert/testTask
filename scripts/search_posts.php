<?php

$connect = mysqli_connect('localhost', 'root', '', 'blog');
if (!$connect) {
    die("Ошибка подключения к БД: " . mysqli_connect_error());
}

$requestBody = $_GET['requestBody'];
if(strlen($requestBody) < 3){
    echo "Длина запроса меньше 3-х символов";
    exit();
}

$query = $connect->query("SELECT posts.title, comments.body FROM comments INNER JOIN posts ON comments.post_id = posts.id WHERE comments.body LIKE '%$requestBody%'");

if(mysqli_num_rows($query) > 0){
    echo "<h2>Результаты поиска: </h2>";
    while ($row = mysqli_fetch_assoc($query)){
        echo "<h3>" . htmlspecialchars($row['title']) . "</h3>";
        echo "<p>" . htmlspecialchars($row['body']) . "</p>";
    }
} else {
    echo "Записей по вашему запросу не найдено";
}