# Projet : Organisateur Quotidien avec IA

## 1. Objectif

Ce projet vise à développer une application web d'organisation personnelle. L'application aidera les utilisateurs à gérer leurs tâches quotidiennes, leurs rendez-vous et leurs listes de courses.

L'objectif est de créer une expérience utilisateur fluide et intuitive, enrichie par des fonctionnalités d'intelligence artificielle pour simplifier et automatiser la planification.

Les données sont persistées avec Doctrine et l'authentification est gérée par Symfony Security.

Pour une liste détaillée des fonctionnalités, veuillez consulter le fichier [FEATURES.md](./FEATURES.md).

## 2. Stack Technique

### Langages et Frameworks
- **Backend :** PHP / [Symfony](https://symfony.com/)
- **Frontend :** JavaScript / [Stimulus](https://stimulus.hotwired.dev/)
- **Styling :** [TailwindCSS v4](https://tailwindcss.com/) (sans PostCSS) avec le plugin [Daisy UI](https://daisyui.com/)
- **Base de données / ORM :** [Doctrine](https://www.doctrine-project.org/)
- **Sécurité / Authentification :** [Symfony Security](https://symfony.com/doc/current/security.html)
- **Moteur de templates :** [Twig](https://twig.symfony.com/)
- **Intelligence Artificielle :** Composant [Symfony AI](https://symfony.com/ai)

### Outils de Qualité et Tests (QA)
- **Analyse Statique PHP :** [PHPStan](https://phpstan.org/)
- **Standard de Code PHP :** [ECS (Easy Coding Standard)](https://github.com/symplify/easy-coding-standard)
- **Linter de Templates :** [Twig Linter](https://symfony.com/doc/current/templates.html#linting-templates)
- **Tests PHP :** [PHPUnit](https://phpunit.de/) (tests unitaires/intégration) & [Behat](https://behat.org/) (tests fonctionnels/BDD)
- **Tests JavaScript :** [Jest](https://jestjs.io/) (recommandé pour les tests de contrôleurs Stimulus)

## 3. Installation et Démarrage

### Prérequis
- Docker & Docker Compose
- Node.js 20+ et npm
- [Composer](https://getcomposer.org/)

### Étapes de démarrage

```bash
docker compose up -d
docker compose exec php composer install
docker compose exec node npm install
```

### Vérifications de qualité

```bash
docker compose exec php composer qa
```


## 4. Architecture ADR

Le projet suit le modèle **Action-Domaine-Responder (ADR)**. Chaque fonctionnalité est découpée en trois responsabilités :

- **Action** : point d'entrée (contrôleurs HTTP ou commandes) situé dans `src/Action/`
- **Domaine** : logique métier et modèles dans `src/Domain/`
- **Responder** : formatage de la réponse dans `src/Responder/`

### Règles à respecter

- Une Action délègue à un service de Domaine unique.
- Aucun code métier dans les Actions ou Responders.
- Les Responders sont responsables de la présentation seulement.
- Toute nouvelle fonctionnalité doit respecter cette organisation de répertoires.
