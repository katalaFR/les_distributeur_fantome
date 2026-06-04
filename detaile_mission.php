<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détail Mission</title>
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
            <li class="active">
                <i class="fa-solid fa-list-check"></i>
                Mes missions
            </li>
            <li onclick="location.href='historique.php'">
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
            <h1>Mission #001</h1>
            <div class="date">
                09:00
            </div>
        </header>
        <div class="cards">
            <div class="card">
                <i class="fa-solid fa-location-dot"></i>
                <h3>Gare Centrale</h3>
                <p>Distributeur concerné</p>
            </div>
            <div class="card">

                <i class="fa-solid fa-box"></i>

                <h3>4</h3>

                <p>Produits à recharger</p>

            </div>

            <div class="card">

                <i class="fa-solid fa-battery-quarter"></i>

                <h3>20%</h3>

                <p>Niveau de stock actuel</p>

            </div>

        </div>

        <section class="missions">

            <h2>Produits à recharger</h2>

            <table>

                <tr>
                    <th>Produit</th>
                    <th>Quantité</th>
                    <th>Statut</th>
                </tr>

                <tr>
                    <td>Coca-Cola</td>
                    <td>15</td>
                    <td><input type="checkbox"></td>
                </tr>

                <tr>
                    <td>Fanta</td>
                    <td>10</td>
                    <td><input type="checkbox"></td>
                </tr>

                <tr>
                    <td>Eau Cristaline</td>
                    <td>20</td>
                    <td><input type="checkbox"></td>
                </tr>

                <tr>
                    <td>Snickers</td>
                    <td>12</td>
                    <td><input type="checkbox"></td>
                </tr>

            </table>

        </section>

        <br>

        <section class="missions">

            <h2>Commentaire du manager</h2>

            <p>
                Le distributeur est presque vide.
                Vérifier également l'état général de la machine et signaler toute anomalie.
            </p>

        </section>

        <br>

        <section class="missions">

            <h2>Validation</h2>

            <button class="btn-mission">
                <i class="fa-solid fa-check"></i>
                Mission terminée
            </button>

        </section>

    </main>

    <script src="main.js"></script>

</body>

</html>