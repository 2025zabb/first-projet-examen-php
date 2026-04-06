<?php
// Connexion à la base SQLite
 $pdo = new PDO('sqlite:bd.sqlite');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Requête SQL pour supprimer une course selon son id passé dans l'URL
$req = "DELETE FROM courses WHERE id_course = ?";
$traitement = $pdo->prepare($req);

// Exécute la suppression avec l'id reçu en GET
$traitement->execute([
    $_GET['id_course']    
]);


header("Location: adm.php");
exit;
?>
