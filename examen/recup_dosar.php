<?php
session_start();

// Connexion à la base SQLite
$pdo = new PDO('sqlite:bd.sqlite');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$pdo->exec('PRAGMA foreign_keys = ON');

// Vérifie que le formulaire a bien été soumis
if (!isset($_POST['enregistrer'])) {
    header('Location: dossards.php');
    exit;
}

// On récupère l'id de la personne et le numéro de dossard saisi
$id_personne = $_POST['id_personne'];
$numero      = $_POST['dossard'];

// 1) Créer le maillot si besoin (INSERT OR IGNORE évite le doublon)
$stmt = $pdo->prepare("INSERT OR IGNORE INTO maillots (numero) VALUES (?)");
$stmt->execute([$numero]);

// 2) Récupérer l'id_maillot correspondant à ce numéro
$stmt = $pdo->prepare("SELECT id_maillot FROM maillots WHERE numero = ?");
$stmt->execute([$numero]);
$id_maillot = $stmt->fetchColumn();

// 3) Vérifier si ce maillot est déjà utilisé par une AUTRE personne
$stmt = $pdo->prepare(
    "SELECT COUNT(*) FROM personnes WHERE id_maillot = ? AND id_personne <> ?"
);
$stmt->execute([$id_maillot, $id_personne]);
$deja_utilise = $stmt->fetchColumn();

// 4) Si déjà utilisé : message d'erreur, sinon on met à jour
if ($deja_utilise > 0) {
    $_SESSION['message_type'] = 'error';
    $_SESSION['message']     = "Ce numéro de dossard est déjà attribué à quelqu'un.";
} else {
    $stmt = $pdo->prepare("UPDATE personnes SET id_maillot = ? WHERE id_personne = ?");
    $stmt->execute([$id_maillot, $id_personne]);

    $_SESSION['message_type'] = 'success';
    $_SESSION['message']      = 'Dossard enregistré.';
}

header('Location: dossards.php');
exit;
