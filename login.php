<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body class="login-page">
<div class="background-red"></div>
<div class="login-container">
    <div class="brand">
        <div class="logo">
            <img src="image/logo.png" alt="logo">
        </div>
        <p>
            Centre de gestion des distributeurs automatiques
        </p>
    </div>
    <div class="login-card">
        <div class="card-header">
            
            <h2>Connexion</h2>
        </div>
        <?php if(!empty($error)): ?>
            <div class="error">
                <?= $error ?>
            </div>
        <?php endif; ?>
        <form method="POST">
            <div class="input-group">
                <label>Identifiant</label>
                <input
                    type="text"
                    name="login"
                    required
                >
            </div>
            <div class="input-group">
                <label>Mot de passe</label>
                <input
                    type="password"
                    name="password"
                    required
                >
            </div>
            <button
                type="submit"
                name="connexion"
                class="btn-login">
                ACCÉDER AU SYSTÈME
            </button>
        </form>
    </div>

</div>

</body>

</html>