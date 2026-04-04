<html lang="en">
<head>
    <link rel="stylesheet" href="text.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
   

<div class="bob">

<form action="page.php" method="post">
    <fieldset>
        <legend>
            <b>
                infos personnelle
            </b>
        </legend>
        <br>
        <br>
        <label for="name">Name :</label>
        <input type="text" id="name" name="name"  placeholder="Entrez votre nom" required>
        <br>
        <br>
        <label for="firstname">Firstname :</label>
        <input type="text" id="firstname" name="firstname" placeholder="Entrez votre prenom" required>
         <br>
         <br>
        <label for="age">Age :</label>
        <input type="number" id="age" name="age" placeholder="Entre votre age" required>
         <br>
         <br>
        <label for="children">Children :</label>
        <input type="number" id="children" name="enfants" placeholder="Entrez le nombreux d'enfants" required>
         <br>
         <br>
        <input class="push" type="submit" value="envoyer" name="envoyer">
        <input class="push" type="reset" value="effacer" name="effacer">

    </fieldset>
</form>

</div>

</body>
</html>