# Plan de Développement : Générateur de Circuits de Train

Ce document présente le plan de développement stratégique pour la création de l'application. Le projet est décomposé en plusieurs phases logiques pour une mise en œuvre structurée.

## Phase 1 : Initialisation et Fondations

1.  **Mise en Place de l'Environnement de Développement**
    -   Initialiser le projet Node.js (`package.json`).
    -   Installer les dépendances serveur (`express`) et frontend (`tailwindcss` v4, `daisyui`).
    -   Mettre en place la structure de dossiers (`src`, `public`).
    -   Configurer le processus de build pour Tailwind CSS via son CLI natif (sans PostCSS).

2.  **Définition des Structures de Données Clés**
    -   Rechercher et lister les différents types de pièces de rails en bois "PlayLive".
    -   Créer un module JavaScript (`src/pieces.js`) pour définir les propriétés de chaque pièce (géométrie, points de connexion, etc.). Cette structure sera la base de l'algorithme de génération.

## Phase 2 : Développement du Backend (API)

1.  **Création du Serveur Web**
    -   Mettre en place un serveur Express de base pour servir les fichiers statiques (HTML, CSS, JS).

2.  **API pour la Gestion de Collection**
    -   Développer les points de terminaison (endpoints) de l'API REST pour la gestion de la collection de l'utilisateur (CRUD : Create, Read, Update, Delete).
    -   Implémenter la persistance des données de la collection (par exemple, dans un fichier `database.json`).

3.  **API pour la Génération de Circuits**
    -   Créer le point de terminaison qui recevra la requête de génération.
    -   Intégrer l'algorithme de génération de circuits dans ce point de terminaison.
    -   Implémenter la logique de sérialisation (création du "hash") et de désérialisation (reconstruction depuis le "hash").

## Phase 3 : Développement du Frontend (Interface Utilisateur)

1.  **Création de l'Interface Principale**
    -   Développer la page `index.html` avec les composants DaisyUI.
    -   Structurer l'interface pour inclure les différentes sections : gestionnaire de collection, panneau de génération, visualiseur de circuit.

2.  **Logique d'Interaction**
    -   Développer le script `public/app.js` pour communiquer avec l'API backend.
    -   Implémenter l'affichage et la mise à jour dynamique de la collection.
    -   Gérer les actions de l'utilisateur (clic sur "Générer", saisie d'un hash).

3.  **Visualisation des Circuits**
    -   Développer un module de rendu qui prend la structure de données d'un circuit et la dessine dans un élément SVG sur la page.

## Phase 4 : Fonctionnalités Avancées

1.  **Implémentation de l'Algorithme de Génération**
    -   Développer l'algorithme de "backtracking" qui connecte les pièces pour former une boucle fermée, en respectant les contraintes (collection de l'utilisateur, nombre max de pièces).

2.  **Export en PDF**
    -   Intégrer une bibliothèque de génération de PDF côté serveur.
    -   Créer un service et un point de terminaison d'API dédiés qui génèrent un PDF contenant le plan (image ou SVG), la liste des pièces et le hash.

## Phase 5 : Finalisation et Tests

1.  **Tests d'Intégration**
    -   Tester le flux complet de l'application : de la gestion de la collection à l'export PDF et à la récupération par hash.
    -   S'assurer que tous les cas limites sont gérés correctement (par exemple, impossibilité de créer un circuit fermé).

2.  **Préparation pour le Déploiement**
    -   Nettoyer le code.
    -   Documenter la configuration et la procédure de lancement du projet dans le `README.md`.
