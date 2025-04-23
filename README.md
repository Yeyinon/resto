# Système de réservation de tables en ligne pour restaurants

Ce projet est une application web de réservation de tables en ligne pour les restaurants, développé en utilisant Laravel, HTML, CSS, JavaScript, Bootstrap et MySQL. Le système permet à trois acteurs principaux, à savoir l'administrateur, le propriétaire du restaurant et le client, d'interagir avec la plateforme.

![Accueil](public/screenshots/accueil.png)

## Fonctionnalités

- **Administrateur** :
    - Gestion des comptes utilisateurs (ajout, suppression, modification)
    - Gestion des restaurants (ajout, suppression, modification)
    - Suivi des réservations et des statistiques

- **Propriétaire du restaurant** :
    - Création et gestion du profil du restaurant
    - Paramétrage de la capacité des tables (ajout, suppression, modification)
    - Gestion des réservations 
    - Consultation des statistiques de réservation

- **Client** :
    - Création du profil client
    - Recherche de restaurants disponibles par emplacement, date et heure
    - Visualisation des informations détaillées du restaurant
    - Réservation d'une table en spécifiant le nombre de personnes
   

## Technologies utilisées

- Laravel : Framework PHP pour le développement back-end
- HTML, CSS, JavaScript : Développement front-end pour l'interface utilisateur
- Bootstrap : Framework CSS pour un design réactif et esthétique
- MySQL : Base de données relationnelle pour le stockage des informations sur les restaurants et les réservations

## Installation

1. Clonez le dépôt GitHub :
```git clone https://github.com/soufianeljadi/resto ```

2. Accédez au répertoire du projet :
```cd resto```

3. Installez les dépendances PHP via Composer :
```composer install```

4. Copiez le fichier d'environnement :
```cp .env.example .env```

5. Générez la clé d'application :
```php artisan key:generate```

6. Configurez votre base de données dans le fichier `.env`.

7. Exécutez les migrations et les seeders :
```php artisan migrate --seed```

8. Démarrez le serveur de développement :
```php artisan serve```

9. Accédez au site web dans votre navigateur à l'adresse `http://localhost:8000`.



