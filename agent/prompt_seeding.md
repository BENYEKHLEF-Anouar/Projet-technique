### Stratégie de Données et Seeding

**Sources de Données:**
*   Les données initiales sont stockées dans `database/data/` au format CSV :
    *   `users.csv`
    *   `categories.csv`
    *   `notes.csv`

**Seeders:**
*   Utiliser les seeders suivants pour peupler la base de données :
    *   `UserSeeder`: Charge `users.csv`.
    *   `CategorySeeder`: Charge `categories.csv`.
    *   `NoteSeeder`: Charge `notes.csv` et associe les catégories via la table pivot.

**Instruction:**
*   Utiliser ces données pour initialiser l'état de l'application lors du déploiement ou des tests.
