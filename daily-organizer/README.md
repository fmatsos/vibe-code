# Projet : Organisateur Quotidien avec IA

## 1. Objectif

Ce projet vise à développer une application web d'organisation personnelle. L'application aidera les utilisateurs à gérer leurs tâches quotidiennes, leurs rendez-vous et leurs listes de courses.

L'objectif est de créer une expérience utilisateur fluide et intuitive, enrichie par des fonctionnalités d'intelligence artificielle pour simplifier et automatiser la planification.

Pour une liste détaillée des fonctionnalités, veuillez consulter le fichier [FEATURES.md](./FEATURES.md).

## 2. Stack Technique

### Langages et Frameworks
- **Backend :** PHP / [Symfony](https://symfony.com/)
- **Frontend :** JavaScript / [Stimulus](https://stimulus.hotwired.dev/)
- **Styling :** [TailwindCSS](https://tailwindcss.com/) avec le plugin [Daisy UI](https://daisyui.com/)
- **Base de données / ORM :** [Doctrine](https://www.doctrine-project.org/)
- **Moteur de templates :** [Twig](https://twig.symfony.com/)
- **Intelligence Artificielle :** Composant [Symfony AI](https://symfony.com/ai)

### Outils de Qualité et Tests (QA)
- **Analyse Statique PHP :** [PHPStan](https://phpstan.org/)
- **Standard de Code PHP :** [ECS (Easy Coding Standard)](https://github.com/symplify/easy-coding-standard)
- **Linter de Templates :** [Twig Linter](https://symfony.com/doc/current/templates.html#linting-templates)
- **Tests PHP :** [PHPUnit](https://phpunit.de/) (tests unitaires/intégration) & [Behat](https://behat.org/) (tests fonctionnels/BDD)
- **Tests JavaScript :** [Jest](https://jestjs.io/) (recommandé pour les tests de contrôleurs Stimulus)
