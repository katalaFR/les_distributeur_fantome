<?php
require_once 'auth.php';
requireLogin();
if (isManager()) { header('Location: index_manager.php'); exit; }

$pdo = getPDO();
$uid = $_SESSION['id_employe'];

// Stats
$stmtStats = $pdo->prepare("
    SELECT
        COUNT(*) AS total,
        SUM(m.statut_mission = 'terminee') AS terminees,
        SUM(MONTH(m.date_mission) = MONTH(CURDATE()) AND YEAR(m.date_mission) = YEAR(CURDATE()) AND m.statut_mission = 'terminee') AS ce_mois
    FROM mission m JOIN missioner mi ON mi.id_mission = m.id_mission
    WHERE mi.id_employe = ?
");
$stmtStats->execute([$uid]);
$stats = $stmtStats->fetch();

// Historique (missions terminées)
$stmtHist = $pdo->prepare("
    SELECT m.id_mission, m.date_mission, m.heure_debut, m.heure_fin, m.statut_mission, d.libelle_distrib
    FROM mission m
    JOIN missioner mi ON mi.id_mission = m.id_mission
    JOIN distributeur d ON d.code_dist = m.code_dist
    WHERE mi.id_employe = ? AND m.statut_mission = 'terminee'
    ORDER BY m.date_mission DESC, m.heure_debut DESC
");
$stmtHist->execute([$uid]);
$historique = $stmtHist->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historique des Missions</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body>
<?php include 'sidebar_employe.php'; ?>
<main>
    <header>
        <h1>Historique des Missions</h1>
        <div class="date"><?= $stats['terminees'] ?> Missions</div>
    </header>
    <div class="cards">
        <div class="card">
            <i class="fa-solid fa-check"></i>
            <h3><?= $stats['terminees'] ?></h3>
            <p>Missions terminées</p>
        </div>
        <div class="card">
            <i class="fa-solid fa-calendar"></i>
            <h3><?= $stats['ce_mois'] ?></h3>
            <p>Ce mois-ci</p>
        </div>
        <div class="card">
            <i class="fa-solid fa-list-check"></i>
            <h3><?= $stats['total'] ?></h3>
            <p>Total assignées</p>
        </div>
    </div>
    <section class="missions">
        <h2>Historique complet</h2>
        <table>
            <tr><th>Mission</th><th>Distributeur</th><th>Date</th><th>Horaires</th><th>Statut</th><th>Détail</th></tr>
            <?php if (empty($historique)): ?>
            <tr><td colspan="6" style="text-align:center;color:#666;">Aucune mission terminée</td></tr>
            <?php else: ?>
            <?php foreach ($historique as $h): ?>
            <tr>
                <td>#<?= str_pad($h['id_mission'], 3, '0', STR_PAD_LEFT) ?></td>
                <td><?= htmlspecialchars($h['libelle_distrib']) ?></td>
                <td><?= date('d/m/Y', strtotime($h['date_mission'])) ?></td>
                <td><?= substr($h['heure_debut'], 0, 5) ?> → <?= substr($h['heure_fin'], 0, 5) ?></td>
                <td>✅ Terminée</td>
                <td><button class="btn-action" onclick="location.href='detaile_mission.php?id=<?= $h['id_mission'] ?>'">Voir</button></td>
            </tr>
            <?php endforeach; ?>
            <?php endif; ?>
        </table>
    </section>
</main>
<script src="script.js"></script>
</body>
</html>
