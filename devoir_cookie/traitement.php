<?php
if(isset($_POST['couleur'])){

    $fond = $_POST['couleur'];
    setcookie('fond',$fond,time()+88590);
    
}elseif(isset($_COOKIE['fond'])){
    $fond = $_COOKIE['fond'];

}else{
    $fond= "white";
}
?>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>choix du Fond</title>
    <style>
        body{
            background-color: <?php echo $fond; ?>;
           
        }
    </style>
</head>
<body>
    <h1>Fond choisi : <?php echo ucfirst($fond); ?></h1>
    <br>
     <a href="index.php">Retour</a>
</body>
</html>