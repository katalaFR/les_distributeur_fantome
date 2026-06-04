<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Distributeurs</title>
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
            <li class="active">
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
            <h1>Distributeurs</h1>
            <div class="date">
                12 Machines
            </div>
        </header>
        <div class="cards">
            <div class="card">
                <i class="fa-solid fa-store"></i>
                <h3>12</h3>
                <p>Distributeurs</p>
            </div>
            <div class="card">
                <i class="fa-solid fa-triangle-exclamation"></i>
                <h3>2</h3>
                <p>En alerte</p>
            </div>
            <div class="card">
                <i class="fa-solid fa-location-dot"></i>
                <h3>8</h3>
                <p>Villes couvertes</p>
            </div>
        </div>
        <section class="missions">
            <div class="page-title">
                <h2>Liste des distributeurs</h2>
                <button class="btn-add">
                    <i class="fa-solid fa-plus"></i>
                    Nouveau
                </button>
            </div>
            <table>
                <tr>
                    <th>Nom</th>
                    <th>Type</th>
                    <th>Lieu</th>
                    <th>Actions</th>
                </tr>
                <tr>
                    <td>Gare Centrale</td>
                    <td>Boissons</td>
                    <td>Paris</td>
                    <td>
                        <button class="btn-action">
                            Modifier
                        </button>
                    </td>
                </tr>
                <tr>
                    <td>Université</td>
                    <td>Snacks</td>
                    <td>Lille</td>
                    <td>
                        <button class="btn-action">
                            Modifier
                        </button>
                    </td>
                </tr>
                <tr>
                    <td>Mairie</td>
                    <td>Mixte</td>
                    <td>Lyon</td>
                    <td>
                        <button class="btn-action">
                            Modifier
                        </button>
                    </td>
                </tr>
            </table>
        </section>
    </main>
    <script src="script.js"></script>
</body>

</html>