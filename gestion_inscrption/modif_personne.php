<?php
if (!isset($_GET['id_personne'])) {
    header('Location: affichage_personne.php');
    exit;
}

$pdo = new PDO('sqlite:bd.sqlite');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$req = "SELECT p.*, m.numero AS n_maillot
        FROM personnes p
        LEFT JOIN maillots m ON p.id_maillot = m.id_maillot
        WHERE p.id_personne = ?";
$traitement = $pdo->prepare($req);
$traitement->execute([$_GET['id_personne']]);
$da_ta = $traitement->fetch(PDO::FETCH_ASSOC);

$req1 = "SELECT nom FROM courses ORDER BY id_course ASC";
$prepa = $pdo->prepare($req1);
$prepa->execute();
$courses = $prepa->fetchAll(PDO::FETCH_ASSOC);

$req2 = "SELECT DISTINCT nationalite FROM personnes 
         WHERE nationalite IS NOT NULL 
         ORDER BY nationalite ASC";
$prepa2 = $pdo->prepare($req2);
$prepa2->execute();
$nationalites = $prepa2->fetchAll(PDO::FETCH_ASSOC);

if (!$da_ta) {
    header('Location: affichage_personne.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <title>Modifier les donnees des personnes inscrites</title>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@5" rel="stylesheet" type="text/css" />
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="min-h-screen flex flex-col items-center bg-black">

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
      <h1 class="text-2xl font-bold text-center">Modifier les infos des inscrits</h1>

      <form action="mis_jour_persons.php" method="POST" class="space-y-4">
        <input type="hidden" name="id_personne"
               value="<?= htmlspecialchars($da_ta['id_personne']) ?>">

        <label class="label" for="nom">
          <span class="label-text">Nom</span>
        </label>
        <input
          type="text"
          name="nom"
          id="nom"
          class="input input-bordered w-full"
          value="<?= htmlspecialchars($da_ta['nom']) ?>"
          required
        >

        <label class="label" for="prenom">
          <span class="label-text">Prenom</span>
        </label>
        <input
          type="text"
          name="prenom"
          id="prenom"
          class="input input-bordered w-full"
          value="<?= htmlspecialchars($da_ta['prenom']) ?>"
        >

        <label class="label" for="sexe">
          <span class="label-text">Sexe</span>
        </label>
        <input
          type="text"
          name="sexe"
          id="sexe"
          class="input input-bordered w-full"
          value="<?= htmlspecialchars($da_ta['sexe']) ?>"
        >

        <label class="label" for="date_naissance">
          <span class="label-text">Date de naissance</span>
        </label>
        <input
          type="date"
          name="date_naissance"
          id="date_naissance"
          class="input input-bordered w-full"
          value="<?= htmlspecialchars($da_ta['date_naissance']) ?>"
        >

        <label class="label" for="course">
          <span class="label-text">Course</span>
        </label>
        <select name="course" id="course"
                class="select select-bordered w-full" required>
          <?php foreach ($courses as $course): ?>
  <option value="<?= htmlspecialchars($course['nom']) ?>"
    <?= $course['nom'] === ($da_ta['nom'] ?? '') ? 'selected' : '' ?>>
    <?= htmlspecialchars($course['nom']) ?>
  </option>
<?php endforeach; ?>

        </select>

        <label class="label" for="nationalite">
          <span class="label-text">Nationalité</span>
        </label>
        <select name="nationalite" id="nationalite"
                class="select select-bordered w-full" required>
          <?php foreach ($nationalites as $nat): ?>
            <option value="<?= htmlspecialchars($nat['nationalite']) ?>"
              <?= $nat['nationalite'] === $da_ta['nationalite'] ? 'selected' : '' ?>>
              <?= htmlspecialchars($nat['nationalite']) ?>
            </option>
          <?php endforeach; ?>
        </select>

        <label class="label" for="maillot">
<label class="label" for="maillot">
  <span class="label-text">Maillot</span>
</label>
<input
  type="text"
  name="maillot"
  id="maillot"
  class="input input-bordered w-full"
  value="<?= htmlspecialchars((string) ($da_ta['n_maillot'] ?? '')) ?>"
>

        

        <div class="card-actions justify-between mt-4">
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
