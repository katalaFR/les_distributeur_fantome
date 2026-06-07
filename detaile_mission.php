<?php
require_once 'auth.php';
requireLogin();

$pdo = getPDO();
$uid = $_SESSION['id_employe'];

$id = intval($_GET['id'] ?? 0);
if (!$id) { header('Location: mission.php'); exit; }

// Vérifier que cette mission appartient bien à l'employé (ou manager)
if (!isManager()) {
    $check = $pdo->prepare("SELECT 1 FROM missioner WHERE id_mission = ? AND id_employe = ?");
    $check->execute([$id, $uid]);
    if (!$check->fetch()) { header('Location: mission.php'); exit; }
}

// Valider un produit (checkbox)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['toggle_produit'])) {
    $idProduit = intval($_POST['id_produit']);
    $fait      = intval($_POST['fait']);
    $stmt = $pdo->prepare("UPDATE relier SET fait = ? WHERE id_mission = ? AND id_produit = ?");
    $stmt->execute([$fait, $id, $idProduit]);
    header("Location: detaile_mission.php?id=$id&saved=1");
    exit;
}

// Terminer la mission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['terminer'])) {
    $pdo->prepare("UPDATE mission SET statut_mission = 'terminee' WHERE id_mission = ?")->execute([$id]);
    header("Location: detaile_mission.php?id=$id&done=1");
    exit;
}

// Démarrer la mission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['demarrer'])) {
    $pdo->prepare("UPDATE mission SET statut_mission = 'en_cours' WHERE id_mission = ?")->execute([$id]);
    header("Location: detaile_mission.php?id=$id");
    exit;
}

// Charger la mission
$stmtM = $pdo->prepare("
    SELECT m.*, d.libelle_distrib, d.adress, d.code_dist,
           td.libelle_distributeur AS type_dist,
           ma.libelle_marque,
           ea.libelle_etat_distributeur AS etat
    FROM mission m
    JOIN distributeur d ON d.code_dist = m.code_dist
    LEFT JOIN type_distributeur td ON td.id_type = d.id_type
    LEFT JOIN marque ma ON ma.id_marque = d.id_marque
    LEFT JOIN etat_distributer ea ON ea.id_etat = d.id_etat
    WHERE m.id_mission = ?
");
$stmtM->execute([$id]);
$mission = $stmtM->fetch();
if (!$mission) { header('Location: mission.php'); exit; }

// Produits de la mission
$stmtP = $pdo->prepare("
    SELECT r.*, p.nom, p.categorie, p.prix_unitaire
    FROM relier r JOIN produit p ON p.id_produit = r.id_produit
    WHERE r.id_mission = ?
    ORDER BY p.nom
");
$stmtP->execute([$id]);
$produits = $stmtP->fetchAll();

$nbFaits = count(array_filter($produits, fn($p) => $p['fait']));
$nbTotal = count($produits);
$pct = $nbTotal > 0 ? round($nbFaits / $nbTotal * 100) : 0;
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mission #<?= str_pad($id, 3, '0', STR_PAD_LEFT) ?></title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body>
<?php include isManager() ? 'sidebar_manager.php' : 'sidebar_employe.php'; ?>
<main>
    <header>
        <h1>Mission #<?= str_pad($id, 3, '0', STR_PAD_LEFT) ?></h1>
        <div class="date"><?= htmlspecialchars(substr($mission['heure_debut'], 0, 5)) ?></div>
    </header>

    <?php if (isset($_GET['done'])): ?>
    <div class="alert-card" style="margin-bottom:20px;"><p>✅ Mission marquée comme terminée !</p></div>
    <?php endif; ?>

    <div class="cards">
        <div class="card">
            <i class="fa-solid fa-location-dot"></i>
            <h3><?= htmlspecialchars($mission['libelle_distrib']) ?></h3>
            <p><?= htmlspecialchars($mission['adress'] ?? '') ?></p>
        </div>
        <div class="card">
            <i class="fa-solid fa-box"></i>
            <h3><?= $nbTotal ?></h3>
            <p>Produits à recharger</p>
        </div>
        <div class="card">
            <i class="fa-solid fa-battery-<?= $pct >= 75 ? 'full' : ($pct >= 50 ? 'half' : ($pct >= 25 ? 'quarter' : 'empty')) ?>"></i>
            <h3><?= $pct ?>%</h3>
            <p>Progression</p>
        </div>
    </div>

    <section class="missions">
        <h2>Produits à recharger</h2>
        <table>
            <tr><th>Produit</th><th>Catégorie</th><th>Quantité</th><th>Fait ✓</th></tr>
            <?php foreach ($produits as $p): ?>
            <tr style="<?= $p['fait'] ? 'opacity:.5;text-decoration:line-through;' : '' ?>">
                <td><?= htmlspecialchars($p['nom']) ?></td>
                <td><?= htmlspecialchars($p['categorie']) ?></td>
                <td><?= $p['qte_produit'] ?></td>
                <td>
                    <?php if ($mission['statut_mission'] !== 'terminee'): ?>
                    <form method="POST" style="display:inline;">
                        <input type="hidden" name="toggle_produit" value="1">
                        <input type="hidden" name="id_produit" value="<?= $p['id_produit'] ?>">
                        <input type="hidden" name="fait" value="<?= $p['fait'] ? 0 : 1 ?>">
                        <button type="submit" style="background:none;border:none;cursor:pointer;font-size:1.4rem;">
                            <?= $p['fait'] ? '✅' : '⬜' ?>
                        </button>
                    </form>
                    <?php else: ?>
                        <?= $p['fait'] ? '✅' : '❌' ?>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    </section>

    <br>

    <section class="missions">
        <h2>Informations distributeur</h2>
        <br>
        <table>
            <tr><th>Champ</th><th>Valeur</th></tr>
            <tr><td>Type</td><td><?= htmlspecialchars($mission['type_dist'] ?? '-') ?></td></tr>
            <tr><td>Marque</td><td><?= htmlspecialchars($mission['libelle_marque'] ?? '-') ?></td></tr>
            <tr><td>État</td><td><?= htmlspecialchars($mission['etat'] ?? '-') ?></td></tr>
            <tr><td>Adresse</td><td><?= htmlspecialchars($mission['adress'] ?? '-') ?></td></tr>
        </table>
    </section>

    <?php if ($mission['commentaire']): ?>
    <br>
    <section class="missions">
        <h2>Commentaire du manager</h2>
        <br>
        <p><?= nl2br(htmlspecialchars($mission['commentaire'])) ?></p>
    </section>
    <?php endif; ?>

    <br>

    <?php if ($mission['statut_mission'] !== 'terminee'): ?>
    <section class="missions">
        <h2>Validation</h2>
        <br>
        <?php if ($mission['statut_mission'] === 'en_attente'): ?>
        <form method="POST">
            <button class="btn-mission" name="demarrer">
                <i class="fa-solid fa-play"></i> Démarrer la mission
            </button>
        </form>
        <br>
        <?php endif; ?>
        <form method="POST" onsubmit="return confirm('Confirmer la fin de la mission ?');">
            <button class="btn-mission" name="terminer" style="background:#2d7a2d;">
                <i class="fa-solid fa-check"></i> Mission terminée
            </button>
        </form>
    </section>
    <?php else: ?>
    <section class="missions">
        <h2 style="color:#2d7a2d;">✅ Mission terminée</h2>
    </section>
    <?php endif; ?>
</main>
<script src="script.js"></script>
</body>
</html>
