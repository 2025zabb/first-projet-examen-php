<?php
// Démarre la session
session_start();

try {
    // Connexion à la base SQLite
    $pdo = new PDO('sqlite:bd.sqlite');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Si on a soumis le formulaire , on récupère les valeurs du formulaire
    if (isset($_POST['ajouter'])) {
      
        $nom         = $_POST['nom'];
        $description = $_POST['description'];

        // on prépare la requête d'insertion d'une nouvelle course
        $req  = "INSERT INTO courses (nom, description) VALUES (?, ?)";
        $stmt = $pdo->prepare($req);
        $stmt->execute([$nom, $description]);

        // Après insertion, on revient sur la même page pour éviter le renvoi de formulaire
        header('Location: adm.php');
        exit;
    }

    // on récupère la liste de toutes les courses pour les afficher dans le tableau
    $rqt = "SELECT id_course, nom, description FROM courses ORDER BY id_course ASC";
    $exu = $pdo->prepare($rqt);
    $exu->execute();
    $tabs = $exu->fetchAll(PDO::FETCH_ASSOC);

} catch (Exception $e) {
    // En cas d’erreur SQL ou autre, on affiche un message et on arrête le script
    die('Erreur : ' . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="fr" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administration des catégories</title>

   
    <link href="https://cdn.jsdelivr.net/npm/daisyui@5" rel="stylesheet" type="text/css" />
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>

<body class="min-h-screen flex flex-col items-center bg-black">

<!-- Barre de navigation -->
<div class="navbar bg-base-100 shadow-md w-full max-w-4xl mb-6">
  <div class="navbar-start">
    <a class="btn btn-ghost text-xl font-bold">Examen</a>
  </div>
  <div class="navbar-end">
    <ul class="menu menu-horizontal px-1">
      <li><a href="index.php">Inscription</a></li>
      <li><a href="dossards.php">Gérer les dossards</a></li>
      <li><a href="affichage_personne.php">Personnes inscrites</a></li>
    </ul>
  </div>
</div>

<div class="w-full max-w-3xl">
  <div class="card w-full bg-base-100 shadow-xl">
    <div class="card-body">

      <!-- Titre de la page -->
      <h1 class="text-2xl font-bold mb-4 text-center">
        Administration des catégories
      </h1>

      <!-- Tableau listant toutes les courses -->
      <div class="overflow-x-auto">
        <table class="table table-zebra">
          <thead>
            <tr>
              <th>ID</th>
              <th>Nom</th>
              <th>Description</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
          <?php foreach ($tabs as $tas): ?>
            <tr class="hover">
           
              <td><?= htmlspecialchars($tas['id_course']) ?></td>

          
              <td class="font-semibold">
                <?= htmlspecialchars($tas['nom']) ?>
              </td>

         
              <td class="max-w-xs truncate">
                <?= htmlspecialchars($tas['description']) ?>
              </td>

              <!-- Liens pour supprimer ou modifier la course -->
              <td>
                <div class="join">
                  <a href="supprimer.php?id_course=<?= htmlspecialchars($tas['id_course']) ?>"
                     class="btn btn-xs btn-error join-item">
                    Supprimer
                  </a>
                  <a href="modif.php?id_course=<?= htmlspecialchars($tas['id_course']) ?>"
                     class="btn btn-xs btn-info btn-outline join-item">
                    Éditer
                  </a>
                </div>
              </td>
            </tr>
          <?php endforeach; ?>
          </tbody>
        </table>

        <!-- Formulaire pour ajouter une nouvelle course -->
        <form action="adm.php" method="post" class="mt-6 space-y-3">
          <label class="label" for="nom">
            <span class="label-text">Nom de la course</span>
          </label>
          <input type="text" name="nom" id="nom" class="input input-bordered w-full">

          <label class="label" for="description">
            <span class="label-text">Description</span>
          </label>
          <input type="text" name="description" id="description" class="input input-bordered w-full">

          <div class="card-actions justify-end">
            <button type="submit" name="ajouter" class="btn btn-primary">Ajouter</button>
          </div>
        </form>

      </div>
    </div>
  </div>
</div>

</body>
</html>
