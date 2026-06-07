-- =====================================================
-- LES DISTRIBUTEURS FANTÔME — Script SQL complet
-- =====================================================

CREATE DATABASE IF NOT EXISTS distributeurs_fantome CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE distributeurs_fantome;

-- =====================================================
-- TABLE : personne (entité parente employé/manager)
-- =====================================================
CREATE TABLE personne (
    id_employe INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    prenom VARCHAR(100) NOT NULL,
    role ENUM('employe', 'manager') NOT NULL DEFAULT 'employe',
    login VARCHAR(100) NOT NULL UNIQUE,
    mdp VARCHAR(255) NOT NULL,
    email VARCHAR(150),
    telephone VARCHAR(20),
    date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- =====================================================
-- TABLE : employe (sous-type)
-- =====================================================
CREATE TABLE employe (
    id_employe INT PRIMARY KEY,
    FOREIGN KEY (id_employe) REFERENCES personne(id_employe) ON DELETE CASCADE
);

-- =====================================================
-- TABLE : manager (sous-type)
-- =====================================================
CREATE TABLE manager (
    id_employe INT PRIMARY KEY,
    FOREIGN KEY (id_employe) REFERENCES personne(id_employe) ON DELETE CASCADE
);

-- =====================================================
-- TABLE : marque
-- =====================================================
CREATE TABLE marque (
    id_marque INT AUTO_INCREMENT PRIMARY KEY,
    libelle_marque VARCHAR(100) NOT NULL
);

-- =====================================================
-- TABLE : type_distributeur
-- =====================================================
CREATE TABLE type_distributeur (
    id_type INT AUTO_INCREMENT PRIMARY KEY,
    libelle_distributeur VARCHAR(100) NOT NULL
);

-- =====================================================
-- TABLE : etat_distributer
-- =====================================================
CREATE TABLE etat_distributer (
    id_etat INT AUTO_INCREMENT PRIMARY KEY,
    libelle_etat_distributeur VARCHAR(100) NOT NULL
);

-- =====================================================
-- TABLE : distributeur
-- =====================================================
CREATE TABLE distributeur (
    code_dist INT AUTO_INCREMENT PRIMARY KEY,
    libelle_distrib VARCHAR(150) NOT NULL,
    description TEXT,
    adress VARCHAR(255),
    id_type INT,
    id_marque INT,
    id_etat INT DEFAULT 1,
    date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_type) REFERENCES type_distributeur(id_type),
    FOREIGN KEY (id_marque) REFERENCES marque(id_marque),
    FOREIGN KEY (id_etat) REFERENCES etat_distributer(id_etat)
);

-- =====================================================
-- TABLE : type_emplacement
-- =====================================================
CREATE TABLE type_emplacement (
    id_type_emplacement INT AUTO_INCREMENT PRIMARY KEY,
    type_emplacement VARCHAR(100) NOT NULL
);

-- =====================================================
-- TABLE : emplacement
-- =====================================================
CREATE TABLE emplacement (
    numéro_emplacement INT AUTO_INCREMENT PRIMARY KEY,
    quantite_max INT NOT NULL DEFAULT 10,
    type_slote VARCHAR(100),
    code_dist INT NOT NULL,
    id_type_emplacement INT,
    FOREIGN KEY (code_dist) REFERENCES distributeur(code_dist) ON DELETE CASCADE,
    FOREIGN KEY (id_type_emplacement) REFERENCES type_emplacement(id_type_emplacement)
);

-- =====================================================
-- TABLE : produit
-- =====================================================
CREATE TABLE produit (
    id_produit INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(150) NOT NULL,
    categorie VARCHAR(100),
    prix_unitaire DECIMAL(10,2) DEFAULT 0.00
);

-- =====================================================
-- TABLE : stocker (produit dans emplacement)
-- =====================================================
CREATE TABLE stocker (
    numéro_emplacement INT,
    id_produit INT,
    PRIMARY KEY (numéro_emplacement, id_produit),
    FOREIGN KEY (numéro_emplacement) REFERENCES emplacement(numéro_emplacement) ON DELETE CASCADE,
    FOREIGN KEY (id_produit) REFERENCES produit(id_produit) ON DELETE CASCADE
);

-- =====================================================
-- TABLE : relier (produit dans mission avec quantité)
-- =====================================================
CREATE TABLE relier (
    id_mission INT,
    id_produit INT,
    qte_produit INT NOT NULL DEFAULT 0,
    fait TINYINT(1) DEFAULT 0,
    PRIMARY KEY (id_mission, id_produit),
    FOREIGN KEY (id_produit) REFERENCES produit(id_produit) ON DELETE CASCADE
);

-- =====================================================
-- TABLE : mission
-- =====================================================
CREATE TABLE mission (
    id_mission INT AUTO_INCREMENT PRIMARY KEY,
    date_mission DATE NOT NULL,
    heure_debut TIME,
    heure_fin TIME,
    statut_mission ENUM('en_attente', 'en_cours', 'terminee') DEFAULT 'en_attente',
    commentaire TEXT,
    code_dist INT,
    FOREIGN KEY (code_dist) REFERENCES distributeur(code_dist) ON DELETE SET NULL
);

-- Clé étrangère sur relier maintenant que mission existe
ALTER TABLE relier ADD FOREIGN KEY (id_mission) REFERENCES mission(id_mission) ON DELETE CASCADE;

-- =====================================================
-- TABLE : missioner (employé assigné à une mission)
-- =====================================================
CREATE TABLE missioner (
    id_mission INT,
    id_employe INT,
    PRIMARY KEY (id_mission, id_employe),
    FOREIGN KEY (id_mission) REFERENCES mission(id_mission) ON DELETE CASCADE,
    FOREIGN KEY (id_employe) REFERENCES personne(id_employe) ON DELETE CASCADE
);

-- =====================================================
-- TABLE : creer (manager crée une mission)
-- =====================================================
CREATE TABLE creer (
    id_mission INT,
    id_employe INT,
    PRIMARY KEY (id_mission, id_employe),
    FOREIGN KEY (id_mission) REFERENCES mission(id_mission) ON DELETE CASCADE,
    FOREIGN KEY (id_employe) REFERENCES personne(id_employe) ON DELETE CASCADE
);

-- =====================================================
-- DONNÉES DE BASE
-- =====================================================

-- Marques
INSERT INTO marque (libelle_marque) VALUES ('Necta'), ('Bianchi'), ('Azkoyen'), ('Selecta'), ('Wurlitzer');

-- Types de distributeur
INSERT INTO type_distributeur (libelle_distributeur) VALUES ('Café'), ('Boissons'), ('Snacks'), ('Mixte');

-- États
INSERT INTO etat_distributer (libelle_etat_distributeur) VALUES ('Actif'), ('Maintenance'), ('Hors service');

-- Types d'emplacement
INSERT INTO type_emplacement (type_emplacement) VALUES ('Canette'), ('Bouteille'), ('Snack'), ('Café');

-- Comptes utilisateurs (mdp : "password" hashé)
INSERT INTO personne (nom, prenom, role, login, mdp, email, telephone) VALUES
('Dupont', 'Jean', 'manager', 'manager', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'jean.dupont@fantome.fr', '06 00 00 00 00'),
('Dupont', 'Thomas', 'employe', 'thomas', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'thomas@fantome.fr', '06 11 11 11 11'),
('Martin', 'Lucas', 'employe', 'lucas', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'lucas@fantome.fr', '06 22 22 22 22'),
('Bernard', 'Emma', 'employe', 'emma', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'emma@fantome.fr', '06 33 33 33 33');

INSERT INTO manager (id_employe) VALUES (1);
INSERT INTO employe (id_employe) VALUES (2), (3), (4);

-- Distributeurs
INSERT INTO distributeur (libelle_distrib, description, adress, id_type, id_marque, id_etat) VALUES
('Gare Centrale', 'Distributeur principal gare', '1 Place de la Gare, Paris', 2, 1, 1),
('Université', 'Hall principal université', '5 Rue de l\'Université, Lille', 3, 2, 1),
('Mairie', 'Couloir accueil mairie', '1 Place de la Mairie, Lyon', 4, 1, 1),
('Hôpital', 'Salle d\'attente urgences', '10 Rue de la Santé, Paris', 1, 3, 2),
('Centre Commercial', 'Allée centrale niveau 1', '45 Avenue du Commerce, Bordeaux', 4, 2, 1);

-- Emplacements
INSERT INTO emplacement (quantite_max, type_slote, code_dist, id_type_emplacement) VALUES
(10, 'Canette', 1, 1), (10, 'Canette', 1, 1), (15, 'Bouteille', 1, 2), (8, 'Snack', 1, 3),
(10, 'Canette', 2, 1), (8, 'Snack', 2, 3), (8, 'Snack', 2, 3),
(10, 'Canette', 3, 1), (10, 'Bouteille', 3, 2), (8, 'Snack', 3, 3),
(12, 'Café', 4, 4), (12, 'Café', 4, 4),
(10, 'Canette', 5, 1), (10, 'Bouteille', 5, 2), (8, 'Snack', 5, 3);

-- Produits
INSERT INTO produit (nom, categorie, prix_unitaire) VALUES
('Coca-Cola', 'Boisson', 1.50),
('Fanta', 'Boisson', 1.50),
('Eau Cristaline', 'Boisson', 1.00),
('Snickers', 'Snack', 1.20),
('Twix', 'Snack', 1.20),
('Café Expresso', 'Café', 1.00),
('Café Noisette', 'Café', 1.10),
('Chips Lays', 'Snack', 1.50),
('Kit Kat', 'Confiserie', 1.20),
('Orangina', 'Boisson', 1.50);

-- Stocker (produits dans emplacements)
INSERT INTO stocker VALUES (1, 1), (2, 2), (3, 3), (4, 4), (5, 1), (6, 4), (7, 5), (8, 1), (9, 3), (10, 8), (11, 6), (12, 7);

-- Missions
INSERT INTO mission (date_mission, heure_debut, heure_fin, statut_mission, commentaire, code_dist) VALUES
('2026-06-06', '09:00:00', '10:00:00', 'en_attente', 'Le distributeur est presque vide. Vérifier également l\'état général de la machine et signaler toute anomalie.', 1),
('2026-06-06', '13:30:00', '14:30:00', 'en_attente', 'Réapprovisionnement standard.', 2),
('2026-06-06', '16:00:00', '17:00:00', 'en_attente', 'Vérifier aussi l\'état du coin café.', 3),
('2026-06-05', '09:00:00', '10:00:00', 'terminee', 'Mission effectuée sans anomalie.', 1),
('2026-06-05', '14:00:00', '15:00:00', 'terminee', 'RAS.', 5),
('2026-06-04', '10:00:00', '11:00:00', 'terminee', 'Tout bon.', 2);

-- Assignations employés aux missions
INSERT INTO missioner VALUES (1, 2), (2, 3), (3, 4), (4, 2), (5, 3), (6, 4);

-- Créateur (manager)
INSERT INTO creer VALUES (1, 1), (2, 1), (3, 1), (4, 1), (5, 1), (6, 1);

-- Produits dans missions
INSERT INTO relier (id_mission, id_produit, qte_produit, fait) VALUES
(1, 1, 10, 0), (1, 2, 8, 0), (1, 3, 12, 0), (1, 4, 5, 0),
(2, 1, 10, 0), (2, 4, 8, 0),
(3, 1, 5, 0), (3, 3, 10, 0), (3, 8, 6, 0),
(4, 1, 10, 1), (4, 2, 8, 1), (4, 3, 12, 1),
(5, 1, 10, 1), (5, 4, 8, 1),
(6, 1, 5, 1), (6, 3, 10, 1);
