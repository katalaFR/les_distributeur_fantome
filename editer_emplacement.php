<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier Emplacement</title>
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
            <li class="active">
                <i class="fa-solid fa-box"></i>
                Distributeurs
            </li>
            <li>
                <i class="fa-solid fa-bottle-water"></i>
                Produits
            </li>
        </ul>
    </div>
    <main>
        <header>
            <h1>Emplacement N°1</h1>
            <div class="date">
                Gare Centrale
            </div>
        </header>
        <div class="cards">
            <div class="card">
                <i class="fa-solid fa-cube"></i>
                <h3>Coca-Cola</h3>
                <p>Produit actuel</p>
            </div>
            <div class="card">
                <i class="fa-solid fa-layer-group"></i>
                <h3>10</h3>
                <p>Quantité max</p>
            </div>
            <div class="card">
                <i class="fa-solid fa-tag"></i>
                <h3>Canette</h3>
                <p>Type emplacement</p>
            </div>
        </div>
        <section class="missions">
            <h2>Configuration</h2>
            <br>
            <form>
                <div class="input-group">
                    <label>Numéro emplacement</label>
                    <input
                        type="number"
                        value="1">
                </div>
                <div class="input-group">
                    <label>Produit</label>
                    <select>
                        <option>Coca-Cola</option>
                        <option>Fanta</option>
                        <option>Eau Cristaline</option>
                        <option>Snickers</option>
                    </select>
                </div>
                <div class="input-group">
                    <label>Quantité maximale</label>
                    <input
                        type="number"
                        value="10">
                </div>
                <div class="input-group">
                    <label>Type d'emplacement</label>
                    <select>
                        <option>Canette</option>
                        <option>Bouteille</option>
                        <option>Snack</option>
                        <option>Café</option>
                    </select>
                </div>
            </form>
        </section>
        <br>
        <button class="btn-create">
            <i class="fa-solid fa-floppy-disk"></i>
            Enregistrer
        </button>
    </main>
    <script src="script.js"></script>
</body>

</html>