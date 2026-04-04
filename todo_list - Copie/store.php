<?php

$pdo = new PDO('sqlite:db.sqlite');

$sql = "INSERT INTO tasks (title, description, due_date, priority, category, created_at, completed)
        VALUES (?, ?, ?, ?, ?, ?, ?)";


$stmt = $pdo->prepare($sql);


$stmt->execute([
    $_POST['title'],
    $_POST['description'],
    $_POST['due_date'],
    $_POST['priority'],
    $_POST['category'],
    date('Y-m-d H:i:s'), 
    0                  
]);


header("Location: index.php");
exit; 

?>
