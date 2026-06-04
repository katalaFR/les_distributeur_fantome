<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord</title>
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
            <li class="active">
                <i class="fa-solid fa-house"></i>
                Tableau de bord
            </li>
            <li>
                <i class="fa-solid fa-list-check"></i>
                Mes missions
            </li>
            <li>
                <i class="fa-solid fa-clock-rotate-left"></i>
                Historique
            </li>
            <li>
                <i class="fa-solid fa-user"></i>
                Mon profil
            </li>
            <li>
                <i class="fa-solid fa-right-from-bracket"></i>
                Déconnexion
            </li>
        </ul>
    </div>
    <main>
        <header>
            <span class="date">
                <?= date('d/m/Y') ?>
            </span>
        </header>
        <section class="alert-card">
            <h2>
                Mission prioritaire
            </h2>
            <p>
                Réapprovisionnement du distributeur
                Gare Centrale.
            </p>
            <button>
                Voir la mission
            </button>
        </section>
        <section class="cards">
            <div class="card">
                <i class="fa-solid fa-list-check"></i>
                <h3>4</h3>
                <p>Missions aujourd'hui</p>
            </div>
            <div class="card">
                <i class="fa-solid fa-check"></i>
                <h3>17</h3>
                <p>Missions terminées</p>
            </div>
            <div class="card">
                <i class="fa-solid fa-truck"></i>
                <h3>2</h3>
                <p>En cours</p>
            </div>
        </section>
        <section class="missions">
            <h2>Mes prochaines missions</h2>
            <div class="table-container">
                <table>
                    <tr>
                        <th>Distributeur</th>
                        <th>Heure</th>
                        <th>Statut</th>
                    </tr>
                    <tr>
                        <td>Gare Centrale</td>
                        <td>09:00</td>
                        <td>À faire</td>
                    </tr>
                    <tr>
                        <td>Mairie</td>
                        <td>13:30</td>
                        <td>À faire</td>
                    </tr>
                    <tr>
                        <td>Université</td>
                        <td>16:00</td>
                        <td>À faire</td>
                    </tr>
                </table>
            </div>
        </section>
    </main>
    <script src="script.js"></script>
</body>

</html>