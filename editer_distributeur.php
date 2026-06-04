<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier Distributeur</title>
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
            <h1>Modifier un distributeur</h1>
            <div class="date">
                #DIST-001
            </div>
        </header>
        <div class="cards">
            <div class="card">
                <i class="fa-solid fa-mug-hot"></i>
                <h3>Café</h3>
                <p>Type</p>
            </div>
            <div class="card">
                <i class="fa-solid fa-industry"></i>
                <h3>Necta</h3>
                <p>Marque</p>
            </div>
            <div class="card">
                <i class="fa-solid fa-circle-check"></i>
                <h3>Actif</h3>
                <p>État</p>
            </div>
        </div>
        <section class="missions">
            <h2>Informations générales</h2>
            <br>
            <form>
                <div class="input-group">
                    <label>Nom du distributeur</label>
                    <input
                        type="text"
                        value="Gare Centrale">
                </div>
                <div class="input-group">
                    <label>Adresse</label>
                    <input
                        type="text"
                        value="1 Place de la Gare">
                </div>
                <div class="input-group">
                    <label>Type de distributeur</label>
                    <select>
                        <option>Café</option>
                        <option>Boissons</option>
                        <option>Snacks</option>
                        <option>Mixte</option>
                    </select>
                </div>
                <div class="input-group">
                    <label>Marque</label>
                    <select>
                        <option>Necta</option>
                        <option>Bianchi</option>
                        <option>Azkoyen</option>
                    </select>
                </div>
                <div class="input-group">
                    <label>État</label>
                    <select>
                        <option>Actif</option>
                        <option>Maintenance</option>
                        <option>Hors service</option>
                    </select>
                </div>
            </form>
        </section>
        <section class="missions">
            <div class="page-title">
                <h2>Emplacements</h2>
                <button class="btn-add">
                    <i class="fa-solid fa-plus"></i>
                    Ajouter
                </button>
            </div>
            <table>
                <tr>
                    <th>N°</th>
                    <th>Produit</th>
                    <th>Qté max</th>
                    <th>Type</th>
                    <th>Action</th>
                </tr>
                <tr>
                    <td>1</td>
                    <td>Coca-Cola</td>
                    <td>10</td>
                    <td>Canette</td>
                    <td>
                        <button class="btn-action">
                            Modifier
                        </button>
                    </td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>Fanta</td>
                    <td>10</td>
                    <td>Canette</td>
                    <td>
                        <button class="btn-action">
                            Modifier
                        </button>
                    </td>
                </tr>
                <tr>
                    <td>3</td>
                    <td>Eau Cristaline</td>
                    <td>15</td>
                    <td>Bouteille</td>
                    <td>
                        <button class="btn-action">
                            Modifier
                        </button>
                    </td>
                </tr>
            </table>
        </section>
        <br>
        <button class="btn-create">
            <i class="fa-solid fa-floppy-disk"></i>
            Enregistrer les modifications
        </button>
    </main>
    <script src="sript.js"></script>
</body>

</html>