# Liste des Tâches de Développement

Voici la liste des tâches à réaliser pour mener à bien le projet de générateur de circuits de train.

## Phase 1 : Initialisation et Fondations

-   [x] Créer le fichier `package.json` avec `npm init -y`.
-   [x] Installer les dépendances : `express`, `tailwindcss` v4, `daisyui`.
-   [x] Créer la structure de dossiers : `src/`, `public/`, `public/css/`.
-   [x] Créer le fichier de configuration `tailwind.config.js`.
-   [x] Configurer le plugin DaisyUI dans `tailwind.config.js`.
-   [x] Créer le fichier `src/input.css` avec les directives `@tailwind`.
-   [x] Ajouter un script `build:css` dans `package.json` pour compiler le CSS.
-   [x] Créer le fichier `src/pieces.js` pour définir les structures de données des pièces.
-   [x] Remplir `src/pieces.js` avec les pièces de base (droites, virages, etc.) après recherche.

## Phase 2 : Développement du Backend (API)

-   [x] Créer le fichier `src/server.js`.
-   [x] Mettre en place un serveur Express de base dans `src/server.js`.
-   [x] Configurer le serveur pour servir les fichiers statiques du dossier `public`.
-   [x] Créer un fichier `database.json` pour le stockage de la collection.
-   [x] Créer des fonctions d'aide pour lire/écrire dans `database.json`.
-   [x] Implémenter la route `GET /api/collection` pour lire la collection.
-   [x] Implémenter la route `POST /api/collection` pour mettre à jour la collection.
-   [ ] Implémenter le squelette de la route `POST /api/generate`.
-   [ ] Implémenter le squelette de la route `GET /api/retrieve/:hash`.
-   [ ] Implémenter le squelette de la route `POST /api/export/pdf`.

## Phase 3 : Développement du Frontend (Interface Utilisateur)

-   [ ] Créer le fichier `public/index.html`.
-   [ ] Intégrer le fichier CSS compilé (`public/css/style.css`) dans `index.html`.
-   [ ] Créer le fichier `public/app.js` et le lier dans `index.html`.
-   [ ] Utiliser les composants DaisyUI pour construire la structure de la page (ex: `Card`, `Button`, `Input`).
-   [ ] Créer la section "Ma Collection" pour afficher les pièces de l'utilisateur.
-   [ ] Créer la section "Générer un circuit" avec un champ pour le nombre de pièces et un bouton.
-   [ ] Créer la section "Visualisation" qui contiendra le SVG du circuit.
-   [ ] Créer la section "Retrouver un circuit" avec un champ pour le hash et un bouton.
-   [ ] Dans `app.js`, implémenter la fonction pour fetcher et afficher la collection au chargement de la page.
-   [ ] Dans `app.js`, implémenter la logique pour envoyer la requête de génération à l'API.

## Phase 4 : Fonctionnalités Avancées

-   [ ] Concevoir et implémenter l'algorithme de génération de circuit fermé (logique de backtracking) dans le backend.
-   [ ] Intégrer l'algorithme dans la route `POST /api/generate`.
-   [ ] Développer la fonction de sérialisation pour créer un "hash" à partir d'un circuit.
-   [ ] Développer la fonction de désérialisation pour recréer un circuit à partir d'un "hash".
-   [ ] Implémenter la logique de la route `GET /api/retrieve/:hash` en utilisant la désérialisation.
-   [ ] Dans `app.js`, développer la fonction de rendu SVG qui dessine le circuit.
-   [ ] Installer une bibliothèque de génération de PDF (ex: `pdf-lib`) sur le serveur.
-   [ ] Implémenter la logique de la route `POST /api/export/pdf` pour créer le PDF.
-   [ ] S'assurer que le PDF contient bien l'image du circuit, la liste des pièces et le hash.

## Phase 5 : Finalisation et Tests

-   [ ] Tester manuellement la mise à jour de la collection.
-   [ ] Tester la génération de circuits avec différentes contraintes.
-   [ ] Vérifier que les circuits sont bien fermés.
-   [ ] Tester l'export PDF et la validité du fichier généré.
-   [ ] Tester la fonctionnalité de récupération par hash.
-   [ ] Rédiger les instructions de démarrage et d'utilisation dans le `README.md`.
-   [ ] Nettoyer le code et ajouter des commentaires si nécessaire.
