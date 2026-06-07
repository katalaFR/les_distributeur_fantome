<?php
require_once 'auth.php';
requireManager();

$pdo  = getPDO();
$uid  = $_SESSION['id_employe'];
$user = $_SESSION['user'];

$success = '';
$error   = '';

if (isset($_POST['changer_mdp'])) {
    $actuel  = $_POST['oldPassword']     ?? '';
    $nouveau = $_POST['newPassword']     ?? '';
    $confirm = $_POST['confirmPassword'] ?? '';

    if (!password_verify($actuel, $user['mdp'])) {
        $error = 'Mot de passe actuel incorrect.';
    } elseif (strlen($nouveau) < 6) {
        $error = 'Le nouveau mot de passe doit faire au moins 6 caractères.';
    } elseif ($nouveau !== $confirm) {
        $error = 'Les mots de passe ne correspondent pas.';
    } else {
        $hash = password_hash($nouveau, PASSWORD_DEFAULT);
        $pdo->prepare("UPDATE personne SET mdp = ? WHERE id_employe = ?")->execute([$hash, $uid]);
        $_SESSION['user']['mdp'] = $hash;
        $user['mdp'] = $hash;
        $success = 'Mot de passe modifié avec succès.';
    }
}

// Stats manager
$nbMissionsCreees = $pdo->prepare("SELECT COUNT(*) FROM creer WHERE id_employe = ?");
$nbMissionsCreees->execute([$uid]);
$nbMissionsCreees = $nbMissionsCreees->fetchColumn();

$nbEmployes  = $pdo->query("SELECT COUNT(*) FROM employe")->fetchColumn();
$nbDistrib   = $pdo->query("SELECT COUNT(*) FROM distributeur")->fetchColumn();
$nbProduits  = $pdo->query("SELECT COUNT(*) FROM produit")->fetchColumn();
$nbMaintenance = $pdo->query("SELECT COUNT(*) FROM distributeur WHERE id_etat = 2")->fetchColumn();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Manager</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body>
<?php include 'sidebar_manager.php'; ?>
<main>
    <header>
        <h1>Profil Manager</h1>
        <div class="date">Administrateur</div>
    </header>

    <?php if ($success): ?><div class="alert-card" style="margin-bottom:20px;background:linear-gradient(135deg,#2d7a2d,#1a4a1a);"><p>✅ <?= htmlspecialchars($success) ?></p></div><?php endif; ?>
    <?php if ($error):   ?><div class="error"><?= htmlspecialchars($error) ?></div><?php endif; ?>

    <div class="cards">
        <div class="card"><i class="fa-solid fa-user-tie"></i><h3><?= htmlspecialchars($user['prenom']) ?></h3><p>Manager</p></div>
        <div class="card"><i class="fa-solid fa-users"></i><h3><?= $nbEmployes ?></h3><p>Employés gérés</p></div>
        <div class="card"><i class="fa-solid fa-list-check"></i><h3><?= $nbMissionsCreees ?></h3><p>Missions créées</p></div>
    </div>

    <section class="missions">
        <h2>Informations personnelles</h2>
        <br>
        <table>
            <tr><th>Champ</th><th>Valeur</th></tr>
            <tr><td>Nom</td><td><?= htmlspecialchars($user['nom']) ?></td></tr>
            <tr><td>Prénom</td><td><?= htmlspecialchars($user['prenom']) ?></td></tr>
            <tr><td>Login</td><td><?= htmlspecialchars($user['login']) ?></td></tr>
            <tr><td>Email</td><td><?= htmlspecialchars($user['email'] ?? '-') ?></td></tr>
            <tr><td>Téléphone</td><td><?= htmlspecialchars($user['telephone'] ?? '-') ?></td></tr>
            <tr><td>Rôle</td><td>Manager</td></tr>
        </table>
    </section>

    <br>

    <section class="missions">
        <h2>Changer le mot de passe</h2>
        <br>
        <form method="POST">
            <div class="input-group">
                <label>Mot de passe actuel</label>
                <div class="password-container">
                    <input type="password" id="oldPassword" name="oldPassword">
                    <button type="button" class="toggle-password" onclick="togglePassword('oldPassword', this)"><i class="fa-solid fa-eye"></i></button>
                </div>
            </div>
            <div class="input-group">
                <label>Nouveau mot de passe</label>
                <div class="password-container">
                    <input type="password" id="newPassword" name="newPassword">
                    <button type="button" class="toggle-password" onclick="togglePassword('newPassword', this)"><i class="fa-solid fa-eye"></i></button>
                </div>
            </div>
            <div class="input-group">
                <label>Confirmer le mot de passe</label>
                <div class="password-container">
                    <input type="password" id="confirmPassword" name="confirmPassword">
                    <button type="button" class="toggle-password" onclick="togglePassword('confirmPassword', this)"><i class="fa-solid fa-eye"></i></button>
                </div>
            </div>
            <button type="submit" name="changer_mdp" class="btn-save">
                <i class="fa-solid fa-floppy-disk"></i> Enregistrer
            </button>
        </form>
    </section>

    <br>

    <section class="missions">
        <h2>Statistiques globales</h2>
        <br>
        <div class="cards">
            <div class="card"><i class="fa-solid fa-store"></i><h3><?= $nbDistrib ?></h3><p>Distributeurs</p></div>
            <div class="card"><i class="fa-solid fa-box"></i><h3><?= $nbProduits ?></h3><p>Produits</p></div>
            <div class="card"><i class="fa-solid fa-screwdriver-wrench"></i><h3><?= $nbMaintenance ?></h3><p>Maintenance</p></div>
        </div>
    </section>
</main>
<script src="script.js"></script>
</body>
</html>
