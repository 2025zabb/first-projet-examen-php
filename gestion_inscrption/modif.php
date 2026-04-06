<?php
// Connexion à la base SQLite
 $pdo = new PDO('sqlite:bd.sqlite');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Requête pour récupérer UNE course à partir de son id passé dans l'URL
$req = "SELECT * FROM courses WHERE id_course = ?";
$traitement = $pdo->prepare($req);
$traitement->execute([$_GET['id_course']]);

// On récupère la ligne sous forme de tableau associatif
$da_ta = $traitement->fetch(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <title>Modifier une course</title>

    <!-- CSS DaisyUI + Tailwind -->
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
      <li><a href="adm.php">Gérer les courses</a></li>
      <li><a href="dossards.php">Gérer les dossards</a></li>
    </ul>
  </div>
</div>

<div class="w-full max-w-xl">
  <div class="card bg-base-100 shadow-xl">
    <div class="card-body space-y-4">
      <!-- Titre de la page -->
      <h1 class="text-2xl font-bold text-center">Modifier une course</h1>

      <!-- Formulaire pré-rempli avec les infos de la course -->
      <form action="mis_jours.php" method="POST" class="space-y-4">
        <!-- Id de la course (caché) pour la mise à jour -->
        <input type="hidden" name="id_course"
               value="<?= htmlspecialchars($da_ta['id_course']) ?>">

        <!-- Nom de la course -->
        <label class="label" for="nom">
          <span class="label-text">Nom de la course</span>
        </label>
        <input
          type="text"
          name="nom"
          id="nom"
          class="input input-bordered w-full"
          value="<?= htmlspecialchars($da_ta['nom']) ?>"
          required
        >

        <!-- Description de la course -->
        <label class="label" for="description">
          <span class="label-text">Description</span>
        </label>
        <input
          type="text"
          name="description"
          id="description"
          class="input input-bordered w-full"
          value="<?= htmlspecialchars($da_ta['description']) ?>"
        >

        <!-- Boutons Retour et Éditer -->
        <div class="card-actions justify-between mt-4">
          <a href="adm.php" class="btn btn-ghost">Retour</a>
          <button type="submit" class="btn btn-primary">
            Éditer
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

</body>
</html>
