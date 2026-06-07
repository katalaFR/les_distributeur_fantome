<?php
require_once 'auth.php';
requireManager();

$pdo    = getPDO();
$id     = intval($_GET['id']   ?? 0); // 0 = création
$distId = intval($_GET['dist'] ?? 0);

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['sauvegarder'])) {
    $numEmp     = intval($_POST['numero']);
    $qteMax     = intval($_POST['qte_max']);
    $idTypEmp   = intval($_POST['id_type_emplacement']);
    $idProduit  = intval($_POST['id_produit']);
    $distIdPost = intval($_POST['dist_id']);

    if (!$distIdPost || !$qteMax) {
        $error = 'Données invalides.';
    } else {
        if ($id) {
            $pdo->prepare("UPDATE emplacement SET quantite_max=?, id_type_emplacement=? WHERE numéro_emplacement=?")
                ->execute([$qteMax, $idTypEmp, $id]);
            // Mettre à jour le produit stocké
            $pdo->prepare("DELETE FROM stocker WHERE numéro_emplacement=?")->execute([$id]);
            if ($idProduit) {
                $pdo->prepare("INSERT INTO stocker (numéro_emplacement, id_produit) VALUES (?,?)")->execute([$id, $idProduit]);
            }
        } else {
            $pdo->prepare("INSERT INTO emplacement (quantite_max, id_type_emplacement, code_dist) VALUES (?,?,?)")
                ->execute([$qteMax, $idTypEmp ?: null, $distIdPost]);
            $newId = $pdo->lastInsertId();
            if ($idProduit) {
                $pdo->prepare("INSERT INTO stocker (numéro_emplacement, id_produit) VALUES (?,?)")->execute([$newId, $idProduit]);
            }
        }
        header("Location: editer_distributeur.php?id=$distIdPost&saved=1");
        exit;
    }
}

// Données formulaire
$typesEmp = $pdo->query("SELECT * FROM type_emplacement")->fetchAll();
$produits  = $pdo->query("SELECT id_produit, nom, categorie FROM produit ORDER BY categorie, nom")->fetchAll();

$emp = null;
$produitActuel = 0;
if ($id) {
    $stmt = $pdo->prepare("SELECT e.*, s.id_produit AS produit_actuel FROM emplacement e LEFT JOIN stocker s ON s.numéro_emplacement = e.numéro_emplacement WHERE e.numéro_emplacement = ?");
    $stmt->execute([$id]);
    $emp = $stmt->fetch();
    $produitActuel = $emp['produit_actuel'] ?? 0;
    $distId = $emp['code_dist'] ?? $distId;
}

// Nom du distributeur
$distribName = '';
if ($distId) {
    $d = $pdo->prepare("SELECT libelle_distrib FROM distributeur WHERE code_dist = ?");
    $d->execute([$distId]);
    $distribName = $d->fetchColumn();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $id ? 'Modifier' : 'Nouvel' ?> Emplacement</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body>
<?php include 'sidebar_manager.php'; ?>
<main>
    <header>
        <h1><?= $id ? 'Emplacement N°' . $id : 'Nouvel emplacement' ?></h1>
        <div class="date"><?= htmlspecialchars($distribName) ?></div>
    </header>

    <?php if ($error): ?><div class="error"><?= htmlspecialchars($error) ?></div><?php endif; ?>

    <?php if ($emp): ?>
    <div class="cards">
        <div class="card"><i class="fa-solid fa-layer-group"></i><h3><?= $emp['quantite_max'] ?></h3><p>Quantité max</p></div>
    </div>
    <?php endif; ?>

    <section class="missions">
        <h2>Configuration</h2>
        <br>
        <form method="POST">
            <input type="hidden" name="dist_id" value="<?= $distId ?>">
            <div class="input-group">
                <label>Produit affecté</label>
                <select name="id_produit">
                    <option value="0">— Aucun produit —</option>
                    <?php foreach ($produits as $p): ?>
                    <option value="<?= $p['id_produit'] ?>" <?= $produitActuel == $p['id_produit'] ? 'selected' : '' ?>>
                        [<?= htmlspecialchars($p['categorie']) ?>] <?= htmlspecialchars($p['nom']) ?>
                    </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="input-group">
                <label>Quantité maximale</label>
                <input type="number" name="qte_max" min="1" max="100" value="<?= $emp['quantite_max'] ?? 10 ?>">
            </div>
            <div class="input-group">
                <label>Type d'emplacement</label>
                <select name="id_type_emplacement">
                    <option value="0">— Non défini —</option>
                    <?php foreach ($typesEmp as $t): ?>
                    <option value="<?= $t['id_type_emplacement'] ?>" <?= ($emp['id_type_emplacement'] ?? 0) == $t['id_type_emplacement'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($t['type_emplacement']) ?>
                    </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <input type="hidden" name="numero" value="<?= $id ?>">
            <button type="submit" name="sauvegarder" class="btn-create">
                <i class="fa-solid fa-floppy-disk"></i> Enregistrer
            </button>
        </form>
    </section>

    <br>
    <button class="btn-action" onclick="history.back()">← Retour au distributeur</button>
</main>
<script src="script.js"></script>
</body>
</html>
