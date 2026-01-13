### Les technologies à utiliser

1.  **Base de données:** MySQL.
2.  **Framework:** Laravel 12.
3.  **Architecture:**
    - **Pattern:** MVC avec couche Service (N-Tiers).
    - **Models:** Représentation des données (`Note`, `Category`, `User`).
    - **Services:** Logique métier centralisée (`NoteService`, `CategoryService`, `BaseService`).
    - **Controllers:** Gestion des requêtes/réponses uniquement, pas de logique métier.
4.  **Frontend:**
    - **Tailwind CSS:** v4.0.0 (via Vite).
    - **Preline UI:** Composants UI.
    - **Lucide:** Icônes.
    - **Blade:** Templates et composants.
5.  **Interactivité:**
    - **AJAX:** Requêtes asynchrones pour les interactions dynamiques (ex: ouverture/fermeture modales, soumission de formulaires).

---

### Fonctionnalités & Spécifications

6.  **Gestion des Médias:** Téléchargement et stockage d'images pour les notes.
7.  **Internationalisation (i18n):** Support FR/EN (`lang/fr.json`, `lang/en.json`).
8.  **Tests & Qualité:**
    - **Tests Automatisés:** `php artisan test`.
    - **Données de Test:** Seeders complets (`UserSeeder`, `CategorySeeder`, `NoteSeeder`).
    - **Stratégie de Test:** Exploiter les données seedées pour valider la logique métier (`NoteService`, `CategoryService`) sans créer de données ad-hoc.
9.  **Conventions de Code:**
    - **Langue:** Anglais pour tout le code (classes, variables, commentaires).
    - **Standards:** Respect des PSR PHP.

------------------------

