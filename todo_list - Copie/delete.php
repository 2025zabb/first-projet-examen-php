<?php
$pdo = new PDO('sqlite:db.sqlite');

    $sql = "DELETE FROM tasks WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        $_GET['task']
    ]);


header("Location: index.php");
exit;
?>
