<?php
session_start();

// Variables par défaut pour pré-remplir le formulaire
$nom         = "";
$prenom      = "";
$sexe        = "";
$nationalite = "";
$course      = "";
$date_nai    = "";
$p_sexe      = "";   
$club        = "";

$msg  = [];
$type = [];

// Si on revient de base_1.php avec un message dans la session
if (isset($_SESSION["message"])) {
    // Récupère le texte du message et son type (success / error)
    $msg  = $_SESSION["message"];
    $type = $_SESSION["style_message"];

    // Récupère les anciennes valeurs pour les remettre dans le formulaire
    $nom         = $_SESSION["nom"]         ?? "";
    $prenom      = $_SESSION["prenom"]      ?? "";
    $sexe        = $_SESSION["sexe"]        ?? "";
    $nationalite = $_SESSION["nationalite"] ?? "";
    $course      = $_SESSION["course"]      ?? "";
    $date_nai    = $_SESSION["date_nai"]    ?? "";
    $p_sexe      = $_SESSION["p_sexe"]      ?? "";
    $club        = $_SESSION["club"]        ?? "";

    // On vide les variables de session pour que le message ne reste pas
    unset(
        $_SESSION["message"], $_SESSION["style_message"],
        $_SESSION["nom"], $_SESSION["prenom"], $_SESSION["course"],
        $_SESSION["sexe"], $_SESSION["nationalite"],
        $_SESSION["date_nai"], $_SESSION["p_sexe"], $_SESSION["club"]
    );
}

try {
    // Connexion à la base SQLite
     $pdo = new PDO('sqlite:bd.sqlite');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    //On écupère toutes les personnes (pas forcément utilisé ici, mais correct)
    $sql  = "SELECT * FROM personnes ORDER BY id_personne ASC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);

    //On récupère la liste des courses pour le <select>
    $rqt  = "SELECT nom FROM courses ORDER BY id_course ASC";
    $exu  = $pdo->prepare($rqt);
    $exu->execute();
    $tabs = $exu->fetchAll(PDO::FETCH_ASSOC);

    //On récupère la liste des nationalités distinctes pour le <select>
    $sNat = "SELECT DISTINCT nationalite FROM personnes
             WHERE nationalite IS NOT NULL
             ORDER BY nationalite ASC";
    $Nat  = $pdo->prepare($sNat);
    $Nat->execute();
    $nationalites = $Nat->fetchAll(PDO::FETCH_ASSOC);

} catch (Exception $e) {
    // Si la connexion ou les requêtes échouent, on arrête tout
    die('Erreur : ' . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="fr" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>

    <!-- DaisyUI + Tailwind -->
    <link href="https://cdn.jsdelivr.net/npm/daisyui@5" rel="stylesheet" type="text/css" />
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>

<body class="min-h-screen flex flex-col items-center bg-black">
<div class="w-full max-w-md">

  <!-- NAVBAR -->
  <div class="navbar bg-base-100 shadow-md w-full max-w-4xl mb-6">
    <div class="navbar-start">
      <div class="dropdown">
        <label tabindex="0" class="btn btn-ghost lg:hidden">
          <!-- icône menu -->
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
               viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M4 6h16M4 12h16M4 18h16" />
          </svg>
        </label>
        <ul tabindex="0"
            class="menu menu-sm dropdown-content mt-3 z-[1] p-2 shadow bg-base-100 rounded-box w-52">
          <!--<li><a href="mis_jours.php">Gérer les courses</a></li>-->
          <li><a href="dossards.php">Gérer les dossards</a></li>
          <li><a href="affichage_personne.php">Personnes inscrites</a></li>
        </ul>
      </div>
      <a class="btn btn-ghost text-xl font-bold">Examen</a>
    </div>

    <div class="navbar-end hidden lg:flex">
      <ul class="menu menu-horizontal px-1">
        <!--<li><a href="mis_jours.php">Gérer les courses</a></li>-->
        <li><a href="dossards.php">Gérer les dossards</a></li>
      </ul>
    </div>
  </div>

  <!-- Zone d’alerte (erreur ou succès) -->
  <?php if (!empty($msg)) : ?>
    <div class="alert <?= $type === 'success' ? 'alert-success' : 'alert-error' ?> shadow-lg">
      <div class="flex items-center gap-3">
        <?php if ($type === 'success'): ?>
          <span class="text-2xl">✅</span>
        <?php else: ?>
          <span class="text-2xl">⚠️</span>
        <?php endif; ?>

        <div class="flex flex-col">
          <!-- Un ou plusieurs messages -->
          <?php if (is_array($msg)): ?>
            <?php foreach ($msg as $m): ?>
              <span class="font-semibold"><?= htmlspecialchars($m) ?></span>
            <?php endforeach; ?>
          <?php else: ?>
            <span class="font-semibold"><?= htmlspecialchars($msg) ?></span>
          <?php endif; ?>

          <!-- Détail affiché seulement en cas de succès -->
          <?php if ($type === 'success'): ?>
            <span class="text-sm opacity-80 mt-1">
              Nom : <?= htmlspecialchars($nom) ?> |
              Prénom : <?= htmlspecialchars($prenom) ?> |
              Sexe : <?= htmlspecialchars($sexe) ?> |
              Pays : <?= htmlspecialchars($nationalite) ?> |
              date_naissance : <?= htmlspecialchars($date_nai) ?> | Course : <?= htmlspecialchars($course) ?> |
                Club : <?= htmlspecialchars($club) ?> 
            </span>
          <?php endif; ?>
        </div>
      </div>
    </div>
  <?php endif; ?>

  <!-- Formulaire d’inscription -->
  <form action="base_1.php" method="post" class="card w-full bg-base-100 shadow-xl">
    <fieldset class="card-body space-y-3">
      <legend class="text-2xl font-bold text-center mb-2">
        Inscription
      </legend>

      <!-- Nom -->
      <label for="nom" class="label">
        <span class="label-text">Nom</span>
      </label>
      <input type="text" name="nom" id="nom"
             class="input input-bordered w-full"
             value="<?= htmlspecialchars($nom) ?>">

      <!-- Prénom -->
      <label for="prenom" class="label">
        <span class="label-text">Prénom</span>
      </label>
      <input type="text" name="prenom" id="prenom"
             class="input input-bordered w-full"
             value="<?= htmlspecialchars($prenom) ?>">

      <!-- Sexe (boutons radio) -->
      <span class="label-text mt-2">Sexe</span>
      <div class="flex gap-4 flex-wrap">
        <label class="label cursor-pointer">
          <span class="label-text mr-2">Homme</span>
          <input type="radio" id="homme" name="sexe" value="Homme"
                 class="radio" <?= $p_sexe == 'Homme' ? 'checked' : '' ?>>
        </label>
        <label class="label cursor-pointer">
          <span class="label-text mr-2">Femme</span>
          <input type="radio" id="femme" name="sexe" value="Femme"
                 class="radio" <?= $p_sexe == 'Femme' ? 'checked' : '' ?>>
        </label>
        <label class="label cursor-pointer">
          <span class="label-text mr-2">Autre</span>
          <input type="radio" id="autre" name="sexe" value="autre"
                 class="radio" <?= $p_sexe == 'autre' ? 'checked' : '' ?>>
        </label>
      </div>

      <!-- Date de naissance -->
      <label for="date_nai" class="label">
        <span class="label-text">Date de naissance</span>
      </label>
      <input type="date" name="date_nai" id="date_nai"
             class="input input-bordered w-full"
             value="<?= htmlspecialchars($date_nai ?? '') ?>">

      <!-- Course -->
      <label for="course" class="label">
        <span class="label-text">Course</span>
      </label>
      <select name="course" id="course" class="select select-bordered w-full"value="">
        <?php foreach($tabs as $tab): ?>
          <option value="<?= htmlspecialchars($tab['nom']) ?>"
            <?= ($course == $tab['nom']) ? 'selected' : '' ?>>
            <?= htmlspecialchars($tab['nom']) ?>
          </option>
        <?php endforeach; ?>
      </select>

      <!-- Club -->
      <label for="club" class="label">
        <span class="label-text">Club</span>
      </label>
      <input type="text" name="club" id="club"
             class="input input-bordered w-full"
             value="<?= htmlspecialchars($club) ?>">

      <!-- Case à cocher non partant -->
      <label class="label cursor-pointer" for="non_partant">
        <span class="label-text">Non partant</span>
        <input type="checkbox" name="non_partant" id="non_partant" class="checkbox">
      </label>

      <!-- Nationalité -->
      <label for="nationalite" class="label">
        <span class="label-text">Pays</span>
      </label>
      <select name="nationalite" id="nationalite" class="select select-bordered w-full">
        <?php foreach ($nationalites as $tas): ?>
          <option value="<?= htmlspecialchars($tas['nationalite']) ?>"
            <?= ($nationalite == $tas['nationalite']) ? 'selected' : '' ?>>
            <?= htmlspecialchars($tas['nationalite']) ?>
          </option>
        <?php endforeach; ?>
      </select>

      <!-- Boutons -->
      <div class="card-actions justify-end mt-4">
        <button type="reset" class="btn btn-error btn-outline">Supprimer</button>
        <button type="submit" class="btn btn-primary" name="soumettre">Soumettre</button>
      </div>
    </fieldset>
  </form>

</div>
</body>
</html>
