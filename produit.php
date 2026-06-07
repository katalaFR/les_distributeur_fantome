<?php
require_once 'auth.php';
requireManager();

$pdo = getPDO();

// Supprimer
if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    $pdo->prepare("DELETE FROM produit WHERE id_produit = ?")->execute([intval($_GET['delete'])]);
    header('Location: produit.php?deleted=1');
    exit;
}

// Stats
$nbTotal    = $pdo->query("SELECT COUNT(*) FROM produit")->fetchColumn();
$nbBoissons = $pdo->query("SELECT COUNT(*) FROM produit WHERE categorie = 'Boisson'")->fetchColumn();
$nbSnacks   = $pdo->query("SELECT COUNT(*) FROM produit WHERE categorie = 'Snack'")->fetchColumn();
$nbCafes    = $pdo->query("SELECT COUNT(*) FROM produit WHERE categorie = 'Café'")->fetchColumn();

// Filtre catégorie
$filtreCat = $_GET['cat'] ?? '';
$where     = '';
$params    = [];
if ($filtreCat) { $where = "WHERE categorie = ?"; $params[] = $filtreCat; }

$stmt = $pdo->prepare("SELECT * FROM produit $where ORDER BY categorie, nom");
$stmt->execute($params);
$produits = $stmt->fetchAll();

$categories = $pdo->query("SELECT DISTINCT categorie FROM produit ORDER BY categorie")->fetchAll(PDO::FETCH_COLUMN);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produits</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body>
<?php include 'sidebar_manager.php'; ?>
<main>
    <header>
        <h1>Produits</h1>
        <div class="date"><?= $nbTotal ?> Produits</div>
    </header>

    <?php if (isset($_GET['deleted'])): ?><div class="alert-card" style="margin-bottom:15px;"><p>🗑️ Produit supprimé.</p></div><?php endif; ?>
    <?php if (isset($_GET['saved'])): ?><div class="alert-card" style="margin-bottom:15px;background:linear-gradient(135deg,#2d7a2d,#1a4a1a);"><p>✅ Produit enregistré.</p></div><?php endif; ?>

    <div class="cards">
        <div class="card"><i class="fa-solid fa-bottle-water"></i><h3><?= $nbTotal ?></h3><p>Produits</p></div>
        <div class="card"><i class="fa-solid fa-mug-hot"></i><h3><?= $nbCafes ?></h3><p>Cafés</p></div>
        <div class="card"><i class="fa-solid fa-cookie-bite"></i><h3><?= $nbSnacks ?></h3><p>Snacks</p></div>
    </div>

    <section class="missions">
        <div class="page-title">
            <h2>Catalogue Produits</h2>
            <button class="btn-add" onclick="location.href='editer_produit.php'">
                <i class="fa-solid fa-plus"></i> Nouveau Produit
            </button>
        </div>

        <!-- Filtre catégorie -->
        <div style="display:flex;gap:10px;flex-wrap:wrap;margin-bottom:15px;">
            <a href="produit.php" class="btn-action" style="text-decoration:none;<?= !$filtreCat ? 'background:var(--red);' : '' ?>">Tous</a>
            <?php foreach ($categories as $cat): ?>
            <a href="?cat=<?= urlencode($cat) ?>" class="btn-action" style="text-decoration:none;<?= $filtreCat === $cat ? 'background:var(--red);' : '' ?>"><?= htmlspecialchars($cat) ?></a>
            <?php endforeach; ?>
        </div>

        <div class="table-container">
            <table>
                <tr><th>Nom</th><th>Catégorie</th><th>Prix</th><th>Actions</th></tr>
                <?php if (empty($produits)): ?>
                <tr><td colspan="4" style="text-align:center;color:#666;">Aucun produit</td></tr>
                <?php else: ?>
                <?php foreach ($produits as $p): ?>
                <tr>
                    <td><?= htmlspecialchars($p['nom']) ?></td>
                    <td><?= htmlspecialchars($p['categorie']) ?></td>
                    <td><?= number_format($p['prix_unitaire'], 2) ?> €</td>
                    <td style="display:flex;gap:8px;">
                        <button class="btn-action" onclick="location.href='editer_produit.php?id=<?= $p['id_produit'] ?>'">Modifier</button>
                        <button class="btn-delete" onclick="if(confirm('Supprimer ce produit ?')) location.href='produit.php?delete=<?= $p['id_produit'] ?>'">
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
