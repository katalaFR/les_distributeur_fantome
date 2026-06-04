<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Profil</title>
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
                Tableau de bord
            </li>
            <li onclick="location.href='missions.php'">
                <i class="fa-solid fa-list-check"></i>
                Mes missions
            </li>
            <li onclick="location.href='historique.php'">
                <i class="fa-solid fa-clock-rotate-left"></i>
                Historique
            </li>
            <li class="active">
                <i class="fa-solid fa-user"></i>
                Mon profil
            </li>
        </ul>
    </div>
    <main>
        <header>
            <h1>Mon Profil</h1>
            <div class="date">
                Employé
            </div>
        </header>
        <div class="cards">
            <div class="card">
                <i class="fa-solid fa-user"></i>
                <h3>Thomas</h3>
                <p>Prénom</p>
            </div>
            <div class="card">
                <i class="fa-solid fa-briefcase"></i>
                <h3>145</h3>
                <p>Missions réalisées</p>
            </div>
            <div class="card">
                <i class="fa-solid fa-star"></i>
                <h3>4.8</h3>
                <p>Note moyenne</p>
            </div>
        </div>
        <section class="missions">
            <h2>Informations personnelles</h2>
            <br>
            <table>
                <tr>
                    <th>Champ</th>
                    <th>Valeur</th>
                </tr>
                <tr>
                    <td>Nom</td>
                    <td>Dupont</td>
                </tr>
                <tr>
                    <td>Prénom</td>
                    <td>Thomas</td>
                </tr>
                <tr>
                    <td>Email</td>
                    <td>thomas@distributeurs-fantome.fr</td>
                </tr>
                <tr>
                    <td>Téléphone</td>
                    <td>06 00 00 00 00</td>
                </tr>
            </table>
        </section>
        <br>
        <section class="missions">
            <h2>Changer le mot de passe</h2>
            <br>
            <form>
                <div class="input-group">
                    <label>Mot de passe actuel</label>
                    <div class="password-container">
                        <input type="password" id="currentPassword">
                        <button type="button" class="toggle-password"
                            onclick="togglePassword('currentPassword', this)">
                            <i class="fa-solid fa-eye"></i>
                        </button>
                    </div>
                </div>
                <div class="input-group">
                    <label>Mot de passe actuel</label>
                    <div class="password-container">
                        <input type="password" id="newPassword">
                        <button type="button" class="toggle-password"
                            onclick="togglePassword('newPassword', this)">
                            <i class="fa-solid fa-eye"></i>
                        </button>
                    </div>
                </div>
                <div class="input-group">
                    <label>Mot de passe actuel</label>
                    <div class="password-container">
                        <input type="password" id="confirmPassword">
                        <button type="button" class="toggle-password"
                            onclick="togglePassword('confirmPassword', this)">
                            <i class="fa-solid fa-eye"></i>
                        </button>
                    </div>
                </div>
                <button type="submit" class="btn-save">
                    <i class="fa-solid fa-floppy-disk"></i>
                    Enregistrer
                </button>
            </form>
        </section>
    </main>
    <script src="script.js"></script>
</body>

</html>