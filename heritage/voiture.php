<?php

class Voiture {
    public $roue=null;
    public $couleur=null;


public function __construct(){
        $this->roue=4;
        $this->couleur="rouge";
        $this->message=null;
        
    }


public function demarrer():string {
return $message ;
}

public function rouler():string{
return $message ;
}

public function freiner (): string {
return $message ;
}

public function toString (){
return $message = "j'ai une voiture de couleur " . $V->couleur . " et qui a " . $V->roue . " roues.";
}

}