<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes Missions</title>
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
            <h1>Mes Missions</h1>
            <div class="date">
                3 Missions à effectuer
            </div>
        </header>
        <div class="cards">
            <div class="card">
                <i class="fa-solid fa-train"></i>
                <h3>09:00</h3>
                <p>Gare Centrale</p>
                <p>Mission #001</p>
                <button class="btn-mission" onclick="location.href='mission.php?id=1'">
                    Voir la mission
                </button>
            </div>
            <div class="card">
                <i class="fa-solid fa-school"></i>
                <h3>13:30</h3>
                <p>Université</p>
                <p>Mission #002</p>
                <button class="btn-mission">
                    Voir la mission
                </button>
            </div>
            <div class="card">
                <i class="fa-solid fa-building-columns"></i>
                <h3>16:00</h3>
                <p>Mairie</p>
                <p>Mission #003</p>
                <button class="btn-mission">
                    Voir la mission
                </button>
            </div>
        </div>
    </main>
    <script src="script.js"></script>
</body>

</html>