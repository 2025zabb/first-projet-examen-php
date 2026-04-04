<?php
$pdo = new PDO('sqlite:db.sqlite');

$sql = "select * from tasks where id = ?";

$stmt = $pdo->prepare($sql);
$stmt->execute([$_GET['task']]);

$data = $stmt->fetch(PDO::FETCH_ASSOC);






?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        
   body {
    display: flex;
    flex-direction: column;      /* Positionne les éléments en colonne */
    justify-content: center;     /* Centre verticalement la colonne dans le body */
    align-items: center;         /* Centre horizontalement chaque enfant */
    height: 100vh;
}

    </style>

</head>
<body>
    <form action="update.php" method="post">
        <input type="hidden" name="id" value="<?=$data['id']?>">
        <label for="title">Title</label>
        <input type="text" name="title" id="title" value="<?=$data["title"]?>">

        <label for="priority">Priority</label>
        <select name="priority" id="priority">
            <option value="<?=$data["priority"]?>" selected><?= ucfirst($data['priority'])?></option>
            <option value="haute">haute</option>
            <option value="moyenne">moyenne</option>
            <option value="base">base</option>
        </select>

        <label for="description">Description</label>
        <input type="text" name="description" id="description"value="<?=$data["description"]?>">

        <label for="date">Due Date</label>
        <input type="date" name="date" id="date" value="<?=$data["date"]?>">

        <label for="category">Category</label>
        <input type="text" name="category" id="category"value="<?=$data["category"]?>">

        <button type="button" href='formule.php'>Retour</button>
        <button type="submit">edit la tache</button>


    </form>
</body>
</html>

