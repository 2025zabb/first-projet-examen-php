<?php
$pdo = new PDO('sqlite:db.sqlite');


    $sql = "UPDATE tasks SET completed=1 where id= ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        $_GET['task']
    ]);


header("Location: index.php");
exit;
?>
