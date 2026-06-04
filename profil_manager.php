<!DOCTYPE html>
<html lang="fr">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Profil Manager</title>

    <link rel="stylesheet" href="style.css">

    <link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

</head>

<body>

<button id="menu-toggle" class="menu-toggle">
    <i class="fa-solid fa-bars"></i>
</button>

<div class="sidebar" id="sidebar">

    <div class="logo">
        <img src="image/logo.png" alt="logo">
    </div>

    <ul>

        <li onclick="location.href='dashboard.php'">
            <i class="fa-solid fa-house"></i>
            Dashboard
        </li>

        <li onclick="location.href='missions.php'">
            <i class="fa-solid fa-list-check"></i>
            Missions
        </li>

        <li onclick="location.href='distributeurs.php'">
            <i class="fa-solid fa-box"></i>
            Distributeurs
        </li>

        <li onclick="location.href='produits.php'">
            <i class="fa-solid fa-bottle-water"></i>
            Produits
        </li>

        <li class="active">
            <i class="fa-solid fa-user"></i>
            Profil
        </li>

    </ul>

</div>

<main>

<header>

    <h1>Profil Manager</h1>

    <div class="date">
        Administrateur
    </div>

</header>

<div class="cards">

    <div class="card">

        <i class="fa-solid fa-user-tie"></i>

        <h3>Jean</h3>

        <p>Manager</p>

    </div>

    <div class="card">

        <i class="fa-solid fa-users"></i>

        <h3>5</h3>

        <p>Employés gérés</p>

    </div>

    <div class="card">

        <i class="fa-solid fa-list-check"></i>

        <h3>42</h3>

        <p>Missions créées</p>

    </div>

</div>

<section class="missions">

    <h2>Informations personnelles</h2>

    <br>

    <form>

        <div class="input-group">

            <label>Nom</label>

            <input
            type="text"
            value="Dupont">

        </div>

        <div class="input-group">

            <label>Prénom</label>

            <input
            type="text"
            value="Jean">

        </div>

        <div class="input-group">

            <label>Email</label>

            <input
            type="email"
            value="jean.dupont@fantome.fr">

        </div>

        <div class="input-group">

            <label>Téléphone</label>

            <input
            type="text"
            value="06 00 00 00 00">

        </div>

    </form>

</section>

<br>

<section class="missions">

    <h2>Changer le mot de passe</h2>

    <br>

    <div class="input-group">

        <label>Mot de passe actuel</label>

        <div class="password-container">

            <input type="password" id="oldPassword">

            <button
            type="button"
            class="toggle-password"
            onclick="togglePassword('oldPassword', this)">

                <i class="fa-solid fa-eye"></i>

            </button>

        </div>

    </div>

    <div class="input-group">

        <label>Nouveau mot de passe</label>

        <div class="password-container">

            <input type="password" id="newPassword">

            <button
            type="button"
            class="toggle-password"
            onclick="togglePassword('newPassword', this)">

                <i class="fa-solid fa-eye"></i>

            </button>

        </div>

    </div>

    <div class="input-group">

        <label>Confirmer le mot de passe</label>

        <div class="password-container">

            <input type="password" id="confirmPassword">

            <button
            type="button"
            class="toggle-password"
            onclick="togglePassword('confirmPassword', this)">

                <i class="fa-solid fa-eye"></i>

            </button>

        </div>

    </div>

</section>

<br>

<section class="missions">

    <h2>Statistiques globales</h2>

    <br>

    <div class="cards">

        <div class="card">

            <i class="fa-solid fa-store"></i>

            <h3>12</h3>

            <p>Distributeurs</p>

        </div>

        <div class="card">

            <i class="fa-solid fa-box"></i>

            <h3>48</h3>

            <p>Produits</p>

        </div>

        <div class="card">

            <i class="fa-solid fa-screwdriver-wrench"></i>

            <h3>1</h3>

            <p>Maintenance</p>

        </div>

    </div>

</section>

<br>

<button class="btn-create">

    <i class="fa-solid fa-floppy-disk"></i>

    Enregistrer les modifications

</button>

</main>

<script src="script.js"></script>

</body>

</html>