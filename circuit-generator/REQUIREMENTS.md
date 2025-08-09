# Exigences du Projet : Générateur de Circuits de Train

Ce document détaille les exigences fonctionnelles et non fonctionnelles pour l'application de génération de plans de circuits de train en bois.

## 1. Objectif Principal

L'application doit permettre à un utilisateur de générer des plans de circuits de train en bois (marque PlayLive de Lidl) à partir d'une collection de pièces qu'il possède.

## 2. Exigences Fonctionnelles

### 2.1. Gestion de la Collection de Pièces
-   **F1.1** : L'utilisateur doit pouvoir enregistrer les pièces qu'il possède dans une "collection".
-   **F1.2** : La liste des types de pièces disponibles (par exemple, "rail droit long", "virage", "aiguillage") doit être prédéfinie dans l'application.
-   **F1.3** : L'utilisateur doit pouvoir ajouter, modifier et supprimer le nombre de pièces pour chaque type dans sa collection.
-   **F1.4** : La collection de l'utilisateur doit être sauvegardée de manière permanente, afin qu'il la retrouve lors de ses prochaines visites.

### 2.2. Génération de Circuits
-   **F2.1** : L'utilisateur doit pouvoir lancer la génération d'un circuit en spécifiant un nombre **maximum** de pièces à utiliser.
-   **F2.2** : L'algorithme doit générer un circuit de manière **automatique et aléatoire**.
-   **F2.3** : Le circuit généré doit impérativement être un **circuit fermé** (une boucle).
-   **F2.4** : L'algorithme doit tenter de construire le plus grand circuit fermé possible sans dépasser le nombre maximum de pièces spécifié.
-   **F2.5** : Si le circuit final utilise moins de pièces que le maximum demandé, l'utilisateur doit en être notifié.

### 2.3. Visualisation
-   **F3.1** : Le plan du circuit généré doit être affiché visuellement à l'écran.
-   **F3.2** : La visualisation doit être claire et lisible, sous forme d'un plan vu de dessus.

### 2.4. Export en PDF
-   **F4.1** : L'utilisateur doit pouvoir exporter n'importe quel plan de circuit généré dans un fichier PDF.
-   **F4.2** : Le document PDF doit contenir :
    - Le plan visuel du circuit.
    - La liste des pièces exactes requises pour construire le circuit.
    - Un identifiant unique du circuit (hash).

### 2.5. Retrouver un Circuit par Hash
-   **F5.1** : L'application doit fournir un moyen de saisir un identifiant de circuit (hash).
-   **F5.2** : À partir de ce hash, l'application doit être capable de recalculer et de ré-afficher le plan de circuit exact correspondant.
-   **F5.3** : Ce mécanisme ne doit pas reposer sur une sauvegarde des circuits en base de données. Le hash est un "plan de construction" qui permet de regénérer le circuit de manière déterministe.

## 3. Exigences Non Fonctionnelles

-   **NF1.1 (Technologie)** : Le projet doit être développé en "full JS" :
    -   **Backend** : Node.js avec le framework Express.
    -   **Frontend** : JavaScript natif.
    -   **Style** : TailwindCSS avec la librairie de composants Daisy UI.
-   **NF1.2 (Persistance)** : Les données de la collection de l'utilisateur doivent être stockées côté serveur, par exemple dans un simple fichier JSON.
-   **NF1.3 (Rendu)** : Le rendu des circuits doit utiliser un format vectoriel (SVG) pour garantir une bonne qualité d'affichage et d'impression.
-   **NF1.4 (Portabilité)** : Le format PDF garantit que les plans peuvent être facilement sauvegardés, partagés et imprimés.
