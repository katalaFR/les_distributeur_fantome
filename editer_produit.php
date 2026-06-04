<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier Produit</title>
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
        <h1>Modifier Produit</h1>
        <div class="date">
            ID #PROD-001
        </div>
</header>
    <div class="cards">
        <div class="card">
            <i class="fa-solid fa-bottle-water"></i>
            <h3>Coca-Cola</h3>
            <p>Produit</p>
    </div>
        <div class="card">
            <i class="fa-solid fa-tags"></i>
            <h3>Boisson</h3>
            <p>Catégorie</p>
    </div>
        <div class="card">
            <i class="fa-solid fa-euro-sign"></i>
            <h3>1.50€</h3>
            <p>Prix</p>
    </div>
</div>
    <section class="missions">
        <h2>Informations Produit</h2>
        <br>
        <form>
            <div class="input-group">
                <label>Nom du produit</label>
                <input
                type="text"
                value="Coca-Cola">
        </div>
            <div class="input-group">
                <label>Catégorie</label>
                <select>
                    <option>Boisson</option>
                    <option>Snack</option>
                    <option>Café</option>
                    <option>Confiserie</option>
            </select>
        </div>
            <div class="input-group">
                <label>Prix unitaire (€)</label>
                <input
                type="number"
                step="0.01"
                value="1.50">
        </div>
    </form>
</section>
    <br>
    <section class="missions">
        <h2>Utilisation</h2>
        <br>
        <div class="cards">
            <div class="card">
                <i class="fa-solid fa-store"></i>
                <h3>8</h3>
                <p>Distributeurs</p>
        </div>
            <div class="card">
                <i class="fa-solid fa-cube"></i>
                <h3>23</h3>
                <p>Emplacements</p>
        </div>
    </div>
</section>
    <br>
    <div class="action-buttons">
        <button class="btn-create">
            <i class="fa-solid fa-floppy-disk"></i>
            Enregistrer
    </button>
        <button class="btn-delete">
            <i class="fa-solid fa-trash"></i>
            Supprimer
    </button>
</div>
</main>
    <script src="script.js"></script>
</body>
    </html>