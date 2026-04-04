<?php
 session_start();
 $msg = [];
 $error = FALSE;

if($_POST["prenom"]===""){
    $msg [] = "le prenom est obligation";
    $error = TRUE;
}

if($_POST["nom"]===""){
    $msg [] = "le nom est obligation";
    $error = TRUE;
}

if ($error===TRUE){
    $_SESSION["msg"]=$msg;
    $_SESSION["prenom"]=$_POST["prenom"];
     $_SESSION["nom"]=$_POST["nom"];
    header("Location:index.php");
    exit;
}
    

echo $_POST['nom'] ." ".$_POST["prenom"];
  





?>