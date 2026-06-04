<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créer une Mission</title>
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
            <li class="active">
                <i class="fa-solid fa-plus"></i>
                Créer Mission
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
        </ul>
    </div>
    <main>
        <header>
            <h1>Créer une Mission</h1>
            <div class="date">
                Manager
            </div>
        </header>
        <section class="missions">
            <h2>Informations Mission</h2>
            <br>
            <form>
                <div class="input-group">
                    <label>Employé</label>
                    <select>
                        <option>Thomas</option>
                        <option>Lucas</option>
                        <option>Emma</option>
                    </select>
                </div>
                <div class="input-group">
                    <label>Distributeur</label>
                    <select>
                        <option>Gare Centrale</option>
                        <option>Université</option>
                        <option>Mairie</option>
                    </select>
                </div>
                <div class="input-group">
                    <label>Date de mission</label>
                    <input type="datetime-local">
                </div>
                <div class="input-group">
                    <label>Commentaire</label>
                    <textarea rows="5"></textarea>
                </div>
            </form>
        </section>
        <br>
        <section class="missions">
            <h2>Produits à Recharger</h2>
            <br>
            <table>
                <tr>
                    <th>Produit</th>
                    <th>Quantité</th>
                </tr>
                <tr>
                    <td>Coca-Cola</td>
                    <td>
                        <input type="number" min="0" value="10">
                    </td>
                </tr>
                <tr>
                    <td>Fanta</td>
                    <td>
                        <input type="number" min="0" value="5">
                    </td>
                </tr>
                <tr>
                    <td>Eau Cristaline</td>
                    <td>
                        <input type="number" min="0" value="20">
                    </td>
                </tr>
                <tr>
                    <td>Snickers</td>
                    <td>
                        <input type="number" min="0" value="12">
                    </td>
                </tr>
            </table>
        </section>
        <br>
        <button class="btn-create">
            <i class="fa-solid fa-floppy-disk"></i>
            Créer la Mission
        </button>
    </main>
    <script src="script.js"></script>
</body>

</html>