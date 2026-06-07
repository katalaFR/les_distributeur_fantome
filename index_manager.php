<?php
require_once 'auth.php';
requireManager();

$pdo = getPDO();
$uid = $_SESSION['id_employe'];

// KPIs
$nbMissions     = $pdo->query("SELECT COUNT(*) FROM mission")->fetchColumn();
$nbDistrib      = $pdo->query("SELECT COUNT(*) FROM distributeur")->fetchColumn();
$nbEmployes     = $pdo->query("SELECT COUNT(*) FROM employe")->fetchColumn();
$nbAlertes      = $pdo->query("SELECT COUNT(*) FROM mission WHERE statut_mission = 'en_attente'")->fetchColumn();
$nbMaintenance  = $pdo->query("SELECT COUNT(*) FROM distributeur WHERE id_etat = 2")->fetchColumn();
$nbTerminees    = $pdo->query("SELECT COUNT(*) FROM mission WHERE statut_mission = 'terminee'")->fetchColumn();

// Dernières missions
$derniersMissions = $pdo->query("
    SELECT m.id_mission, m.statut_mission, d.libelle_distrib, p.prenom AS employe_prenom, p.nom AS employe_nom
    FROM mission m
    JOIN distributeur d ON d.code_dist = m.code_dist
    LEFT JOIN missioner mi ON mi.id_mission = m.id_mission
    LEFT JOIN personne p ON p.id_employe = mi.id_employe
    ORDER BY m.id_mission DESC LIMIT 5
")->fetchAll();

// Distributeurs nécessitant une intervention
$distribAlert = $pdo->query("
    SELECT d.libelle_distrib, ea.libelle_etat_distributeur AS etat
    FROM distributeur d
    JOIN etat_distributer ea ON ea.id_etat = d.id_etat
    WHERE d.id_etat != 1
")->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Manager</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body>
<?php include 'sidebar_manager.php'; ?>
<main>
    <header>
        <h1>Dashboard Manager</h1>
        <div class="date">Administrateur</div>
    </header>

    <div class="cards">
        <div class="card"><i class="fa-solid fa-list-check"></i><h3><?= $nbMissions ?></h3><p>Missions</p></div>
        <div class="card"><i class="fa-solid fa-store"></i><h3><?= $nbDistrib ?></h3><p>Distributeurs</p></div>
        <div class="card"><i class="fa-solid fa-users"></i><h3><?= $nbEmployes ?></h3><p>Employés</p></div>
    </div>
    <div class="cards">
        <div class="card"><i class="fa-solid fa-triangle-exclamation"></i><h3><?= $nbAlertes ?></h3><p>En attente</p></div>
        <div class="card"><i class="fa-solid fa-screwdriver-wrench"></i><h3><?= $nbMaintenance ?></h3><p>Maintenance</p></div>
        <div class="card"><i class="fa-solid fa-circle-check"></i><h3><?= $nbTerminees ?></h3><p>Terminées</p></div>
    </div>

    <section class="missions">
        <div class="page-title">
            <h2>Dernières missions</h2>
            <button class="btn-add" onclick="location.href='manager_mission.php'">Voir tout</button>
        </div>
        <table>
            <tr><th>ID</th><th>Employé</th><th>Distributeur</th><th>Statut</th><th>Action</th></tr>
            <?php foreach ($derniersMissions as $m): ?>
            <tr>
                <td>#<?= str_pad($m['id_mission'], 3, '0', STR_PAD_LEFT) ?></td>
                <td><?= htmlspecialchars($m['employe_prenom'] . ' ' . $m['employe_nom']) ?></td>
                <td><?= htmlspecialchars($m['libelle_distrib']) ?></td>
                <td><?= $m['statut_mission'] === 'terminee' ? '✅ Terminée' : ($m['statut_mission'] === 'en_cours' ? '🔄 En cours' : '⏳ En attente') ?></td>
                <td><button class="btn-action" onclick="location.href='detaile_mission.php?id=<?= $m['id_mission'] ?>'">Voir</button></td>
            </tr>
            <?php endforeach; ?>
        </table>
    </section>

    <br>

    <section class="missions">
        <h2>Distributeurs nécessitant une intervention</h2>
        <?php if (empty($distribAlert)): ?>
        <p style="text-align:center;color:#2d7a2d;padding:20px;">✅ Tous les distributeurs sont opérationnels</p>
        <?php else: ?>
        <table>
            <tr><th>Distributeur</th><th>Problème</th><th>Action</th></tr>
            <?php foreach ($distribAlert as $d): ?>
            <tr>
                <td><?= htmlspecialchars($d['libelle_distrib']) ?></td>
                <td><?= htmlspecialchars($d['etat']) ?></td>
                <td><button class="btn-action" onclick="location.href='distributeur.php'">Voir</button></td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </section>
</main>
<script src="script.js"></script>
</body>
</html>
