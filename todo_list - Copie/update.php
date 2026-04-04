<?php

$pdo = new PDO('sqlite:db.sqlite');

$sql = " UPDATE tasks 
set title =?,
description =?, 
due_date = ?, 
priority = ?, 
category =?

where id =?";

$stmt = $pdo->prepare($sql);


$stmt->execute([
    $_POST['title'],
    $_POST['description'],
    $_POST['due_date'],
    $_POST['priority'],
    $_POST['category'],
    $_POST['id']
                     
]);


header("Location: index.php");
exit; 

?>
