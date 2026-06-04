<!DOCTYPE html>
<html lang="fr">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Dashboard Manager</title>

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

            <li onclick="location.href='profil.php'">
                <i class="fa-solid fa-user"></i>
                Profil
            </li>

        </ul>

    </div>

    <main>

        <header>

            <h1>Dashboard Manager</h1>

            <div class="date">
                Administrateur
            </div>

        </header>

        <div class="cards">

            <div class="card">

                <i class="fa-solid fa-list-check"></i>

                <h3>42</h3>

                <p>Missions</p>

            </div>

            <div class="card">

                <i class="fa-solid fa-store"></i>

                <h3>12</h3>

                <p>Distributeurs</p>

            </div>

            <div class="card">

                <i class="fa-solid fa-users"></i>

                <h3>5</h3>

                <p>Employés</p>

            </div>

        </div>

        <div class="cards">

            <div class="card">

                <i class="fa-solid fa-triangle-exclamation"></i>

                <h3>3</h3>

                <p>Alertes Stock</p>

            </div>

            <div class="card">

                <i class="fa-solid fa-screwdriver-wrench"></i>

                <h3>1</h3>

                <p>Maintenance</p>

            </div>

            <div class="card">

                <i class="fa-solid fa-circle-check"></i>

                <h3>34</h3>

                <p>Missions terminées</p>

            </div>

        </div>

        <section class="missions">

            <h2>Dernières missions</h2>

            <div class="table-responsive">

                <table>

                    <tr>

                        <th>ID</th>
                        <th>Employé</th>
                        <th>Distributeur</th>
                        <th>Statut</th>

                    </tr>

                    <tr>

                        <td>#001</td>
                        <td>Thomas</td>
                        <td>Gare Centrale</td>
                        <td>En attente</td>

                    </tr>

                    <tr>

                        <td>#002</td>
                        <td>Lucas</td>
                        <td>Université</td>
                        <td>Terminée</td>

                    </tr>

                    <tr>

                        <td>#003</td>
                        <td>Emma</td>
                        <td>Mairie</td>
                        <td>Terminée</td>

                    </tr>

                </table>

            </div>

        </section>

        <br>

        <section class="missions">

            <h2>Distributeurs nécessitant une intervention</h2>

            <div class="table-responsive">

                <table>

                    <tr>

                        <th>Distributeur</th>
                        <th>Problème</th>
                        <th>Priorité</th>

                    </tr>

                    <tr>

                        <td>Gare Centrale</td>
                        <td>Stock faible</td>
                        <td>Haute</td>

                    </tr>

                    <tr>

                        <td>Hôpital</td>
                        <td>Maintenance</td>
                        <td>Critique</td>

                    </tr>

                </table>

            </div>

        </section>

    </main>
    <script src="script.js"></script>

</body>

</html>