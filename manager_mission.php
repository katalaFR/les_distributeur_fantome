<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Missions</title>
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
            <li>
                <i class="fa-solid fa-house"></i>
                Dashboard
            </li>
            <li class="active">
                <i class="fa-solid fa-list-check"></i>
                Missions
            </li>
            <li>
                <i class="fa-solid fa-box"></i>
                Distributeurs
            </li>
            <li>
                <i class="fa-solid fa-bottle-water"></i>
                Produits
            </li>
            <li>
                <i class="fa-solid fa-user"></i>
                Profil
            </li>
        </ul>
    </div>
    <main>
        <header>
            <h1>Gestion des Missions</h1>
            <div class="date">
                42 Missions
            </div>
        </header>
        <div class="cards">
            <div class="card">
                <i class="fa-solid fa-list-check"></i>
                <h3>42</h3>
                <p>Missions totales</p>
            </div>
            <div class="card">
                <i class="fa-solid fa-clock"></i>
                <h3>8</h3>
                <p>En attente</p>
            </div>
            <div class="card">
                <i class="fa-solid fa-circle-check"></i>
                <h3>34</h3>
                <p>Terminées</p>
            </div>
        </div>
        <section class="missions">
            <div class="page-title">
                <h2>Liste des missions</h2>
                <button class="btn-add">
                    <i class="fa-solid fa-plus"></i>
                    Nouvelle mission
                </button>
            </div>
            <div class="table-responsive">
                <table>
                    <tr>
                        <th>ID</th>
                        <th>Employé</th>
                        <th>Distributeur</th>
                        <th>Date</th>
                        <th>Statut</th>
                        <th>Action</th>
                    </tr>
                    <tr>
                        <td>#001</td>
                        <td>Thomas</td>
                        <td>Gare Centrale</td>
                        <td>21/06/2025</td>
                        <td>En attente</td>
                        <td>
                            <button class="btn-action">
                                Voir
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td>#002</td>
                        <td>Lucas</td>
                        <td>Université</td>
                        <td>20/06/2025</td>
                        <td>Terminée</td>
                        <td>
                            <button class="btn-action">
                                Voir
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td>#003</td>
                        <td>Emma</td>
                        <td>Mairie</td>
                        <td>20/06/2025</td>
                        <td>Terminée</td>
                        <td>
                            <button class="btn-action">
                                Voir
                            </button>
                        </td>
                    </tr>
                </table>
            </div>
        </section>
    </main>
    <script src="script.js"></script>
</body>

</html>