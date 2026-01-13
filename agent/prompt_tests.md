### Stratégie de Tests Automatisés

**Commande:**
*   Exécuter les tests avec : `php artisan test`

**Principes Directeurs:**
1.  **Exploitation des Seeders :** Les tests doivent utiliser les données existantes chargées par les seeders (`UserSeeder`, `CategorySeeder`, `NoteSeeder`) plutôt que de créer des données fictives ("factories") à chaque test.
2.  **Cible :** Valider la logique métier encapsulée dans les services (`NoteService`, `CategoryService`).
3.  **Localisation :**
    *   Tests Unitaires : `tests/Unit`

**Objectif :**
Garantir que la logique métier fonctionne correctement sur le jeu de données "réel" de l'application.
