<?php
// sidebar_employe.php — sidebar réutilisable pour l'espace employé
$currentPage = basename($_SERVER['PHP_SELF']);
?>
<button id="menu-toggle" class="menu-toggle"><i class="fa-solid fa-bars"></i></button>
<div class="sidebar" id="sidebar">
    <div class="logo"><img src="image/logo.png" alt="logo"></div>
    <ul>
        <li class="<?= $currentPage === 'index.php' ? 'active' : '' ?>" onclick="location.href='index.php'">
            <i class="fa-solid fa-house"></i> Tableau de bord
        </li>
        <li class="<?= $currentPage === 'mission.php' ? 'active' : '' ?>" onclick="location.href='mission.php'">
            <i class="fa-solid fa-list-check"></i> Mes missions
        </li>
        <li class="<?= $currentPage === 'historique.php' ? 'active' : '' ?>" onclick="location.href='historique.php'">
            <i class="fa-solid fa-clock-rotate-left"></i> Historique
        </li>
        <li class="<?= $currentPage === 'profil.php' ? 'active' : '' ?>" onclick="location.href='profil.php'">
            <i class="fa-solid fa-user"></i> Mon profil
        </li>
        <li onclick="location.href='logout.php'">
            <i class="fa-solid fa-right-from-bracket"></i> Déconnexion
        </li>
    </ul>
</div>
