<?php
// $file = fopen("fichier.txt","r");
// $content = fgets($file,4096);
// echo $content;
// fclose($file);


// $file = fopen("fichier.txt","r");
// $content = "";
// while(!feof($file)){
// $content .=fgets($file,4598);
// }

// fclose($file);
// echo $content;


$file = fopen("compteur.txt","r+");
    $element = fgets($file,4996);
    
    if ($element == ""){
        $element = 0;
    }
    $element++;
    fclose($file);
    $file = fopen("compteur.txt","a+");
    fwrite($file,$element);
    fclose($file);
    echo  $element;


