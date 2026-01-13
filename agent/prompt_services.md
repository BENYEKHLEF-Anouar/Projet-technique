### Stratégie des Services (Business Logic)

Ce document détaille la logique métier encapsulée dans les services de l'application.

#### 1. NoteService (`App\Services\NoteService`)
Hérite de `BaseService`. Gère toutes les opérations CRUD complexes pour les notes, y compris la gestion des images et des relations.

*   **`getNotes(?string $search, ?int $categoryId, ?int $perPage)`**
    *   Récupère les notes paginées.
    *   Filtrage par terme de recherche (`search`) sur : `name`, `content`, ou nom de l'utilisateur (`user.name`).
    *   Filtrage par catégorie (`categoryId`) via la relation `categories`.
    *   Eager loading: `user`, `categories`.

*   **`getNote(int $id)`**
    *   Récupère une note par ID avec ses relations (`user`, `categories`).
    *   Lève une exception si non trouvé (`findOrFail`).

*   **`createNote(array $data)`**
    *   Crée une note en base.
    *   Champs: `name`, `content`, `user_id` (Auth ou fallback), `image`.
    *   Synchronise les catégories (`category_ids`).

*   **`createNoteWithImage(array $data, $imageFile)`**
    *   Wrapper pour `createNote`.
    *   Si `$imageFile` est présent : upload le fichier dans `public/notes` et ajoute le chemin aux données.

*   **`updateNote(int $id, array $data)`**
    *   Met à jour une note existante.
    *   Met à jour `image` seulement si présent dans `$data`.
    *   Sync les catégories si `category_ids` est présent.

*   **`updateNoteWithImage(int $id, array $data, $imageFile)`**
    *   Wrapper pour `updateNote`.
    *   Si nouveau `$imageFile` : supprime l'ancienne image (si existe) et upload la nouvelle.

*   **`deleteNote(int $id)`**
    *   Détache les relations catégories (`detach`).
    *   Supprime la note de la base.

*   **`deleteNoteWithImage(int $id)`**
    *   Wrapper pour `deleteNote`.
    *   Supprime le fichier image associé du disque `public` avant de supprimer la note en base.

#### 2. CategoryService (`App\Services\CategoryService`)
Hérite de `BaseService`.

*   **`getAllCategories()`**
    *   Récupère toutes les catégories de la base (`Category::all()`).
