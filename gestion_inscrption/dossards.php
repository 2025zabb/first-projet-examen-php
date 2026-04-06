<?php
session_start();

$msg  = null;
$type = null;

if (isset($_SESSION['message'], $_SESSION['message_type'])) {
    $type = $_SESSION['message_type']; 
    $msg  = $_SESSION['message'];
}

unset($_SESSION['message_type'], $_SESSION['message']);


// dossards.php
 $pdo = new PDO('sqlite:bd.sqlite');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$pdo->exec('PRAGMA foreign_keys = ON'); // activation des clés étrangères

// pour le select course
$rqt = "SELECT nom FROM courses ORDER BY id_course ASC" ;
$exu = $pdo->prepare($rqt);
$exu->execute();
$tabs = $exu->fetchAll(PDO::FETCH_ASSOC);

// pour le select nationalité
$sNat = "SELECT DISTINCT nationalite FROM personnes WHERE nationalite IS NOT NULL 
         ORDER BY nationalite ASC";
$Nat = $pdo->prepare($sNat);
$Nat->execute();
$nationalites = $Nat->fetchAll(PDO::FETCH_ASSOC);
?>


<!DOCTYPE html>
<html lang="fr" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <title>Gérer les dossards</title>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@5" rel="stylesheet" type="text/css" />
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="min-h-screen flex flex-col items-center bg-black">

<!-- NAVBAR SIMPLE -->
<div class="navbar bg-base-100 shadow-md w-full max-w-4xl mb-6">
  <div class="navbar-start">
    <a class="btn btn-ghost text-xl font-bold">Examen</a>
  </div>
  <div class="navbar-end">
    <ul class="menu menu-horizontal px-1">
      <li><a href="index.php">Inscription</a></li>
      <li><a href="mis_jours.php">Gérer les courses</a></li>
       <li><a href="affichage_personne.php">Personnes inscrites</a></li>
    </ul>
  </div>
</div>

<div class="w-full max-w-md">
  <div class="card w-full bg-base-100 shadow-xl">
    <div class="card-body space-y-3">

      <h1 class="text-2xl font-bold text-center mb-2">
        Gestion des dossards
      </h1>

      <!-- Barre de recherche + liste en overlay -->
      <label class="label">
        <span class="label-text">Rechercher une personne</span>
      </label>
      <div class="relative">
        <input type="text" id="search"
               class="input input-bordered w-full"
               placeholder="Tape les premières lettres du nom">
        <ul id="suggestions"
            class="menu bg-base-200 rounded-box mt-1 hidden absolute z-50 w-full max-h-60 overflow-y-auto">
        </ul>
      </div>



      <?php if ($msg): ?>
  <div class="alert <?= $type === 'success' ? 'alert-success' : 'alert-error' ?> mb-4">
    <span><?= htmlspecialchars($msg) ?></span>
  </div>
<?php endif; ?>


      <!-- Formulaire rempli automatiquement -->
      <form action="recup_dosar.php" method="post" class="mt-4 space-y-2">
        <input type="hidden" name="id_personne" id="id_personne">

        <label class="label">
          <span class="label-text">Nom</span>
        </label>
        <input type="text" name="nom" id="nom"
               class="input input-bordered w-full" disabled>

        <label class="label">
          <span class="label-text">Prénom</span>
        </label>
        <input type="text" name="prenom" id="prenom"
               class="input input-bordered w-full" disabled>

        <label class="label">
          <span class="label-text">Sexe</span>
        </label>
        <input type="text" name="sexe" id="sexe"
               class="input input-bordered w-full" disabled>

        <label class="label">
          <span class="label-text">Date de naissance</span>
        </label>
        <input type="text" name="date_nai" id="date_nai"
               class="input input-bordered w-full" disabled>

        <label class="label">
          <span class="label-text">Course</span>
        </label>
        <select name="course" id="course" class="select select-bordered w-full" disabled>
          <?php foreach ($tabs as $tab): ?>
            <option value="<?= htmlspecialchars($tab['nom']) ?>">
              <?= htmlspecialchars($tab['nom']) ?>
            </option>
          <?php endforeach; ?>
        </select>

        <label class="label">
          <span class="label-text">Club</span>
        </label>
        <input type="text" name="club" id="club"
               class="input input-bordered w-full" disabled>

        <label class="label">
          <span class="label-text">Nationalité</span>
        </label>
        <select name="nationalite" id="nationalite" class="select select-bordered w-full" disabled>
          <?php foreach ($nationalites as $tas): ?>
            <option value="<?= htmlspecialchars($tas['nationalite']) ?>">
              <?= htmlspecialchars($tas['nationalite']) ?>
            </option>
          <?php endforeach; ?>
        </select>

        <!-- Seul champ modifiable : dossard -->
        <label class="label mt-2">
          <span class="label-text">Dossard</span>
        </label>
        <input type="text" name="dossard" id="dossard"
               class="input input-bordered w-full">

        <div class="card-actions justify-end mt-4">
          <button type="submit" name="enregistrer" class="btn btn-primary">Enregistrer</button>
        </div>
      </form>

    </div>
  </div>
</div>

<script>
// JS pour la recherche dynamique et le remplissage du formulaire
const searchInput  = document.getElementById('search');
const suggList     = document.getElementById('suggestions');

const idField      = document.getElementById('id_personne');
const nomField     = document.getElementById('nom');
const prenomField  = document.getElementById('prenom');
const sexeField    = document.getElementById('sexe');
const dateField    = document.getElementById('date_nai');
const courseField  = document.getElementById('course');
const clubField    = document.getElementById('club');
const natField     = document.getElementById('nationalite');

searchInput.addEventListener('input', async () => {
  const q = searchInput.value.trim();
  if (q.length === 0) {
    suggList.classList.add('hidden');
    suggList.innerHTML = '';
    return;
  }

  const res  = await fetch('search_personne.php?q=' + encodeURIComponent(q));
  const data = await res.json();

  if (data.length === 0) {
    suggList.classList.add('hidden');
    suggList.innerHTML = '';
    return;
  }

  suggList.innerHTML = data.map(p => `
    <li>
      <button type="button"
              class="w-full text-left px-4 py-2"
              data-id="${p.id_personne}"
              data-nom="${p.nom}"
              data-prenom="${p.prenom}"
              data-sexe="${p.sexe}"
              data-date="${p.date_naissance}"
              data-course="${p.courses}"
              data-club="${p.club}"
              data-nat="${p.nationalite}">
        ${p.nom} ${p.prenom}
      </button>
    </li>
  `).join('');
  suggList.classList.remove('hidden');

  // clique sur une suggestion
  suggList.querySelectorAll('button').forEach(btn => {
    btn.addEventListener('click', () => {
      idField.value      = btn.dataset.id || '';
      nomField.value     = btn.dataset.nom || '';
      prenomField.value  = btn.dataset.prenom || '';
      sexeField.value    = btn.dataset.sexe || '';
      dateField.value    = btn.dataset.date || '';
      clubField.value    = btn.dataset.club || '';

      Array.from(courseField.options).forEach(opt => {
        opt.selected = (opt.value === btn.dataset.course);
      });

      Array.from(natField.options).forEach(opt => {
        opt.selected = (opt.value === btn.dataset.nat);
      });

      suggList.classList.add('hidden');
      suggList.innerHTML = '';
      searchInput.value = (btn.dataset.nom || '') + ' ' + (btn.dataset.prenom || '');
    });
  });
});
</script>
</body>
</html>
