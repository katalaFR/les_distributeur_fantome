<?php
// =====================================================
// CONFIGURATION BASE DE DONNÉES
// Modifie ces valeurs selon ton environnement
// =====================================================

define('DB_HOST', 'localhost');
define('DB_NAME', 'distributeurs_fantome');
define('DB_USER', 'root');       // ← ton user MySQL
define('DB_PASS', '');           // ← ton mot de passe MySQL
define('DB_CHARSET', 'utf8mb4');

function getPDO(): PDO {
    static $pdo = null;
    if ($pdo === null) {
        try {
            $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=' . DB_CHARSET;
            $pdo = new PDO($dsn, DB_USER, DB_PASS, [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ]);
        } catch (PDOException $e) {
            die('<div style="background:#8b0000;color:white;padding:20px;font-family:monospace;">
                Erreur de connexion BDD : ' . htmlspecialchars($e->getMessage()) . '
                <br>Vérifie les paramètres dans config.php
            </div>');
        }
    }
    return $pdo;
}
