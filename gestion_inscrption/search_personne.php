<?php
// Connexion à la base SQLite
$pdo = new PDO('sqlite:bd.sqlite');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// On récupère le terme tapé dans l'URL, sinon chaîne vide
$q = isset($_GET['q']) ? trim($_GET['q']) : '';

// Si rien n'est tapé, on renvoie un tableau JSON vide et on arrête
if ($q === '') {
    header('Content-Type: application/json');
    echo json_encode([]);
    exit;
}

// Requête pour chercher les personnes dont le nom commence par $q
$sql = "SELECT id_personne, nom, prenom, sexe, date_naissance, courses, club, nationalite
        FROM personnes
        WHERE nom LIKE ?
        ORDER BY nom ASC
        LIMIT 10";
$stmt = $pdo->prepare($sql);
$stmt->execute([$q . '%']);
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

// On renvoie le résultat au format JSON pour le JavaScript de dossards.php
header('Content-Type: application/json');
echo json_encode($rows);
