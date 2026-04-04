<?php
setcookie("compteur", "$compteur");
if (isset($_COOKIE["compteur"])) {
    $compteur = $_COOKIE["compteur"] ;
    
} else { 
    
$compteur=1;
   
}$compteur++;




echo "Nombre de visites : " . $compteur;
?>
