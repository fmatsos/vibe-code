# Générateur de Circuits de Train en Bois

Ce projet est une application web conçue pour générer des plans de circuits de train en bois (type PlayLive de Lidl) à partir d'une collection de pièces définie par l'utilisateur. C'est un outil créatif pour les parents et les enfants qui souhaitent construire des circuits complexes avec les pièces qu'ils ont à leur disposition.

## Objectif

L'objectif principal est de fournir un générateur de plans intelligents qui peut :
1.  Gérer la collection de pièces de l'utilisateur.
2.  Générer de manière aléatoire des circuits fermés (en boucle).
3.  Afficher visuellement le résultat.
4.  Permettre d'exporter et de partager les plans.

## Stack Technique

Le projet est développé en JavaScript, avec la répartition suivante :

-   **Backend** : [Node.js](https://nodejs.org/) avec le framework [Express.js](https://expressjs.com/) pour l'API REST.
-   **Frontend** : JavaScript natif (vanilla JS) pour la logique côté client.
-   **Style** : [Tailwind CSS](https://tailwindcss.com/) pour le design utilitaire, avec la bibliothèque de composants [Daisy UI](https://daisyui.com/) pour une construction rapide de l'interface.

## Fonctionnalités Clés

-   **Gestion de Collection** : L'utilisateur peut définir et sauvegarder sa collection de rails.
-   **Génération de Circuits** : Un algorithme côté serveur génère des plans de circuits fermés en utilisant les pièces disponibles.
-   **Export PDF** : Les plans peuvent être exportés en PDF, incluant le schéma, la liste des pièces et un "hash" unique.
-   **Partage de Plans** : Grâce au hash, un plan peut être facilement retrouvé et ré-affiché par l'application, permettant le partage simple entre utilisateurs.

## Démarrage Rapide (Instructions pour le futur développeur)

1.  **Installer les dépendances** :
    ```bash
    npm install
    ```

2.  **Compiler le CSS** :
    Un script `build:css` (à définir dans `package.json`) permettra de compiler les fichiers de style.
    ```bash
    npm run build:css
    ```

3.  **Lancer le serveur** :
    ```bash
    node src/server.js
    ```

L'application sera ensuite accessible à l'adresse `http://localhost:3000` (ou le port défini dans `server.js`).

4.  **Vérifier la qualité du code** :
    ```bash
    npm run lint
    npm test
    ```

## Documents de Projet

Pour plus de détails sur le projet, veuillez consulter les documents suivants :

-   `REQUIREMENTS.md` : Les exigences fonctionnelles et non fonctionnelles.
-   `PLAN.md` : Le plan de développement stratégique.
-   `TASKS.md` : La liste détaillée des tâches de développement.
