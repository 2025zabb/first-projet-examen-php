<?php
session_start();


$message = [];
$erreur  = false;

try {
    // Connexion à la base SQLite
    $pdo = new PDO('sqlite:bd.sqlite');;
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // On vérifie que le formulaire a bien été soumis
    if (isset($_POST['soumettre'])) {

        // Vérif NOM
        if (empty($_POST["nom"])) {
            $message[] = "Erreur : il faut mettre le nom";
            $erreur = true;
        }

        // Vérif PRÉNOM
        if (empty($_POST["prenom"])) {
            $message[] = "Erreur : il faut mettre le prenom";
            $erreur = true;
        }

        // Vérif SEXE
        if (empty($_POST["sexe"])) {
            $message[] = "Erreur : il faut choisir le sexe";
            $erreur = true;
        }

        // Vérif DATE DE NAISSANCE
        if (empty($_POST["date_nai"])) {
            $message[] = "Erreur : il faut mettre la date de naissance";
            $erreur = true;
        } else {
        $date_naissance = $_POST["date_nai"];
    
        // Vérifie si c'est une vraie date
        $d = DateTime::createFromFormat('Y-m-d', $date_naissance);
         if (!$d || $d > new DateTime()) {
        $message[] = "Erreur : date invalide ou dans le futur";
        $erreur = true;
        }
        }


        // Vérif COURSE
        if (empty($_POST["course"])) {
            $message[] = "Erreur : il faut choisir une course";
            $erreur = true;
        }

        // Vérif NATIONALITÉ
        if (empty($_POST["nationalite"])) {
            $message[] = "Erreur : il faut choisir une nationalité";
            $erreur = true;
        }

        // Si  erreur  on stocke les messages et on revient à index.php
        if ($erreur) {
        $_SESSION["style_message"] = "error";
         $_SESSION["message"]       = $message;

        $_SESSION["date_nai"]    = $_POST["date_nai"] ?? "";
        $_SESSION["p_sexe"]      = $_POST["sexe"]  ?? "";
        $_SESSION["nom"]         = $_POST["nom"] ;
        $_SESSION["prenom"]      = $_POST["prenom"] ;
        $_SESSION["course"]      = $_POST["course"] ;
        $_SESSION["nationalite"] = $_POST["nationalite"] ;
        $_SESSION["club"]        = $_POST["club"] ;

       header("Location:index.php");
        exit;

        }

      
        $nom            = $_POST["nom"];
        $prenom         = $_POST["prenom"];
        $sexe           = $_POST["sexe"];
        $date_nai       = $_POST["date_nai"];
        $course         = $_POST["course"];
        $club           = $_POST["club"];
        $nationalite    = $_POST["nationalite"];

        
        // permet de savoir si la case a été cochée dans le formulaire
        $non_partant    = isset($_POST["non_partant"]) ? 1 : 0;

       
        //  INSERTION dans la table'personnes'
       
        $sql = "INSERT INTO personnes 
                (nom, prenom, sexe, date_naissance, courses, club, nationalite, non_partant)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

        // Préparation de la requête SQL
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            $nom,
            $prenom,
            $sexe,
            $date_nai,
            $course,
            $club,
            $nationalite,
            $non_partant
        ]);

        
        // On prépare un message de succès et quelques infos à afficher sur index.php
        $_SESSION["style_message"] = "success";
        $_SESSION["message"] = "Vous êtes inscrit avec ces informations :";
        $_SESSION["nom"]           = $nom;
        $_SESSION["prenom"]        = $prenom;
        $_SESSION["sexe"]          = $sexe;
        $_SESSION["nationalite"]   = $nationalite;
        $_SESSION["date_nai"] = $date_nai;
        $_SESSION["course"]   = $course;
         $_SESSION["club"]   = $club;


        // On retourne sur le formulaire après insertion
       header("Location: index.php");
        exit;


    }

} catch (Exception $th) {

    die("erreur " . $th->getMessage());
}
