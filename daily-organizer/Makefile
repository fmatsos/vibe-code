# Makefile pour le projet Daily Organizer

# Désactive l'affichage des commandes exécutées
.SILENT:

# Empêche make de confondre les cibles avec des fichiers du même nom
.PHONY: help start stop restart build sh-php sh-node composer-install composer-update npm-install debug-on debug-off test lint

# Commande par défaut, affiche l'aide
help:
	@echo "Commandes disponibles :"
	@echo "  start          : Démarre les conteneurs Docker en arrière-plan."
	@echo "  stop           : Arrête et supprime les conteneurs Docker."
	@echo "  restart        : Redémarre les services."
	@echo "  build          : Force la reconstruction des images Docker."
	@echo "  sh-php         : Ouvre un shell bash dans le conteneur PHP."
	@echo "  sh-node        : Ouvre un shell bash dans le conteneur Node.js."
	@echo "  composer-install: Installe les dépendances PHP via Composer."
	@echo "  composer-update : Met à jour les dépendances PHP via Composer."
	@echo "  npm-install    : Installe les dépendances Node.js via npm."
	@echo "  debug-on       : Active Xdebug et redémarre le conteneur PHP."
	@echo "  debug-off      : Désactive Xdebug et redémarre le conteneur PHP."
	@echo "  test           : (Placeholder) Lance la suite de tests."
	@echo "  lint           : (Placeholder) Lance les linters de code."


# ==============================================================================
# GESTION DE L'ENVIRONNEMENT DOCKER
# ==============================================================================

start:
	@echo "🚀 Démarrage des conteneurs..."
	docker compose up -d --build

stop:
	@echo "🛑 Arrêt des conteneurs..."
	docker compose down

restart: stop start

build:
	@echo "🛠️ Reconstruction des images..."
	docker compose build --no-cache


# ==============================================================================
# ACCÈS AUX CONTENEURS
# ==============================================================================

sh-php:
	@echo "Connexion au conteneur PHP..."
	docker compose exec php bash

sh-node:
	@echo "Connexion au conteneur Node.js..."
	docker compose exec node bash


# ==============================================================================
# GESTION DES DÉPENDANCES
# ==============================================================================

composer-install:
	@echo "Installation des dépendances Composer..."
	docker compose exec php composer install

composer-update:
	@echo "Mise à jour des dépendances Composer..."
	docker compose exec php composer update

npm-install:
	@echo "Installation des dépendances NPM..."
	docker compose exec node npm install


# ==============================================================================
# CONTRÔLE DE XDEBUG
# ==============================================================================

debug-on:
	@echo "✅ Activation de Xdebug et redémarrage du service PHP..."
	XDEBUG_MODE=debug docker compose up -d --build php

debug-off:
	@echo "❌ Désactivation de Xdebug et redémarrage du service PHP..."
	XDEBUG_MODE=off docker compose up -d --build php


# ==============================================================================
# QUALITÉ ET TESTS (à définir plus tard)
# ==============================================================================

test:
	@echo "Lancement des tests (PHPUnit)..."
	# docker compose exec php ./vendor/bin/phpunit

lint:
	@echo "Analyse du code (PHPStan & ECS)..."
	# docker compose exec php ./vendor/bin/phpstan analyse
	# docker compose exec php ./vendor/bin/ecs check
