# Fonctionnalités de l'Application d'Organisation Personnelle

Ce document détaille les fonctionnalités prévues pour l'application, des fonctionnalités de base (MVP) aux améliorations possibles grâce à l'intelligence artificielle.

## Fonctionnalités de Base (MVP - Minimum Viable Product)

L'objectif est de construire une base solide et utilisable.

### 1. Gestion des Utilisateurs
- [ ] Inscription sécurisée (email/mot de passe).
- [ ] Connexion / Déconnexion.
- [ ] Espace personnel pour chaque utilisateur.
- [ ] Réinitialisation du mot de passe par email.

### 2. Gestion des Tâches
- [ ] Créer, voir, modifier, supprimer une tâche.
- [ ] Attributs : titre, description, date d'échéance, statut (à faire, en cours, terminé).
- [ ] Lister toutes les tâches avec des filtres (par date, par statut).

### 3. Gestion des Rendez-vous
- [ ] Créer, voir, modifier, supprimer un rendez-vous.
- [ ] Attributs : titre, lieu, date et heure de début, date et heure de fin.
- [ ] Vue calendrier (simple au début).

### 4. Gestion des Listes de Courses
- [ ] Créer, voir, modifier, supprimer une liste de courses (ex: "Supermarché", "Bricolage").
- [ ] Ajouter/supprimer des articles à une liste.
- [ ] Marquer un article comme acheté (cocher/décocher).

### 5. Notifications et Rappels
- [ ] Recevoir un rappel avant la date d'échéance d'une tâche.
- [ ] Recevoir un rappel avant un rendez-vous.

## Améliorations avec l'IA (via Symfony AI)

Ces fonctionnalités seront ajoutées par-dessus le socle de base pour rendre l'application plus intelligente et proactive.

### 1. Création par Langage Naturel
- **Objectif :** Permettre à l'utilisateur de créer des entrées rapidement.
- **Exemple :** L'utilisateur tape "Rappelle-moi d'appeler le dentiste demain à 14h" et l'IA crée automatiquement un rendez-vous avec le bon titre, la bonne date et la bonne heure.

### 2. Suggestions Intelligentes
- **Objectif :** Anticiper les besoins de l'utilisateur.
- **Exemple pour les courses :** Suggérer d'ajouter "lait" ou "pain" à la liste de courses si ce sont des achats fréquents non présents sur la liste de la semaine.
- **Exemple pour les tâches :** Proposer des tâches récurrentes non planifiées.

### 3. Catégorisation Automatique
- **Objectif :** Organiser le contenu sans effort pour l'utilisateur.
- **Exemple :** Une tâche contenant "réunion projet" est automatiquement taguée comme "Travail". Un rdv chez le "médecin" est tagué "Santé".

### 4. Priorisation des Tâches
- **Objectif :** Aider l'utilisateur à décider quoi faire.
- **Exemple :** Une vue "Focus du jour" qui met en avant 3 à 5 tâches importantes basées sur l'urgence (date d'échéance), le type de tâche et les habitudes de l'utilisateur.
