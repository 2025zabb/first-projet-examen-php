<?php
try {
    // Connexion à la base SQLite
    $pdo = new PDO('sqlite:bd.sqlite');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Requête pour récupérer toutes les personnes + leur maillot
    $rqt = "SELECT  p.id_personne,
                    p.nom,
                    p.prenom,
                    p.sexe,
                    p.date_naissance,
                    p.courses,
                    p.nationalite,
                    m.numero AS numero_maillot
            FROM personnes p
            LEFT JOIN maillots m ON p.id_maillot = m.id_maillot
            WHERE sexe IS NOT NULL
            ORDER BY p.id_personne ASC";

    //On exécute la requête et récupère toutes les lignes dans un tableau associatif
    $exu  = $pdo->prepare($rqt);
    $exu->execute();
    $tabs = $exu->fetchAll(PDO::FETCH_ASSOC);

} catch (Exception $e) {
    // En cas d’erreur, on affiche un message et on arrête le script
    die('Erreur : ' . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="fr" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administration des catégories</title>

    <!-- CSS de DaisyUI + Tailwind -->
    <link href="https://cdn.jsdelivr.net/npm/daisyui@5" rel="stylesheet" type="text/css" />
    <script src="https://cdn.jsdeliver.net/npm/@tailwindcss/browser@4"></script>
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
      <li><a href="mis_jours.php">Gérer les courses</a></li>
      <li><a href="dossards.php">Gérer les dossards</a></li>
    </ul>
  </div>
</div>

<div class="w-full max-w-3xl">
  <div class="card w-full bg-base-100 shadow-xl">
    <div class="card-body">
      <!-- Titre -->
      <h1 class="text-2xl font-bold mb-4 text-center">
        Affichages des personnes inscrits
      </h1>

      <!-- Tableau des personnes -->
      <div class="overflow-x-auto">
       <table class="table table-zebra">
         <thead>
           <tr>
             <th>ID</th>
             <th>Nom</th>
             <th>Prénom</th>
             <th>Sexe</th>
             <th>Date de naissance</th>
             <th>Course</th>
             <th>Nationalité</th>
             <th>Maillot</th>
             <th>Action</th>
           </tr>
         </thead>
         <tbody>
         <?php foreach ($tabs as $tas): ?>
           <tr class="hover">
             <td><?= htmlspecialchars($tas['id_personne']) ?></td>

             <td class="font-semibold"><?= htmlspecialchars($tas['nom']) ?></td>
             <td><?= htmlspecialchars($tas['prenom']) ?></td>
             <td><?= htmlspecialchars($tas['sexe']) ?></td>

             <!-- Date formatée en jj-mm-aaaa -->
             <td>
               <?php
                 $dateBrute = $tas['date_naissance'];            
                 $dat_Af    = date('d-m-Y', strtotime($dateBrute)); 
                 echo htmlspecialchars($dat_Af);
               ?>
             </td>

             <td><?= htmlspecialchars($tas['courses']) ?></td>
             <td><?= htmlspecialchars($tas['nationalite']) ?></td>
             <td><?= htmlspecialchars($tas['numero_maillot']) ?></td>

             <!-- Lien pour modifier la personne -->
             <td>
               <a href="modif_personne.php?id_personne=<?= htmlspecialchars($tas['id_personne']) ?>"
                  class="btn btn-xs btn-info btn-outline">
                 Éditer
               </a>
             </td>
           </tr>
         <?php endforeach; ?>
         </tbody>
       </table>
      </div>

    </div>
  </div>
</div>

</body>
</html>
