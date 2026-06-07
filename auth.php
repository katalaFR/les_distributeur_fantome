<?php
// =====================================================
// AUTH.PHP — Protection des pages + helpers session
// Inclure en haut de chaque page protégée
// =====================================================

require_once __DIR__ . '/config.php';

session_start();

function requireLogin(): void {
    if (empty($_SESSION['id_employe'])) {
        header('Location: login.php');
        exit;
    }
}

function requireManager(): void {
    requireLogin();
    if ($_SESSION['role'] !== 'manager') {
        header('Location: index.php');
        exit;
    }
}

function currentUser(): array {
    return $_SESSION['user'] ?? [];
}

function isManager(): bool {
    return ($_SESSION['role'] ?? '') === 'manager';
}
