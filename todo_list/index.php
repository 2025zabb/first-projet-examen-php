<?php
try {
    $pdo = new PDO('sqlite:db.sqlite');
    echo "Connexion établie";

    $sql = "SELECT * FROM tasks ORDER BY id desc, completed ASC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch(Exception $e) {
    die('Erreur : ' . $e->getMessage());
}
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/daisyui@5" rel="stylesheet" type="text/css" />
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <main class="container mx-auto p-4">
        <div>
            <h1 class="text-2xl font-bold mb-4">To Do</h1>
            <a href="formule.php" class="btn btn-outline btn-info">New task</a>
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Completed</th>
                        <th>Created At</th>
                        <th>Due Date</th>
                        <th>Priority</th>
                        <th>Category</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($tasks as $task): ?>
                    <?php $date = DateTime::createFromFormat('Y-m-d H:i:s', $task['created_at']); ?>
                    <?php $duedate = DateTime::createFromFormat('Y-m-d', $task['due_date']); ?>

                    <tr>
                        <td><?= htmlspecialchars($task['id']) ?></td>
                        <td><?= htmlspecialchars($task['title']) ?></td>
                        <td><?= htmlspecialchars($task['description']) ?></td>
                        <td> <a href="completed.php?task=<?php echo ($task['id']) ?>" role="bouton"><?=$task['completed']?></a></td>
                        <td><?= $date ? $date->format('d/m/Y à H:i') : htmlspecialchars($task['created_at']) ?></td>
                        <td><?= $duedate ? $duedate->format('d/m/Y') : htmlspecialchars($task['due_date']) ?></td>
                        <td><?= htmlspecialchars($task['priority']) ?></td>
                        <td><?= htmlspecialchars($task['category']) ?></td>
                        <td>
                            <a href="delete.php?task=<?= htmlspecialchars($task['id']) ?>" role="bouton" class="btn btn-info">x</a>
                            <a href="edit.php?task=<?= htmlspecialchars($task['id']) ?>" role="bouton" class="btn btn-info">edit</a>
                        </td>

                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </main>
</body>
</html>
