<?php
require_once 'auth.php';
requireManager();

$pdo = getPDO();
$uid = $_SESSION['id_employe'];

$error   = '';
$success = '';

// Créer la mission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['creer'])) {
    $idEmploye   = intval($_POST['id_employe']);
    $codeDist    = intval($_POST['code_dist']);
    $dateMission = $_POST['date_mission'] ?? '';
    $heureDeb    = $_POST['heure_debut'] ?? '';
    $heureFin    = $_POST['heure_fin']   ?? '';
    $commentaire = trim($_POST['commentaire'] ?? '');

    if (!$idEmploye || !$codeDist || !$dateMission || !$heureDeb) {
        $error = 'Veuillez remplir tous les champs obligatoires.';
    } else {
        // Insérer la mission
        $stmt = $pdo->prepare("
            INSERT INTO mission (date_mission, heure_debut, heure_fin, statut_mission, commentaire, code_dist)
            VALUES (?, ?, ?, 'en_attente', ?, ?)
        ");
        $stmt->execute([$dateMission, $heureDeb, $heureFin ?: null, $commentaire ?: null, $codeDist]);
        $idMission = $pdo->lastInsertId();

        // Assigner l'employé
        $pdo->prepare("INSERT INTO missioner (id_mission, id_employe) VALUES (?, ?)")->execute([$idMission, $idEmploye]);

        // Enregistrer le créateur (manager)
        $pdo->prepare("INSERT INTO creer (id_mission, id_employe) VALUES (?, ?)")->execute([$idMission, $uid]);

        // Produits à recharger
        $produits = $_POST['produits'] ?? [];
        $qtesArr  = $_POST['qte']      ?? [];
        foreach ($produits as $i => $idProduit) {
            $qte = intval($qtesArr[$i] ?? 0);
            if ($idProduit && $qte > 0) {
                $pdo->prepare("INSERT INTO relier (id_mission, id_produit, qte_produit) VALUES (?, ?, ?) ON DUPLICATE KEY UPDATE qte_produit = VALUES(qte_produit)")
                    ->execute([$idMission, intval($idProduit), $qte]);
            }
        }

        header('Location: manager_mission.php?created=1');
        exit;
    }
}

// Données formulaire
$employes    = $pdo->query("SELECT p.id_employe, p.nom, p.prenom FROM personne p JOIN employe e ON e.id_employe = p.id_employe ORDER BY p.prenom")->fetchAll();
$distributeurs = $pdo->query("SELECT code_dist, libelle_distrib FROM distributeur WHERE id_etat = 1 ORDER BY libelle_distrib")->fetchAll();
$produits      = $pdo->query("SELECT id_produit, nom, categorie FROM produit ORDER BY categorie, nom")->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créer une Mission</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body>
<?php include 'sidebar_manager.php'; ?>
<main>
    <header>
        <h1>Créer une Mission</h1>
        <div class="date">Manager</div>
    </header>

    <?php if ($error): ?><div class="error"><?= htmlspecialchars($error) ?></div><?php endif; ?>

    <form method="POST">
        <section class="missions">
            <h2>Informations Mission</h2>
            <br>
            <div class="input-group">
                <label>Employé <span style="color:var(--red)">*</span></label>
                <select name="id_employe" required>
                    <option value="">— Choisir un employé —</option>
                    <?php foreach ($employes as $e): ?>
                    <option value="<?= $e['id_employe'] ?>"><?= htmlspecialchars($e['prenom'] . ' ' . $e['nom']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="input-group">
                <label>Distributeur <span style="color:var(--red)">*</span></label>
                <select name="code_dist" required>
                    <option value="">— Choisir un distributeur —</option>
                    <?php foreach ($distributeurs as $d): ?>
                    <option value="<?= $d['code_dist'] ?>"><?= htmlspecialchars($d['libelle_distrib']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="input-group">
                <label>Date de mission <span style="color:var(--red)">*</span></label>
                <input type="date" name="date_mission" required value="<?= date('Y-m-d') ?>">
            </div>
            <div class="input-group">
                <label>Heure de début <span style="color:var(--red)">*</span></label>
                <input type="time" name="heure_debut" required>
            </div>
            <div class="input-group">
                <label>Heure de fin (optionnel)</label>
                <input type="time" name="heure_fin">
            </div>
            <div class="input-group">
                <label>Commentaire</label>
                <textarea name="commentaire" rows="4" placeholder="Instructions pour l'employé..."></textarea>
            </div>
        </section>

        <br>

        <section class="missions">
            <h2>Produits à Recharger</h2>
            <br>
            <div id="produits-container">
                <table id="produits-table">
                    <tr><th>Produit</th><th>Quantité</th><th>Action</th></tr>
                    <tr class="produit-row">
                        <td>
                            <select name="produits[]" style="width:100%;">
                                <option value="">— Choisir —</option>
                                <?php foreach ($produits as $p): ?>
                                <option value="<?= $p['id_produit'] ?>">[<?= htmlspecialchars($p['categorie']) ?>] <?= htmlspecialchars($p['nom']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </td>
                        <td><input type="number" name="qte[]" min="1" value="10" style="width:80px;"></td>
                        <td><button type="button" class="btn-delete" onclick="removeRow(this)"><i class="fa-solid fa-trash"></i></button></td>
                    </tr>
                </table>
            </div>
            <button type="button" class="btn-action" style="margin-top:10px;" onclick="addProduitRow()">
                <i class="fa-solid fa-plus"></i> Ajouter un produit
            </button>
        </section>

        <br>
        <button type="submit" name="creer" class="btn-create">
            <i class="fa-solid fa-floppy-disk"></i> Créer la Mission
        </button>
    </form>
</main>

<script src="script.js"></script>
<script>
const produitsOptions = `<?php foreach ($produits as $p): ?><option value="<?= $p['id_produit'] ?>">[<?= htmlspecialchars($p['categorie']) ?>] <?= htmlspecialchars($p['nom']) ?></option><?php endforeach; ?>`;

function addProduitRow() {
    const tbody = document.querySelector('#produits-table');
    const row = document.createElement('tr');
    row.className = 'produit-row';
    row.innerHTML = `
        <td><select name="produits[]" style="width:100%;"><option value="">— Choisir —</option>${produitsOptions}</select></td>
        <td><input type="number" name="qte[]" min="1" value="10" style="width:80px;"></td>
        <td><button type="button" class="btn-delete" onclick="removeRow(this)"><i class="fa-solid fa-trash"></i></button></td>
    `;
    tbody.appendChild(row);
}

function removeRow(btn) {
    const rows = document.querySelectorAll('.produit-row');
    if (rows.length > 1) btn.closest('tr').remove();
}
</script>
</body>
</html>
