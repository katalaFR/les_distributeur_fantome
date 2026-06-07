<?php
// sidebar_manager.php — sidebar réutilisable pour l'espace manager
$currentPage = basename($_SERVER['PHP_SELF']);
?>
<button id="menu-toggle" class="menu-toggle"><i class="fa-solid fa-bars"></i></button>
<div class="sidebar" id="sidebar">
    <div class="logo"><img src="image/logo.png" alt="logo"></div>
    <ul>
        <li class="<?= $currentPage === 'index_manager.php' ? 'active' : '' ?>" onclick="location.href='index_manager.php'">
            <i class="fa-solid fa-house"></i> Dashboard
        </li>
        <li class="<?= in_array($currentPage, ['manager_mission.php','crée_mission.php','detaile_mission.php']) ? 'active' : '' ?>" onclick="location.href='manager_mission.php'">
            <i class="fa-solid fa-list-check"></i> Missions
        </li>
        <li class="<?= in_array($currentPage, ['distributeur.php','editer_distributeur.php','editer_emplacement.php']) ? 'active' : '' ?>" onclick="location.href='distributeur.php'">
            <i class="fa-solid fa-box"></i> Distributeurs
        </li>
        <li class="<?= in_array($currentPage, ['produit.php','editer_produit.php']) ? 'active' : '' ?>" onclick="location.href='produit.php'">
            <i class="fa-solid fa-bottle-water"></i> Produits
        </li>
        <li class="<?= $currentPage === 'profil_manager.php' ? 'active' : '' ?>" onclick="location.href='profil_manager.php'">
            <i class="fa-solid fa-user"></i> Profil
        </li>
        <li onclick="location.href='logout.php'">
            <i class="fa-solid fa-right-from-bracket"></i> Déconnexion
        </li>
    </ul>
</div>
