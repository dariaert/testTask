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

$requestBody = $_GET['requestBody'] ?? '';
if(strlen($requestBody) < 3){
    echo "Длина запроса меньше 3-х символов";
    exit();
}

$query = "SELECT posts.title, comments.body FROM comments INNER JOIN posts ON comments.post_id = posts.id WHERE comments.body LIKE ?";
$stmt = $pdo->prepare($query);
$stmt->execute(['%' . $requestBody . '%']);
$resultsData = $stmt->fetchAll();

if(count($resultsData) !== 0){
    echo "<h2>Результаты поиска: </h2>";
    foreach ($resultsData as $result) {
        echo "<h3>" . htmlspecialchars($result['title']) . "</h3>";
        echo "<p>" . htmlspecialchars($result['body']) . "</p>";
    }
} else {
    echo "Записей по вашему запросу не найдено";
}