<?php
require_once 'auth.php';
requireManager();

$pdo = getPDO();

// Supprimer
if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    $pdo->prepare("DELETE FROM distributeur WHERE code_dist = ?")->execute([intval($_GET['delete'])]);
    header('Location: distributeur.php?deleted=1');
    exit;
}

// Stats
$nbTotal      = $pdo->query("SELECT COUNT(*) FROM distributeur")->fetchColumn();
$nbAlerte     = $pdo->query("SELECT COUNT(*) FROM distributeur WHERE id_etat != 1")->fetchColumn();
$nbVilles     = $pdo->query("SELECT COUNT(DISTINCT adress) FROM distributeur")->fetchColumn();

// Filtre par type/état
$filtreType = intval($_GET['type'] ?? 0);
$filtreEtat = intval($_GET['etat'] ?? 0);

$where = "WHERE 1=1";
$params = [];
if ($filtreType) { $where .= " AND d.id_type = ?"; $params[] = $filtreType; }
if ($filtreEtat) { $where .= " AND d.id_etat = ?"; $params[] = $filtreEtat; }

$stmt = $pdo->prepare("
    SELECT d.code_dist, d.libelle_distrib, d.adress,
           td.libelle_distributeur AS type_dist,
           ma.libelle_marque,
           ea.libelle_etat_distributeur AS etat,
           d.id_etat
    FROM distributeur d
    LEFT JOIN type_distributeur td ON td.id_type = d.id_type
    LEFT JOIN marque ma ON ma.id_marque = d.id_marque
    LEFT JOIN etat_distributer ea ON ea.id_etat = d.id_etat
    $where
    ORDER BY d.libelle_distrib
");
$stmt->execute($params);
$distributeurs = $stmt->fetchAll();

$types = $pdo->query("SELECT * FROM type_distributeur")->fetchAll();
$etats = $pdo->query("SELECT * FROM etat_distributer")->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Distributeurs</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body>
<?php include 'sidebar_manager.php'; ?>
<main>
    <header>
        <h1>Distributeurs</h1>
        <div class="date"><?= $nbTotal ?> Machines</div>
    </header>

    <?php if (isset($_GET['deleted'])): ?><div class="alert-card" style="margin-bottom:15px;"><p>🗑️ Distributeur supprimé.</p></div><?php endif; ?>
    <?php if (isset($_GET['saved'])): ?><div class="alert-card" style="margin-bottom:15px;background:linear-gradient(135deg,#2d7a2d,#1a4a1a);"><p>✅ Distributeur enregistré.</p></div><?php endif; ?>

    <div class="cards">
        <div class="card"><i class="fa-solid fa-store"></i><h3><?= $nbTotal ?></h3><p>Distributeurs</p></div>
        <div class="card"><i class="fa-solid fa-triangle-exclamation"></i><h3><?= $nbAlerte ?></h3><p>En alerte</p></div>
        <div class="card"><i class="fa-solid fa-location-dot"></i><h3><?= $nbVilles ?></h3><p>Emplacements</p></div>
    </div>

    <section class="missions">
        <div class="page-title">
            <h2>Liste des distributeurs</h2>
            <button class="btn-add" onclick="location.href='editer_distributeur.php'">
                <i class="fa-solid fa-plus"></i> Nouveau
            </button>
        </div>

        <!-- Filtres -->
        <div style="display:flex;gap:10px;flex-wrap:wrap;margin-bottom:15px;align-items:center;">
            <select onchange="location.href='?type='+this.value+'&etat=<?= $filtreEtat ?>'" style="padding:10px;background:#1a1a1a;color:white;border:none;outline:none;">
                <option value="0">— Tous les types —</option>
                <?php foreach ($types as $t): ?>
                <option value="<?= $t['id_type'] ?>" <?= $filtreType === $t['id_type'] ? 'selected' : '' ?>><?= htmlspecialchars($t['libelle_distributeur']) ?></option>
                <?php endforeach; ?>
            </select>
            <select onchange="location.href='?type=<?= $filtreType ?>&etat='+this.value" style="padding:10px;background:#1a1a1a;color:white;border:none;outline:none;">
                <option value="0">— Tous les états —</option>
                <?php foreach ($etats as $e): ?>
                <option value="<?= $e['id_etat'] ?>" <?= $filtreEtat === $e['id_etat'] ? 'selected' : '' ?>><?= htmlspecialchars($e['libelle_etat_distributeur']) ?></option>
                <?php endforeach; ?>
            </select>
            <?php if ($filtreType || $filtreEtat): ?>
            <a href="distributeur.php" class="btn-action" style="text-decoration:none;">Réinitialiser</a>
            <?php endif; ?>
        </div>

        <div class="table-container">
            <table>
                <tr><th>Nom</th><th>Type</th><th>Marque</th><th>Adresse</th><th>État</th><th>Actions</th></tr>
                <?php if (empty($distributeurs)): ?>
                <tr><td colspan="6" style="text-align:center;color:#666;">Aucun distributeur</td></tr>
                <?php else: ?>
                <?php foreach ($distributeurs as $d): ?>
                <tr>
                    <td><?= htmlspecialchars($d['libelle_distrib']) ?></td>
                    <td><?= htmlspecialchars($d['type_dist'] ?? '-') ?></td>
                    <td><?= htmlspecialchars($d['libelle_marque'] ?? '-') ?></td>
                    <td><?= htmlspecialchars($d['adress'] ?? '-') ?></td>
                    <td style="color:<?= $d['id_etat'] == 1 ? '#2d7a2d' : ($d['id_etat'] == 2 ? '#e6a817' : '#d6001c') ?>;">
                        <?= htmlspecialchars($d['etat']) ?>
                    </td>
                    <td style="display:flex;gap:8px;">
                        <button class="btn-action" onclick="location.href='editer_distributeur.php?id=<?= $d['code_dist'] ?>'">Modifier</button>
                        <button class="btn-delete" onclick="if(confirm('Supprimer ce distributeur ?')) location.href='distributeur.php?delete=<?= $d['code_dist'] ?>'">
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
