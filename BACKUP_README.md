# 🚀 Backup et Nettoyage Simple - Mantouji

Scripts ultra-simples pour faire un backup et nettoyer la base de données.

**Aucune configuration compliquée !**

---

## 🎯 Utilisation Rapide

### Option 1 : Tout-en-Un (Recommandé)

```bash
php backup_and_clean.php
```

**Ce script fait automatiquement** :
1. ✅ Backup complet (JSON + CSV + SQL)
2. ✅ Nettoyage de la base de données
3. ✅ Pause de 5 secondes avant nettoyage (vous pouvez annuler)

---

### Option 2 : Étape par Étape

#### 1. Faire le backup

```bash
php backup_simple.php
```

**Résultat** :
- Crée un dossier `backups/`
- Export en **3 formats** :
  - 📄 **JSON** : Format universel
  - 📊 **CSV** : Compatible Excel
  - 💾 **SQL** : Restauration complète

#### 2. Nettoyer la base

```bash
php clean_database.php
```

**Confirmation requise** : Tapez `OUI` en majuscules

---

## 📦 Ce qui est sauvegardé

### Commentaires
- Texte du commentaire
- Note (étoiles)
- Nom du produit
- Nom de l'utilisateur
- Dates

### Produits
- Nom du produit
- Image
- Avis moyens
- Propriétaire

### Utilisateurs
- Nom
- Email
- Type (Client/Coopérative)
- **Mots de passe exclus des JSON/CSV** (sécurité)

---

## 📁 Structure des Backups

```
backups/
├── comments_2025-01-17_14-30-00.json
├── comments_2025-01-17_14-30-00.csv
├── products_2025-01-17_14-30-00.json
├── products_2025-01-17_14-30-00.csv
├── users_2025-01-17_14-30-00.json
├── users_2025-01-17_14-30-00.csv
├── mantouji_full_2025-01-17_14-30-00.sql
└── README.txt
```

---

## 🔄 Restauration

### Restaurer depuis SQL (recommandé)

```bash
mysql -u root -p mantouji < backups/mantouji_full_2025-01-17_14-30-00.sql
```

### Consulter les données JSON

```bash
cat backups/comments_2025-01-17_14-30-00.json
```

### Ouvrir les CSV dans Excel

Double-cliquer sur le fichier `.csv`

---

## 🛡️ Sécurité

✅ **Mots de passe protégés** : Les exports JSON/CSV n'incluent PAS les mots de passe  
✅ **Backup SQL sécurisé** : Les mots de passe sont hashés (bcrypt)  
✅ **Dossier local** : Tous les backups restent sur votre serveur  
✅ **Pas de cloud** : Aucune donnée envoyée à l'extérieur  

---

## ⚡ Commandes Rapides

### Backup seulement

```bash
php backup_simple.php
```

### Backup + Clean (automatique)

```bash
php backup_and_clean.php
```

### Clean seulement (avec confirmation)

```bash
php clean_database.php
```

### Voir les backups

```bash
ls -lh backups/
```

### Supprimer les vieux backups

```bash
# Garder seulement les 5 derniers
cd backups && ls -t | tail -n +6 | xargs rm -f
```

---

## 🔧 Dépannage

### Erreur : "vendor/autoload.php not found"

```bash
composer install
```

### Erreur : "Connection refused"

Vérifier que MySQL est démarré :
```bash
sudo systemctl start mysql
```

### Erreur : "mysqldump not found"

Le backup SQL sera ignoré, mais JSON et CSV fonctionneront.

---

## 📊 Exemple de Sortie

```
✅ Connexion à la base de données réussie

📊 Export des commentaires...
   Trouvés : 42 commentaires
   ✅ JSON : backups/comments_2025-01-17_14-30-00.json
   ✅ CSV : backups/comments_2025-01-17_14-30-00.csv

📦 Export des produits...
   Trouvés : 15 produits
   ✅ JSON : backups/products_2025-01-17_14-30-00.json
   ✅ CSV : backups/products_2025-01-17_14-30-00.csv

👥 Export des utilisateurs...
   Trouvés : 8 utilisateurs
   ✅ JSON : backups/users_2025-01-17_14-30-00.json
   ✅ CSV : backups/users_2025-01-17_14-30-00.csv

💾 Backup SQL complet...
   ✅ SQL : backups/mantouji_full_2025-01-17_14-30-00.sql (245 KB)

═══════════════════════════════════════
✅ BACKUP TERMINÉ AVEC SUCCÈS !
═══════════════════════════════════════

📊 Statistiques :
   • Commentaires : 42
   • Produits : 15
   • Utilisateurs : 8

📁 Fichiers créés dans : backups/

🎉 Vous pouvez maintenant nettoyer la base de données en toute sécurité !
```

---

## 💡 Conseils

1. **Faites toujours un backup avant de nettoyer**
2. **Vérifiez que le backup est complet** (ouvrez les fichiers)
3. **Gardez plusieurs backups** (ne supprimez pas les anciens)
4. **Testez la restauration** sur une base de test d'abord

---

## 📞 Support

- 🌐 Site : www.Mantouji.org
- 📧 Contact : Tech-da (https://www.tech-da.com/)

---

**Dernière mise à jour** : 17 janvier 2025

