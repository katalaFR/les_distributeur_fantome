<?php
require_once 'auth.php';
requireManager();

$pdo = getPDO();
$id  = intval($_GET['id'] ?? 0);

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['sauvegarder'])) {
    $nom      = trim($_POST['nom'] ?? '');
    $cat      = trim($_POST['categorie'] ?? '');
    $prix     = floatval($_POST['prix']);

    if (!$nom) {
        $error = 'Le nom du produit est obligatoire.';
    } else {
        if ($id) {
            $pdo->prepare("UPDATE produit SET nom=?, categorie=?, prix_unitaire=? WHERE id_produit=?")
                ->execute([$nom, $cat, $prix, $id]);
        } else {
            $pdo->prepare("INSERT INTO produit (nom, categorie, prix_unitaire) VALUES (?,?,?)")
                ->execute([$nom, $cat, $prix]);
        }
        header('Location: produit.php?saved=1');
        exit;
    }
}

if (isset($_POST['supprimer']) && $id) {
    $pdo->prepare("DELETE FROM produit WHERE id_produit=?")->execute([$id]);
    header('Location: produit.php?deleted=1');
    exit;
}

$produit = null;
$nbDistrib = 0;
$nbEmp = 0;
if ($id) {
    $stmt = $pdo->prepare("SELECT * FROM produit WHERE id_produit = ?");
    $stmt->execute([$id]);
    $produit = $stmt->fetch();
    if (!$produit) { header('Location: produit.php'); exit; }

    $nbDistrib = $pdo->prepare("SELECT COUNT(DISTINCT e.code_dist) FROM stocker s JOIN emplacement e ON e.numéro_emplacement = s.numéro_emplacement WHERE s.id_produit = ?");
    $nbDistrib->execute([$id]);
    $nbDistrib = $nbDistrib->fetchColumn();

    $nbEmp = $pdo->prepare("SELECT COUNT(*) FROM stocker WHERE id_produit = ?");
    $nbEmp->execute([$id]);
    $nbEmp = $nbEmp->fetchColumn();
}

$categories = ['Boisson', 'Snack', 'Café', 'Confiserie', 'Autre'];
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $id ? 'Modifier' : 'Nouveau' ?> Produit</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body>
<?php include 'sidebar_manager.php'; ?>
<main>
    <header>
        <h1><?= $id ? 'Modifier Produit' : 'Nouveau Produit' ?></h1>
        <div class="date"><?= $id ? 'ID #PROD-' . str_pad($id, 3, '0', STR_PAD_LEFT) : 'Création' ?></div>
    </header>

    <?php if ($error): ?><div class="error"><?= htmlspecialchars($error) ?></div><?php endif; ?>

    <?php if ($produit): ?>
    <div class="cards">
        <div class="card"><i class="fa-solid fa-bottle-water"></i><h3><?= htmlspecialchars($produit['nom']) ?></h3><p>Produit</p></div>
        <div class="card"><i class="fa-solid fa-tags"></i><h3><?= htmlspecialchars($produit['categorie']) ?></h3><p>Catégorie</p></div>
        <div class="card"><i class="fa-solid fa-euro-sign"></i><h3><?= number_format($produit['prix_unitaire'], 2) ?>€</h3><p>Prix</p></div>
    </div>
    <?php endif; ?>

    <section class="missions">
        <h2>Informations Produit</h2>
        <br>
        <form method="POST">
            <div class="input-group">
                <label>Nom du produit <span style="color:var(--red)">*</span></label>
                <input type="text" name="nom" value="<?= htmlspecialchars($produit['nom'] ?? '') ?>" required>
            </div>
            <div class="input-group">
                <label>Catégorie</label>
                <select name="categorie">
                    <?php foreach ($categories as $cat): ?>
                    <option value="<?= $cat ?>" <?= ($produit['categorie'] ?? '') === $cat ? 'selected' : '' ?>><?= $cat ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="input-group">
                <label>Prix unitaire (€)</label>
                <input type="number" name="prix" step="0.01" min="0" value="<?= $produit['prix_unitaire'] ?? '0.00' ?>">
            </div>

            <?php if ($id): ?>
            <br>
            <section class="missions">
                <h2>Utilisation</h2>
                <br>
                <div class="cards">
                    <div class="card"><i class="fa-solid fa-store"></i><h3><?= $nbDistrib ?></h3><p>Distributeurs</p></div>
                    <div class="card"><i class="fa-solid fa-cube"></i><h3><?= $nbEmp ?></h3><p>Emplacements</p></div>
                </div>
            </section>
            <br>
            <?php endif; ?>

            <div class="action-buttons">
                <button type="submit" name="sauvegarder" class="btn-create">
                    <i class="fa-solid fa-floppy-disk"></i> Enregistrer
                </button>
                <?php if ($id): ?>
                <button type="submit" name="supprimer" class="btn-delete" onclick="return confirm('Supprimer ce produit ?')">
                    <i class="fa-solid fa-trash"></i> Supprimer
                </button>
                <?php endif; ?>
            </div>
        </form>
    </section>
</main>
<script src="script.js"></script>
</body>
</html>
