# ecommerce_back
Création d'un back pour gérer les différentes requêtes pour le site ecommerce


# Technologies et Frameworks Utilisés

* Langage de programmation : PHP
* Framework principal : Symfony
* Gestion de base de données : Doctrine
* Authentification : JWT (JSON Web Tokens)
* Autres librairies importantes : API Platform, Faker pour les données de test
* Tests : PhpUnit

# Démarrer le projet 

    1. Exécutez `composer install` pour installer les dépendances PHP.
    2. Créez la base de données avec `symfony console doctrine:database:create`.
    3. Lancez les migrations avec `symfony console doctrine:migrations:migrate`.
    4. Chargez les données de test avec `symfony console doctrine:fixtures:load`.
    5. Installez les dépendances npm avec `npm install` ou `yarn install`.
    6. Construisez les assets avec `npm run dev` ou `yarn dev`.
    7. Démarrez le serveur Symfony avec `symfony server:start`.
