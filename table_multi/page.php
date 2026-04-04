<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
    if(isset($_POST["envoyer"])){
        $nom = $_POST["name"];
        $prenom = $_POST["firstname"];
        $age = $_POST["age"];
        $enfant = $_POST["enfants"];
        
        $nom_= strtoupper($nom);
        $prenom_ = strtoupper($prenom);
        
    }
    ?>

    <form action="recup.php" method="post">

    <?php
    for ($i=0; $i <$enfant ; $i++) { 
        
    }

// <!-- 
//     <input type="hidden" name="nom" value="<?php echo $nom_;?>">
//     <input type="hidden" name="prenom" value="<?php echo $prenom_;?>">
//     <input type="hidden" name="age" value="<?php echo $age;?>">
//     <input type="hidden" name="enfants" value="<?php echo $enfant;?>"> -->



    // <?php
    // for( $i = 0; $i < $enfant;$i++){
    //     echo "Nom : <input type='text' name='enfant_nom[]' required><br>";
    //     echo "Prenom : <input type='text' name='enfant_prenom[]' required><br>";
    //     echo "Age : <input type='number' name='enfant_age[]' required><br>";
    // }
    // ?>
    // <input type="submit" value="Affiche">
    // </form>

    
    
</body>
</html>