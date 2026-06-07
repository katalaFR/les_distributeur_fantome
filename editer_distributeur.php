<?php
require_once 'auth.php';
requireManager();

$pdo = getPDO();
$id  = intval($_GET['id'] ?? 0); // 0 = création

// Supprimer un emplacement
if (isset($_GET['del_emp']) && is_numeric($_GET['del_emp']) && $id) {
    $pdo->prepare("DELETE FROM emplacement WHERE numéro_emplacement = ? AND code_dist = ?")->execute([intval($_GET['del_emp']), $id]);
    header("Location: editer_distributeur.php?id=$id");
    exit;
}

$error   = '';
$success = '';

// Sauvegarder
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['sauvegarder'])) {
    $libelle = trim($_POST['libelle'] ?? '');
    $adresse = trim($_POST['adresse'] ?? '');
    $idType  = intval($_POST['id_type']);
    $idMarq  = intval($_POST['id_marque']);
    $idEtat  = intval($_POST['id_etat']);

    if (!$libelle) {
        $error = 'Le nom du distributeur est obligatoire.';
    } else {
        if ($id) {
            $pdo->prepare("UPDATE distributeur SET libelle_distrib=?, adress=?, id_type=?, id_marque=?, id_etat=? WHERE code_dist=?")
                ->execute([$libelle, $adresse, $idType, $idMarq, $idEtat, $id]);
        } else {
            $pdo->prepare("INSERT INTO distributeur (libelle_distrib, adress, id_type, id_marque, id_etat) VALUES (?,?,?,?,?)")
                ->execute([$libelle, $adresse, $idType, $idMarq, $idEtat]);
            $id = $pdo->lastInsertId();
            header("Location: editer_distributeur.php?id=$id&saved=1");
            exit;
        }
        header("Location: distributeur.php?saved=1");
        exit;
    }
}

// Données
$types  = $pdo->query("SELECT * FROM type_distributeur")->fetchAll();
$marques = $pdo->query("SELECT * FROM marque")->fetchAll();
$etats  = $pdo->query("SELECT * FROM etat_distributer")->fetchAll();

$distrib = null;
$emplacements = [];
if ($id) {
    $distrib = $pdo->prepare("SELECT * FROM distributeur WHERE code_dist = ?");
    $distrib->execute([$id]);
    $distrib = $distrib->fetch();
    if (!$distrib) { header('Location: distributeur.php'); exit; }

    $stmtEmp = $pdo->prepare("
        SELECT e.numéro_emplacement, e.quantite_max, e.type_slote, p.nom AS produit, te.type_emplacement
        FROM emplacement e
        LEFT JOIN stocker s ON s.numéro_emplacement = e.numéro_emplacement
        LEFT JOIN produit p ON p.id_produit = s.id_produit
        LEFT JOIN type_emplacement te ON te.id_type_emplacement = e.id_type_emplacement
        WHERE e.code_dist = ?
        ORDER BY e.numéro_emplacement
    ");
    $stmtEmp->execute([$id]);
    $emplacements = $stmtEmp->fetchAll();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $id ? 'Modifier' : 'Nouveau' ?> Distributeur</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body>
<?php include 'sidebar_manager.php'; ?>
<main>
    <header>
        <h1><?= $id ? 'Modifier un distributeur' : 'Nouveau distributeur' ?></h1>
        <div class="date"><?= $id ? '#DIST-' . str_pad($id, 3, '0', STR_PAD_LEFT) : 'Création' ?></div>
    </header>

    <?php if ($error): ?><div class="error"><?= htmlspecialchars($error) ?></div><?php endif; ?>
    <?php if (isset($_GET['saved'])): ?><div class="alert-card" style="margin-bottom:15px;background:linear-gradient(135deg,#2d7a2d,#1a4a1a);"><p>✅ Enregistré.</p></div><?php endif; ?>

    <?php if ($distrib): ?>
    <div class="cards">
        <div class="card"><i class="fa-solid fa-industry"></i><h3><?= htmlspecialchars($distrib['libelle_distrib']) ?></h3><p>Distributeur</p></div>
        <div class="card"><i class="fa-solid fa-cube"></i><h3><?= count($emplacements) ?></h3><p>Emplacements</p></div>
        <div class="card"><i class="fa-solid fa-circle-check"></i><h3><?= $distrib['id_etat'] == 1 ? 'Actif' : ($distrib['id_etat'] == 2 ? 'Maintenance' : 'Hors service') ?></h3><p>État</p></div>
    </div>
    <?php endif; ?>

    <section class="missions">
        <h2>Informations générales</h2>
        <br>
        <form method="POST">
            <div class="input-group">
                <label>Nom du distributeur <span style="color:var(--red)">*</span></label>
                <input type="text" name="libelle" value="<?= htmlspecialchars($distrib['libelle_distrib'] ?? '') ?>" required>
            </div>
            <div class="input-group">
                <label>Adresse</label>
                <input type="text" name="adresse" value="<?= htmlspecialchars($distrib['adress'] ?? '') ?>">
            </div>
            <div class="input-group">
                <label>Type de distributeur</label>
                <select name="id_type">
                    <?php foreach ($types as $t): ?>
                    <option value="<?= $t['id_type'] ?>" <?= ($distrib['id_type'] ?? 0) == $t['id_type'] ? 'selected' : '' ?>><?= htmlspecialchars($t['libelle_distributeur']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="input-group">
                <label>Marque</label>
                <select name="id_marque">
                    <?php foreach ($marques as $m): ?>
                    <option value="<?= $m['id_marque'] ?>" <?= ($distrib['id_marque'] ?? 0) == $m['id_marque'] ? 'selected' : '' ?>><?= htmlspecialchars($m['libelle_marque']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="input-group">
                <label>État</label>
                <select name="id_etat">
                    <?php foreach ($etats as $e): ?>
                    <option value="<?= $e['id_etat'] ?>" <?= ($distrib['id_etat'] ?? 1) == $e['id_etat'] ? 'selected' : '' ?>><?= htmlspecialchars($e['libelle_etat_distributeur']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="submit" name="sauvegarder" class="btn-create">
                <i class="fa-solid fa-floppy-disk"></i> Enregistrer les modifications
            </button>
        </form>
    </section>

    <?php if ($id): ?>
    <br>
    <section class="missions">
        <div class="page-title">
            <h2>Emplacements</h2>
            <button class="btn-add" onclick="location.href='editer_emplacement.php?dist=<?= $id ?>'">
                <i class="fa-solid fa-plus"></i> Ajouter
            </button>
        </div>
        <table>
            <tr><th>N°</th><th>Produit</th><th>Qté max</th><th>Type</th><th>Actions</th></tr>
            <?php if (empty($emplacements)): ?>
            <tr><td colspan="5" style="text-align:center;color:#666;">Aucun emplacement configuré</td></tr>
            <?php else: ?>
            <?php foreach ($emplacements as $i => $e): ?>
            <tr>
                <td><?= $i+1 ?></td>
                <td><?= htmlspecialchars($e['produit'] ?? '—') ?></td>
                <td><?= $e['quantite_max'] ?></td>
                <td><?= htmlspecialchars($e['type_emplacement'] ?? $e['type_slote'] ?? '-') ?></td>
                <td style="display:flex;gap:8px;">
                    <button class="btn-action" onclick="location.href='editer_emplacement.php?id=<?= $e['numéro_emplacement'] ?>&dist=<?= $id ?>'">Modifier</button>
                    <button class="btn-delete" onclick="if(confirm('Supprimer cet emplacement ?')) location.href='editer_distributeur.php?id=<?= $id ?>&del_emp=<?= $e['numéro_emplacement'] ?>'">
                        <i class="fa-solid fa-trash"></i>
                    </button>
                </td>
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
