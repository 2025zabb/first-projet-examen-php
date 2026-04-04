<?php
require "voiture.php";

$V= new Voiture();

echo $V->demarrer();


echo "j'ai une voiture de couleur " . $V->couleur . " et qui a " . $V->roue . " roues.";