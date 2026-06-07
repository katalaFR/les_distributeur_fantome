<?php
require_once 'auth.php';
requireManager();

$pdo = getPDO();

// Supprimer une mission
if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    $pdo->prepare("DELETE FROM mission WHERE id_mission = ?")->execute([intval($_GET['delete'])]);
    header('Location: manager_mission.php?deleted=1');
    exit;
}

// Filtre
$filtre = $_GET['statut'] ?? 'tout';
$whereStatut = '';
$params = [];
if ($filtre === 'en_attente') { $whereStatut = "WHERE m.statut_mission = 'en_attente'"; }
elseif ($filtre === 'terminee') { $whereStatut = "WHERE m.statut_mission = 'terminee'"; }
elseif ($filtre === 'en_cours') { $whereStatut = "WHERE m.statut_mission = 'en_cours'"; }

// KPIs
$nbTotal     = $pdo->query("SELECT COUNT(*) FROM mission")->fetchColumn();
$nbAttente   = $pdo->query("SELECT COUNT(*) FROM mission WHERE statut_mission = 'en_attente'")->fetchColumn();
$nbTerminees = $pdo->query("SELECT COUNT(*) FROM mission WHERE statut_mission = 'terminee'")->fetchColumn();

// Liste missions
$missions = $pdo->query("
    SELECT m.id_mission, m.date_mission, m.heure_debut, m.statut_mission,
           d.libelle_distrib, p.prenom AS emp_prenom, p.nom AS emp_nom
    FROM mission m
    JOIN distributeur d ON d.code_dist = m.code_dist
    LEFT JOIN missioner mi ON mi.id_mission = m.id_mission
    LEFT JOIN personne p ON p.id_employe = mi.id_employe
    $whereStatut
    ORDER BY m.date_mission DESC, m.heure_debut ASC
")->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Missions</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body>
<?php include 'sidebar_manager.php'; ?>
<main>
    <header>
        <h1>Gestion des Missions</h1>
        <div class="date"><?= $nbTotal ?> Missions</div>
    </header>

    <?php if (isset($_GET['deleted'])): ?><div class="alert-card" style="margin-bottom:15px;"><p>🗑️ Mission supprimée.</p></div><?php endif; ?>
    <?php if (isset($_GET['created'])): ?><div class="alert-card" style="margin-bottom:15px;background:linear-gradient(135deg,#2d7a2d,#1a4a1a);"><p>✅ Mission créée avec succès.</p></div><?php endif; ?>

    <div class="cards">
        <div class="card"><i class="fa-solid fa-list-check"></i><h3><?= $nbTotal ?></h3><p>Missions totales</p></div>
        <div class="card"><i class="fa-solid fa-clock"></i><h3><?= $nbAttente ?></h3><p>En attente</p></div>
        <div class="card"><i class="fa-solid fa-circle-check"></i><h3><?= $nbTerminees ?></h3><p>Terminées</p></div>
    </div>

    <section class="missions">
        <div class="page-title">
            <h2>Liste des missions</h2>
            <button class="btn-add" onclick="location.href='crée_mission.php'">
                <i class="fa-solid fa-plus"></i> Nouvelle mission
            </button>
        </div>

        <!-- Filtres -->
        <div style="display:flex;gap:10px;flex-wrap:wrap;margin-bottom:15px;">
            <?php foreach (['tout' => 'Toutes', 'en_attente' => 'En attente', 'en_cours' => 'En cours', 'terminee' => 'Terminées'] as $val => $label): ?>
            <a href="?statut=<?= $val ?>" class="btn-action" style="text-decoration:none;<?= $filtre === $val ? 'background:var(--red);' : '' ?>"><?= $label ?></a>
            <?php endforeach; ?>
        </div>

        <div class="table-container">
            <table>
                <tr><th>ID</th><th>Employé</th><th>Distributeur</th><th>Date</th><th>Heure</th><th>Statut</th><th>Actions</th></tr>
                <?php if (empty($missions)): ?>
                <tr><td colspan="7" style="text-align:center;color:#666;">Aucune mission</td></tr>
                <?php else: ?>
                <?php foreach ($missions as $m): ?>
                <tr>
                    <td>#<?= str_pad($m['id_mission'], 3, '0', STR_PAD_LEFT) ?></td>
                    <td><?= htmlspecialchars($m['emp_prenom'] . ' ' . $m['emp_nom']) ?></td>
                    <td><?= htmlspecialchars($m['libelle_distrib']) ?></td>
                    <td><?= date('d/m/Y', strtotime($m['date_mission'])) ?></td>
                    <td><?= substr($m['heure_debut'], 0, 5) ?></td>
                    <td><?= $m['statut_mission'] === 'terminee' ? '✅ Terminée' : ($m['statut_mission'] === 'en_cours' ? '🔄 En cours' : '⏳ En attente') ?></td>
                    <td style="display:flex;gap:8px;">
                        <button class="btn-action" onclick="location.href='detaile_mission.php?id=<?= $m['id_mission'] ?>'">Voir</button>
                        <button class="btn-delete" onclick="if(confirm('Supprimer cette mission ?')) location.href='manager_mission.php?delete=<?= $m['id_mission'] ?>'">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </td>
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
