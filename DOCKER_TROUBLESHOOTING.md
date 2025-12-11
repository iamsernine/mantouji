# Guide de Dépannage : Erreur Docker `operation not supported`

## Introduction

L'erreur `failed to create endpoint ... operation not supported` que vous rencontrez lors de la commande `docker-compose build` n'est généralement pas liée au `Dockerfile` ou au projet lui-même. Il s'agit d'un problème au niveau de votre système d'exploitation hôte qui empêche Docker de créer correctement les réseaux virtuels nécessaires pour les conteneurs.

Cette erreur est fréquente sur les systèmes avec des configurations spécifiques :

- **Windows Subsystem for Linux (WSL)**, en particulier WSL 1.
- **Arch Linux** ou d'autres distributions avec des noyaux personnalisés.
- Des versions de Docker ou du noyau Linux obsolètes.

Ce guide vous propose plusieurs solutions, de la plus simple à la plus complexe, pour résoudre ce problème.

## Solutions de Dépannage

Suivez ces étapes dans l'ordre. Après chaque étape, essayez de relancer la commande `docker-compose build`.

### Solution 1 : Redémarrer Docker (La plus simple)

La première chose à faire est de redémarrer complètement le service Docker. Cela peut résoudre des problèmes temporaires.

**Sur la plupart des systèmes Linux (avec systemd) :**
```bash
sudo systemctl restart docker
```

**Avec Docker Desktop (Windows/Mac) :**
Cliquez sur l'icône de Docker dans la barre des tâches, puis sélectionnez "Restart".

### Solution 2 : Nettoyer Docker

Des ressources Docker (réseaux, conteneurs) corrompues peuvent causer des conflits. La commande `system prune` nettoie tout ce qui n'est pas utilisé.

```bash
docker system prune -a --volumes
```

**Attention** : Cette commande supprimera tous les conteneurs, réseaux, images et volumes non utilisés. Sauvegardez vos données si nécessaire.

### Solution 3 : Mettre à jour votre système et Docker

Assurez-vous que votre système d'exploitation et Docker sont à jour.

**Sur Debian/Ubuntu :**
```bash
sudo apt-get update && sudo apt-get upgrade -y
```

**Sur Arch Linux :**
```bash
sudo pacman -Syu
```

Ensuite, assurez-vous d'avoir la dernière version de Docker et Docker Compose.

### Solution 4 : Vérifier la configuration du noyau (Cause la plus probable)

L'erreur est souvent due à des modules de noyau manquants ou à une configuration de sécurité (comme AppArmor ou SELinux) trop restrictive.

1.  **Vérifier les modules du noyau**
    Docker a besoin de certains modules pour la gestion réseau. Vérifiez s'ils sont chargés :

    ```bash
    lsmod | grep -E "br_netfilter|veth"
    ```

    Si cette commande ne retourne rien, vous devrez peut-être charger les modules manuellement :

    ```bash
    sudo modprobe br_netfilter
    ```

2.  **Configuration réseau du noyau**
    Assurez-vous que le pontage réseau est activé :

    ```bash
    cat /proc/sys/net/bridge/bridge-nf-call-iptables
    ```

    Si la valeur est `0`, activez-la :

    ```bash
    echo 1 | sudo tee /proc/sys/net/bridge/bridge-nf-call-iptables
    ```

### Solution 5 : Spécifique à Windows Subsystem for Linux (WSL)

Si vous utilisez WSL, ce problème est très courant.

-   **Utilisez WSL 2, pas WSL 1** : WSL 1 n'a pas de noyau Linux complet et ne prend pas en charge toutes les fonctionnalités réseau de Docker. Vous devez absolument utiliser WSL 2.

    Pour vérifier votre version de WSL :

    ```powershell
    wsl -l -v
    ```

    Si votre distribution est en version 1, convertissez-la :

    ```powershell
    wsl --set-version <NomDeVotreDistribution> 2
    ```

-   **Redémarrez WSL** : Un redémarrage complet peut résoudre le problème.

    ```powershell
    wsl --shutdown
    ```

    Ensuite, rouvrez simplement votre terminal WSL.

### Solution 6 : Changer le pilote réseau par défaut de Docker

En dernier recours, vous pouvez forcer Docker à utiliser un pilote réseau différent, comme `bridge`.

1.  Créez ou modifiez le fichier de configuration de Docker `/etc/docker/daemon.json` :

    ```json
    {
        "bridge": "docker0"
    }
    ```

2.  Redémarrez le service Docker :

    ```bash
    sudo systemctl restart docker
    ```

## Optimisations Apportées au Projet

En parallèle, j'ai apporté quelques améliorations à vos fichiers de configuration Docker pour les rendre plus robustes et conformes aux standards actuels.

1.  **`docker-compose.yml`** : L'attribut `version` est obsolète et a été supprimé pour éviter les avertissements.
2.  **`Dockerfile`** : Les commandes `apt-get` ont été regroupées en une seule couche pour optimiser la taille de l'image et la vitesse de construction.

Ces changements ne corrigent pas directement l'erreur système que vous rencontrez, mais ils améliorent la qualité de votre configuration Docker.

J'espère que ce guide vous aidera à résoudre le problème. La **Solution 5 (passer à WSL 2)** est la plus probable si vous êtes sur Windows.
