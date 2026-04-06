<?php
 $pdo = new PDO('sqlite:bd.sqlite');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$id_personne    = $_POST['id_personne'];
$numero_maillot = trim($_POST['maillot']);

// 1) on crée le maillot s’il n’existe pas
$req1 = "INSERT OR IGNORE INTO maillots (numero) VALUES (?)";
$stmt = $pdo->prepare($req1);
$stmt->execute([$numero_maillot]);

// 2)on récupére son id_maillot
$req = "SELECT id_maillot FROM maillots WHERE numero = ?";
$stmt = $pdo->prepare($req);
$stmt->execute([$numero_maillot]);
$id_maillot = $stmt->fetchColumn();

// 3) on met à jour la personne
$req = "UPDATE personnes 
        SET nom = ?,
            prenom = ?,
            sexe = ?,
            date_naissance = ?,
            courses = ?,
            nationalite = ?,
            id_maillot = ?
        WHERE id_personne = ?";
$traitement = $pdo->prepare($req);

$traitement->execute([
    $_POST['nom'],
    $_POST['prenom'],
    $_POST['sexe'],
    $_POST['date_naissance'],
    $_POST['course'],
    $_POST['nationalite'],
    $id_maillot,     
    $id_personne
]);

header("Location: affichage_personne.php");
exit;
