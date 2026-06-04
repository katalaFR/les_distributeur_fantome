<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historique des Missions</title>
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
            <li class="active">
                <i class="fa-solid fa-clock-rotate-left"></i>
                Historique
            </li>
            <li onclick="location.href='profil.php'">
                <i class="fa-solid fa-user"></i>
                Mon profil
            </li>
        </ul>
    </div>
    <main>
        <header>
            <h1>Historique des Missions</h1>
            <div class="date">
                145 Missions
            </div>
        </header>
        <div class="cards">
            <div class="card">
                <i class="fa-solid fa-check"></i>
                <h3>145</h3>
                <p>Missions terminées</p>
            </div>
            <div class="card">
                <i class="fa-solid fa-calendar"></i>
                <h3>18</h3>
                <p>Ce mois-ci</p>
            </div>
            <div class="card">
                <i class="fa-solid fa-star"></i>
                <h3>4.8</h3>
                <p>Note moyenne</p>
            </div>
        </div>
        <section class="missions">
            <h2>Historique complet</h2>
            <table>
                <tr>
                    <th>Mission</th>
                    <th>Distributeur</th>
                    <th>Date</th>
                    <th>Statut</th>
                </tr>
                <tr>
                    <td>#001</td>
                    <td>Gare Centrale</td>
                    <td>15/06/2025</td>
                    <td>✅ Terminée</td>
                </tr>
                <tr>
                    <td>#002</td>
                    <td>Université</td>
                    <td>14/06/2025</td>
                    <td>✅ Terminée</td>
                </tr>
                <tr>
                    <td>#003</td>
                    <td>Mairie</td>
                    <td>13/06/2025</td>
                    <td>✅ Terminée</td>
                </tr>
                <tr>
                    <td>#004</td>
                    <td>Hôpital</td>
                    <td>12/06/2025</td>
                    <td>✅ Terminée</td>
                </tr>
                <tr>
                    <td>#005</td>
                    <td>Centre Commercial</td>
                    <td>11/06/2025</td>
                    <td>✅ Terminée</td>
                </tr>
            </table>
        </section>
    </main>
    <script src="script.js"></script>
</body>

</html>