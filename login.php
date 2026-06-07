<?php
require_once 'config.php';
session_start();

// Déjà connecté → rediriger
if (!empty($_SESSION['id_employe'])) {
    header('Location: ' . ($_SESSION['role'] === 'manager' ? 'index_manager.php' : 'index.php'));
    exit;
}

$error = '';

if (isset($_POST['connexion'])) {
    $login = trim($_POST['login'] ?? '');
    $mdp   = $_POST['password'] ?? '';

    if ($login === '' || $mdp === '') {
        $error = 'Veuillez remplir tous les champs.';
    } else {
        $pdo  = getPDO();
        $stmt = $pdo->prepare('SELECT * FROM personne WHERE login = ?');
        $stmt->execute([$login]);
        $user = $stmt->fetch();

        if ($user && password_verify($mdp, $user['mdp'])) {
            $_SESSION['id_employe'] = $user['id_employe'];
            $_SESSION['role']       = $user['role'];
            $_SESSION['user']       = $user;

            header('Location: ' . ($user['role'] === 'manager' ? 'index_manager.php' : 'index.php'));
            exit;
        } else {
            $error = 'Identifiant ou mot de passe incorrect.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion — Les Distributeurs Fantôme</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body class="login-page">
<div class="background-red"></div>
<div class="login-container">
    <div class="brand">
        <div class="logo">
            <img src="image/logo.png" alt="logo">
        </div>
        <p>Centre de gestion des distributeurs automatiques</p>
    </div>
    <div class="login-card">
        <div class="card-header">
            <h2>Connexion</h2>
        </div>
        <?php if ($error): ?>
            <div class="error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        <form method="POST">
            <div class="input-group">
                <label>Identifiant</label>
                <input type="text" name="login" value="<?= htmlspecialchars($_POST['login'] ?? '') ?>" required>
            </div>
            <div class="input-group">
                <label>Mot de passe</label>
                <input type="password" name="password" required>
            </div>
            <button type="submit" name="connexion" class="btn-login">ACCÉDER AU SYSTÈME</button>
        </form>
        <p style="margin-top:15px;color:#666;font-size:.8rem;text-align:center;">
            Comptes de démo : manager / thomas / lucas / emma — mot de passe : <strong>password</strong>
        </p>
    </div>
</div>
</body>
</html>
