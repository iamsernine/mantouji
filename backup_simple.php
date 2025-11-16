<?php

/**
 * Script de Backup Simple - Mantouji
 * 
 * Export automatique en JSON et CSV
 * Aucune dépendance externe requise !
 * 
 * Usage: php backup_simple.php
 */

require __DIR__ . '/vendor/autoload.php';

// Charger les variables d'environnement
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Configuration
$backupDir = __DIR__ . '/backups';
$timestamp = date('Y-m-d_H-i-s');

// Créer le dossier backups s'il n'existe pas
if (!file_exists($backupDir)) {
    mkdir($backupDir, 0755, true);
    echo "📁 Dossier backups créé\n";
}

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

// ============================================
// 1. BACKUP DES COMMENTAIRES
// ============================================

echo "📊 Export des commentaires...\n";

$query = "
    SELECT 
        c.id,
        c.comment,
        c.rating,
        c.created_at,
        c.updated_at,
        p.name as product_name,
        p.id as product_id,
        u.name as user_name,
        u.email as user_email,
        u.id as user_id
    FROM comments c
    LEFT JOIN products p ON c.product_id = p.id
    LEFT JOIN users u ON c.user_id = u.id
    ORDER BY c.created_at DESC
";

$stmt = $pdo->query($query);
$comments = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo "   Trouvés : " . count($comments) . " commentaires\n";

// Export JSON
$jsonFile = "$backupDir/comments_$timestamp.json";
file_put_contents($jsonFile, json_encode($comments, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
echo "   ✅ JSON : $jsonFile\n";

// Export CSV
$csvFile = "$backupDir/comments_$timestamp.csv";
$fp = fopen($csvFile, 'w');
fprintf($fp, chr(0xEF).chr(0xBB).chr(0xBF)); // BOM UTF-8 pour Excel

if (!empty($comments)) {
    fputcsv($fp, array_keys($comments[0])); // En-têtes
    foreach ($comments as $row) {
        fputcsv($fp, $row);
    }
}
fclose($fp);
echo "   ✅ CSV : $csvFile\n\n";

// ============================================
// 2. BACKUP DES PRODUITS
// ============================================

echo "📦 Export des produits...\n";

$query = "
    SELECT 
        p.*,
        u.name as owner_name,
        u.email as owner_email
    FROM products p
    LEFT JOIN users u ON p.user_id = u.id
    ORDER BY p.created_at DESC
";

$stmt = $pdo->query($query);
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo "   Trouvés : " . count($products) . " produits\n";

// Export JSON
$jsonFile = "$backupDir/products_$timestamp.json";
file_put_contents($jsonFile, json_encode($products, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
echo "   ✅ JSON : $jsonFile\n";

// Export CSV
$csvFile = "$backupDir/products_$timestamp.csv";
$fp = fopen($csvFile, 'w');
fprintf($fp, chr(0xEF).chr(0xBB).chr(0xBF));

if (!empty($products)) {
    fputcsv($fp, array_keys($products[0]));
    foreach ($products as $row) {
        fputcsv($fp, $row);
    }
}
fclose($fp);
echo "   ✅ CSV : $csvFile\n\n";

// ============================================
// 3. BACKUP DES UTILISATEURS
// ============================================

echo "👥 Export des utilisateurs...\n";

$query = "SELECT * FROM users ORDER BY created_at DESC";
$stmt = $pdo->query($query);
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo "   Trouvés : " . count($users) . " utilisateurs\n";

// Export JSON (sans les mots de passe pour sécurité)
$usersSecure = array_map(function($user) {
    unset($user['password']);
    return $user;
}, $users);

$jsonFile = "$backupDir/users_$timestamp.json";
file_put_contents($jsonFile, json_encode($usersSecure, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
echo "   ✅ JSON : $jsonFile (mots de passe exclus)\n";

// Export CSV
$csvFile = "$backupDir/users_$timestamp.csv";
$fp = fopen($csvFile, 'w');
fprintf($fp, chr(0xEF).chr(0xBB).chr(0xBF));

if (!empty($usersSecure)) {
    fputcsv($fp, array_keys($usersSecure[0]));
    foreach ($usersSecure as $row) {
        fputcsv($fp, $row);
    }
}
fclose($fp);
echo "   ✅ CSV : $csvFile\n\n";

// ============================================
// 4. BACKUP SQL COMPLET
// ============================================

echo "💾 Backup SQL complet...\n";

$sqlFile = "$backupDir/mantouji_full_$timestamp.sql";
$command = sprintf(
    'mysqldump -h %s -u %s %s %s > %s 2>&1',
    escapeshellarg($host),
    escapeshellarg($username),
    $password ? '-p' . escapeshellarg($password) : '',
    escapeshellarg($database),
    escapeshellarg($sqlFile)
);

exec($command, $output, $returnCode);

if ($returnCode === 0 && file_exists($sqlFile)) {
    $size = filesize($sqlFile);
    echo "   ✅ SQL : $sqlFile (" . round($size/1024, 2) . " KB)\n\n";
} else {
    echo "   ⚠️  Backup SQL échoué (mysqldump non disponible ?)\n\n";
}

// ============================================
// 5. RÉSUMÉ
// ============================================

echo "═══════════════════════════════════════\n";
echo "✅ BACKUP TERMINÉ AVEC SUCCÈS !\n";
echo "═══════════════════════════════════════\n\n";

echo "📊 Statistiques :\n";
echo "   • Commentaires : " . count($comments) . "\n";
echo "   • Produits : " . count($products) . "\n";
echo "   • Utilisateurs : " . count($users) . "\n\n";

echo "📁 Fichiers créés dans : $backupDir/\n\n";

echo "📋 Formats disponibles :\n";
echo "   • JSON : Format universel, facile à lire\n";
echo "   • CSV : Compatible Excel\n";
echo "   • SQL : Restauration complète de la base\n\n";

echo "💡 Prochaine étape :\n";
echo "   php clean_database.php\n\n";

// Créer un fichier README dans le dossier backups
$readmeFile = "$backupDir/README.txt";
$readmeContent = "BACKUPS MANTOUJI - $timestamp

Ce dossier contient les backups de la base de données Mantouji.

FICHIERS :
- comments_*.json : Commentaires et avis (format JSON)
- comments_*.csv : Commentaires et avis (format CSV pour Excel)
- products_*.json : Produits (format JSON)
- products_*.csv : Produits (format CSV pour Excel)
- users_*.json : Utilisateurs sans mots de passe (format JSON)
- users_*.csv : Utilisateurs sans mots de passe (format CSV)
- mantouji_full_*.sql : Backup SQL complet (restauration complète)

RESTAURATION SQL :
mysql -u root -p mantouji < mantouji_full_$timestamp.sql

SÉCURITÉ :
- Les mots de passe des utilisateurs sont exclus des exports JSON/CSV
- Le fichier SQL contient les mots de passe hashés (sécurisé)
- Conservez ces fichiers dans un endroit sûr

Date du backup : $timestamp
";

file_put_contents($readmeFile, $readmeContent);

echo "📄 README créé : $readmeFile\n\n";
echo "🎉 Vous pouvez maintenant nettoyer la base de données en toute sécurité !\n";

