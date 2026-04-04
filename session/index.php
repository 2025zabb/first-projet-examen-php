<?php 
session_start();
$prenom = null;
$nom = null;
$messager==[];
if(isset($_SESSION["msg"])){
    $messager=$_SESSION['msg'];
    $prenom =$_SESSION["prenom"];
    $nom =$_SESSION['nom'];
    unset($_SESSION['msg']);
    unset($_SESSION["prenom"]);
    unset($_SESSION["nom"]);
}
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
    foreach($messager as $message){
        echo $message;
    }
    ?>
<form action="recup.php" method="post">
<fieldset>
<legend>
<b>
infos personnelle
</b>
</legend>
<label for="prenom">Prenom</label>
<input type="text" name="prenom" placeholder="Entre votre prenom" value="<?php echo $prenom  ?? ''?>">
<br>
<br>
<label for="nom">Nom</label>
<input type="text" name="nom" placeholder="Entre votre nom"  value="<?php echo $nom ?? '' ?>">
<br>
<br>
<input type="submit" value="envoyer">
</fieldset>
</form>
    
</body>
</html>
<?php
