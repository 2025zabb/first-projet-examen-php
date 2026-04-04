<?php
try {
    $pdo = new PDO('sqlite:db.sqlite');
    echo "Connexion établie";

    $sql = "SELECT * FROM tasks ORDER BY completed ASC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch(Exception $e) {
    die('Erreur : ' . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="store.php" method="post">
        <label for="title">Title</label>
        <input type="text" name="title" id="title">

        <label for="priority">Priority</label>
        <select name="priority" id="priority">
            <option value="haute">haute</option>
            <option value="moyenne">moyenne</option>
            <option value="base">base</option>
        </select>

        <label for="description">Description</label>
        <input type="text" name="description" id="description">

        <label for="date">Due Date</label>
        <input type="date" name="date" id="date">

        <label for="category">Category</label>
        <input type="text" name="category" id="category">

        <button type="button" href='formule.php'>Retour</button>
        <button type="submit">creer une tache</button>


    </form>
</body>
</html>
