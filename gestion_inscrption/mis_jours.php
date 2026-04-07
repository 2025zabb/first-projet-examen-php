<?php


error_reporting(E_ALL);
ini_set('display_errors', 1);
// Connexion à la base SQLite
 $pdo = new PDO('sqlite:bd.sqlite');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Requête SQL pour modifier une course existante
$req = "UPDATE courses 
        SET nom = ?,
            description = ?
        WHERE id_course = ?";

// Préparation de la requête
$traitement = $pdo->prepare($req);

//On exécution de la requête avec les valeurs envoyées par le formulaire
$traitement->execute([
    $_POST['nom'],        
    $_POST['description'],  
    $_POST['id_course']     
]);

header("Location: adm.php");
exit;
?>
