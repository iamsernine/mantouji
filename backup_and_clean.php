<?php

/**
 * Script Tout-en-Un : Backup + Nettoyage
 * 
 * Ce script fait automatiquement :
 * 1. Backup complet (JSON + CSV + SQL)
 * 2. Nettoyage de la base de données
 * 
 * Usage: php backup_and_clean.php
 */

echo "\n";
echo "╔═══════════════════════════════════════╗\n";
echo "║   MANTOUJI - BACKUP & CLEAN          ║\n";
echo "╚═══════════════════════════════════════╝\n";
echo "\n";

// ============================================
// ÉTAPE 1 : BACKUP
// ============================================

echo "🔄 ÉTAPE 1/2 : BACKUP DES DONNÉES\n";
echo "═══════════════════════════════════════\n\n";

// Exécuter le script de backup
passthru('php ' . __DIR__ . '/backup_simple.php', $backupResult);

if ($backupResult !== 0) {
    die("\n❌ Erreur lors du backup. Nettoyage annulé.\n");
}

echo "\n";
echo "⏸️  Pause de 3 secondes...\n";
sleep(3);
echo "\n";

// ============================================
// ÉTAPE 2 : NETTOYAGE
// ============================================

echo "🔄 ÉTAPE 2/2 : NETTOYAGE DE LA BASE\n";
echo "═══════════════════════════════════════\n\n";

require __DIR__ . '/vendor/autoload.php';

// Charger les variables d'environnement
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Connexion à la base de données
$host = $_ENV['DB_HOST'] ?? 'localhost';
$database = $_ENV['DB_DATABASE'] ?? 'mantouji';
$username = $_ENV['DB_USERNAME'] ?? 'root';
$password = $_ENV['DB_PASSWORD'] ?? '';

try {
    $pdo = new PDO(
        "mysql:host=$host;dbname=$database;charset=utf8mb4",
        $username,
        $password
    );
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "✅ Connexion à la base de données réussie\n\n";
} catch (PDOException $e) {
    die("❌ Erreur de connexion : " . $e->getMessage() . "\n");
}

// Fonction pour compter les enregistrements
function countRecords($pdo, $table) {
    try {
        $stmt = $pdo->query("SELECT COUNT(*) FROM $table");
        return $stmt->fetchColumn();
    } catch (PDOException $e) {
        return 0;
    }
}

// Statistiques avant nettoyage
echo "📊 AVANT NETTOYAGE :\n";
$tables = ['users', 'products', 'comments'];
foreach ($tables as $table) {
    $count = countRecords($pdo, $table);
    echo "   • $table : $count enregistrements\n";
}

echo "\n";
echo "⚠️  ATTENTION : Nettoyage dans 5 secondes...\n";
echo "   Appuyez sur Ctrl+C pour annuler\n\n";

for ($i = 5; $i > 0; $i--) {
    echo "   $i...\n";
    sleep(1);
}

echo "\n🧹 Nettoyage en cours...\n\n";

try {
    // Désactiver les contraintes de clés étrangères
    $pdo->exec("SET FOREIGN_KEY_CHECKS = 0");
    
    // Supprimer les données
    $deletedComments = $pdo->exec("DELETE FROM comments");
    echo "   ✅ Commentaires supprimés : $deletedComments\n";
    
    $deletedProducts = $pdo->exec("DELETE FROM products");
    echo "   ✅ Produits supprimés : $deletedProducts\n";
    
    $deletedUsers = $pdo->exec("DELETE FROM users");
    echo "   ✅ Utilisateurs supprimés : $deletedUsers\n";
    
    // Réinitialiser les auto-increment
    $pdo->exec("ALTER TABLE comments AUTO_INCREMENT = 1");
    $pdo->exec("ALTER TABLE products AUTO_INCREMENT = 1");
    $pdo->exec("ALTER TABLE users AUTO_INCREMENT = 1");
    echo "   ✅ Compteurs réinitialisés\n";
    
    // Réactiver les contraintes
    $pdo->exec("SET FOREIGN_KEY_CHECKS = 1");
    
    echo "\n";
    echo "📊 APRÈS NETTOYAGE :\n";
    foreach ($tables as $table) {
        $count = countRecords($pdo, $table);
        echo "   • $table : $count enregistrements\n";
    }
    
    echo "\n";
    echo "╔═══════════════════════════════════════╗\n";
    echo "║   ✅ TERMINÉ AVEC SUCCÈS !           ║\n";
    echo "╚═══════════════════════════════════════╝\n";
    echo "\n";
    echo "📁 Backups sauvegardés dans : backups/\n";
    echo "🎉 Base de données nettoyée et prête pour la production !\n\n";
    
} catch (PDOException $e) {
    echo "\n❌ ERREUR : " . $e->getMessage() . "\n";
    echo "⚠️  La base peut être dans un état incohérent.\n";
    echo "💡 Restaurez le backup : mysql -u root -p mantouji < backups/mantouji_full_*.sql\n\n";
    exit(1);
}

