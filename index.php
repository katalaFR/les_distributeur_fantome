<?php
require_once 'auth.php';
requireLogin();
if (isManager()) { header('Location: index_manager.php'); exit; }

$pdo  = getPDO();
$uid  = $_SESSION['id_employe'];
$user = $_SESSION['user'];
$today = date('Y-m-d');

// Missions du jour
$stmtAujourdhui = $pdo->prepare("
    SELECT COUNT(*) AS nb FROM mission m
    JOIN missioner mi ON mi.id_mission = m.id_mission
    WHERE mi.id_employe = ? AND m.date_mission = ? AND m.statut_mission != 'terminee'
");
$stmtAujourdhui->execute([$uid, $today]);
$nbAujourd_hui = $stmtAujourdhui->fetchColumn();

// Missions terminées total
$stmtTerminees = $pdo->prepare("
    SELECT COUNT(*) FROM mission m
    JOIN missioner mi ON mi.id_mission = m.id_mission
    WHERE mi.id_employe = ? AND m.statut_mission = 'terminee'
");
$stmtTerminees->execute([$uid]);
$nbTerminees = $stmtTerminees->fetchColumn();

// Missions en cours
$stmtEnCours = $pdo->prepare("
    SELECT COUNT(*) FROM mission m
    JOIN missioner mi ON mi.id_mission = m.id_mission
    WHERE mi.id_employe = ? AND m.statut_mission = 'en_cours'
");
$stmtEnCours->execute([$uid]);
$nbEnCours = $stmtEnCours->fetchColumn();

// Mission prioritaire (la prochaine à faire)
$stmtPrio = $pdo->prepare("
    SELECT m.*, d.libelle_distrib FROM mission m
    JOIN missioner mi ON mi.id_mission = m.id_mission
    JOIN distributeur d ON d.code_dist = m.code_dist
    WHERE mi.id_employe = ? AND m.statut_mission = 'en_attente'
    ORDER BY m.date_mission ASC, m.heure_debut ASC LIMIT 1
");
$stmtPrio->execute([$uid]);
$missionPrio = $stmtPrio->fetch();

// Prochaines missions du jour
$stmtMissions = $pdo->prepare("
    SELECT m.id_mission, m.heure_debut, m.statut_mission, d.libelle_distrib
    FROM mission m
    JOIN missioner mi ON mi.id_mission = m.id_mission
    JOIN distributeur d ON d.code_dist = m.code_dist
    WHERE mi.id_employe = ? AND m.date_mission = ?
    ORDER BY m.heure_debut ASC
");
$stmtMissions->execute([$uid, $today]);
$missions = $stmtMissions->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body>
<?php include 'sidebar_employe.php'; ?>
<main>
    <header>
        <h1>Tableau de bord</h1>
        <div class="date"><?= date('d/m/Y') ?></div>
    </header>

    <?php if ($missionPrio): ?>
    <section class="alert-card">
        <h2><i class="fa-solid fa-triangle-exclamation"></i> Mission prioritaire</h2>
        <p>Réapprovisionnement du distributeur <strong><?= htmlspecialchars($missionPrio['libelle_distrib']) ?></strong>
        à <?= htmlspecialchars(substr($missionPrio['heure_debut'], 0, 5)) ?>.</p>
        <button onclick="location.href='detaile_mission.php?id=<?= $missionPrio['id_mission'] ?>'">Voir la mission</button>
    </section>
    <?php endif; ?>

    <section class="cards">
        <div class="card">
            <i class="fa-solid fa-list-check"></i>
            <h3><?= $nbAujourd_hui ?></h3>
            <p>Missions aujourd'hui</p>
        </div>
        <div class="card">
            <i class="fa-solid fa-check"></i>
            <h3><?= $nbTerminees ?></h3>
            <p>Missions terminées</p>
        </div>
        <div class="card">
            <i class="fa-solid fa-truck"></i>
            <h3><?= $nbEnCours ?></h3>
            <p>En cours</p>
        </div>
    </section>

    <section class="missions">
        <h2>Mes prochaines missions</h2>
        <div class="table-container">
            <table>
                <tr>
                    <th>Distributeur</th>
                    <th>Heure</th>
                    <th>Statut</th>
                    <th>Action</th>
                </tr>
                <?php if (empty($missions)): ?>
                <tr><td colspan="4" style="text-align:center;color:#666;">Aucune mission aujourd'hui</td></tr>
                <?php else: ?>
                <?php foreach ($missions as $m): ?>
                <tr>
                    <td><?= htmlspecialchars($m['libelle_distrib']) ?></td>
                    <td><?= htmlspecialchars(substr($m['heure_debut'], 0, 5)) ?></td>
                    <td><?= $m['statut_mission'] === 'terminee' ? '✅ Terminée' : ($m['statut_mission'] === 'en_cours' ? '🔄 En cours' : '📋 À faire') ?></td>
                    <td><button class="btn-action" onclick="location.href='detaile_mission.php?id=<?= $m['id_mission'] ?>'">Voir</button></td>
                </tr>
                <?php endforeach; ?>
                <?php endif; ?>
            </table>
        </div>
    </section>
</main>
<script src="script.js"></script>
</body>
</html>
