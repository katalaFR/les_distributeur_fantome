<?php
require_once 'auth.php';
requireLogin();
if (isManager()) { header('Location: index_manager.php'); exit; }

$pdo = getPDO();
$uid = $_SESSION['id_employe'];

// Filtre statut
$filtre = $_GET['statut'] ?? 'tout';
$whereStatut = '';
$params = [$uid];

if ($filtre === 'en_attente') { $whereStatut = "AND m.statut_mission = 'en_attente'"; }
elseif ($filtre === 'en_cours') { $whereStatut = "AND m.statut_mission = 'en_cours'"; }
elseif ($filtre === 'terminee') { $whereStatut = "AND m.statut_mission = 'terminee'"; }

$stmt = $pdo->prepare("
    SELECT m.id_mission, m.date_mission, m.heure_debut, m.statut_mission, d.libelle_distrib, d.adress,
           (SELECT COUNT(*) FROM relier r WHERE r.id_mission = m.id_mission) AS nb_produits
    FROM mission m
    JOIN missioner mi ON mi.id_mission = m.id_mission
    JOIN distributeur d ON d.code_dist = m.code_dist
    WHERE mi.id_employe = ? $whereStatut
    ORDER BY m.date_mission DESC, m.heure_debut ASC
");
$stmt->execute($params);
$missions = $stmt->fetchAll();

// Compter par statut
$stmtCount = $pdo->prepare("
    SELECT statut_mission, COUNT(*) AS nb FROM mission m
    JOIN missioner mi ON mi.id_mission = m.id_mission
    WHERE mi.id_employe = ? GROUP BY statut_mission
");
$stmtCount->execute([$uid]);
$counts = [];
foreach ($stmtCount->fetchAll() as $row) $counts[$row['statut_mission']] = $row['nb'];
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes Missions</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body>
<?php include 'sidebar_employe.php'; ?>
<main>
    <header>
        <h1>Mes Missions</h1>
        <div class="date"><?= count($missions) ?> Mission(s)</div>
    </header>

    <div class="cards">
        <div class="card">
            <i class="fa-solid fa-clock"></i>
            <h3><?= $counts['en_attente'] ?? 0 ?></h3>
            <p>En attente</p>
        </div>
        <div class="card">
            <i class="fa-solid fa-truck"></i>
            <h3><?= $counts['en_cours'] ?? 0 ?></h3>
            <p>En cours</p>
        </div>
        <div class="card">
            <i class="fa-solid fa-check"></i>
            <h3><?= $counts['terminee'] ?? 0 ?></h3>
            <p>Terminées</p>
        </div>
    </div>

    <!-- Filtre -->
    <section class="missions" style="margin-top:20px;padding:15px;">
        <div style="display:flex;gap:10px;flex-wrap:wrap;justify-content:center;">
            <?php foreach (['tout' => 'Toutes', 'en_attente' => 'En attente', 'en_cours' => 'En cours', 'terminee' => 'Terminées'] as $val => $label): ?>
            <a href="?statut=<?= $val ?>" class="btn-action" style="text-decoration:none;<?= $filtre === $val ? 'background:var(--red);' : '' ?>"><?= $label ?></a>
            <?php endforeach; ?>
        </div>
    </section>

    <!-- Cartes missions (vue cards si peu, sinon tableau) -->
    <?php if (!empty($missions) && count($missions) <= 6): ?>
    <div class="cards" style="flex-wrap:wrap;">
        <?php foreach ($missions as $m): ?>
        <div class="card" style="min-width:220px;">
            <i class="fa-solid fa-<?= $m['statut_mission'] === 'terminee' ? 'check' : ($m['statut_mission'] === 'en_cours' ? 'truck' : 'clock') ?>"></i>
            <h3><?= htmlspecialchars(substr($m['heure_debut'], 0, 5)) ?></h3>
            <p><?= htmlspecialchars($m['libelle_distrib']) ?></p>
            <p style="font-size:.8rem;color:#999;"><?= date('d/m/Y', strtotime($m['date_mission'])) ?> · <?= $m['nb_produits'] ?> produit(s)</p>
            <button class="btn-mission" onclick="location.href='detaile_mission.php?id=<?= $m['id_mission'] ?>'">Voir la mission</button>
        </div>
        <?php endforeach; ?>
    </div>
    <?php else: ?>
    <section class="missions">
        <table>
            <tr><th>#</th><th>Distributeur</th><th>Date</th><th>Heure</th><th>Statut</th><th>Action</th></tr>
            <?php if (empty($missions)): ?>
            <tr><td colspan="6" style="text-align:center;color:#666;">Aucune mission</td></tr>
            <?php else: ?>
            <?php foreach ($missions as $m): ?>
            <tr>
                <td>#<?= str_pad($m['id_mission'], 3, '0', STR_PAD_LEFT) ?></td>
                <td><?= htmlspecialchars($m['libelle_distrib']) ?></td>
                <td><?= date('d/m/Y', strtotime($m['date_mission'])) ?></td>
                <td><?= htmlspecialchars(substr($m['heure_debut'], 0, 5)) ?></td>
                <td><?= $m['statut_mission'] === 'terminee' ? '✅ Terminée' : ($m['statut_mission'] === 'en_cours' ? '🔄 En cours' : '📋 À faire') ?></td>
                <td><button class="btn-action" onclick="location.href='detaile_mission.php?id=<?= $m['id_mission'] ?>'">Voir</button></td>
            </tr>
            <?php endforeach; ?>
            <?php endif; ?>
        </table>
    </section>
    <?php endif; ?>
</main>
<script src="script.js"></script>
</body>
</html>
