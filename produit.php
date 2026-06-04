<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produits</title>
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
            <li>
                <i class="fa-solid fa-list-check"></i>
                Missions
            </li>
            <li>
                <i class="fa-solid fa-box"></i>
                Distributeurs
            </li>
            <li class="active">
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
            <h1>Produits</h1>
            <div class="date">
                48 Produits
            </div>
        </header>
        <div class="cards">
            <div class="card">
                <i class="fa-solid fa-bottle-water"></i>
                <h3>48</h3>
                <p>Produits</p>
            </div>
            <div class="card">
                <i class="fa-solid fa-mug-hot"></i>
                <h3>12</h3>
                <p>Boissons chaudes</p>
            </div>
            <div class="card">
                <i class="fa-solid fa-cookie-bite"></i>
                <h3>18</h3>
                <p>Snacks</p>
            </div>
        </div>
        <section class="missions">
            <div class="page-title">
                <h2>Catalogue Produits</h2>
                <button class="btn-add">
                    <i class="fa-solid fa-plus"></i>
                    Nouveau Produit
                </button>
            </div>
            <div class="table-responsive">
                <table>
                    <tr>
                        <th>Nom</th>
                        <th>Catégorie</th>
                        <th>Prix</th>
                        <th>Action</th>
                    </tr>
                    <tr>
                        <td>Coca-Cola</td>
                        <td>Boisson</td>
                        <td>1.50 €</td>
                        <td>
                            <button class="btn-action">
                                Modifier
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td>Fanta</td>
                        <td>Boisson</td>
                        <td>1.50 €</td>
                        <td>
                            <button class="btn-action">
                                Modifier
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td>Snickers</td>
                        <td>Snack</td>
                        <td>1.20 €</td>
                        <td>
                            <button class="btn-action">
                                Modifier
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td>Café Expresso</td>
                        <td>Café</td>
                        <td>1.00 €</td>
                        <td>
                            <button class="btn-action">
                                Modifier
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