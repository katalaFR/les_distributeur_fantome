<?php
require_once 'auth.php';
requireLogin();
if (isManager()) { header('Location: profil_manager.php'); exit; }

$pdo  = getPDO();
$uid  = $_SESSION['id_employe'];
$user = $_SESSION['user'];

$success = '';
$error   = '';

// Changer mot de passe
if (isset($_POST['changer_mdp'])) {
    $actuel   = $_POST['currentPassword'] ?? '';
    $nouveau  = $_POST['newPassword']     ?? '';
    $confirm  = $_POST['confirmPassword'] ?? '';

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

// Stats employé
$stmtStats = $pdo->prepare("
    SELECT COUNT(*) AS total, SUM(statut_mission='terminee') AS terminees
    FROM mission m JOIN missioner mi ON mi.id_mission = m.id_mission
    WHERE mi.id_employe = ?
");
$stmtStats->execute([$uid]);
$stats = $stmtStats->fetch();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Profil</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body>
<?php include 'sidebar_employe.php'; ?>
<main>
    <header>
        <h1>Mon Profil</h1>
        <div class="date">Employé</div>
    </header>

    <?php if ($success): ?><div class="alert-card" style="margin-bottom:20px;"><p>✅ <?= htmlspecialchars($success) ?></p></div><?php endif; ?>
    <?php if ($error):   ?><div class="error"><?= htmlspecialchars($error) ?></div><?php endif; ?>

    <div class="cards">
        <div class="card">
            <i class="fa-solid fa-user"></i>
            <h3><?= htmlspecialchars($user['prenom']) ?></h3>
            <p>Prénom</p>
        </div>
        <div class="card">
            <i class="fa-solid fa-briefcase"></i>
            <h3><?= $stats['terminees'] ?></h3>
            <p>Missions réalisées</p>
        </div>
        <div class="card">
            <i class="fa-solid fa-list-check"></i>
            <h3><?= $stats['total'] ?></h3>
            <p>Total assignées</p>
        </div>
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
            <tr><td>Rôle</td><td><?= ucfirst($user['role']) ?></td></tr>
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
                    <input type="password" id="currentPassword" name="currentPassword">
                    <button type="button" class="toggle-password" onclick="togglePassword('currentPassword', this)"><i class="fa-solid fa-eye"></i></button>
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
                <label>Confirmer le nouveau mot de passe</label>
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
</main>
<script src="script.js"></script>
</body>
</html>
