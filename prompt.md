### Les technologies à utiliser

1.  **Base de données:** MySQL.
2.  **Framework:** Laravel 12.
3.  **Architecture N-Tiers:**
    - **Controller:** Requêtes HTTP uniquement.
    - **Service:** Logique métier.
    - **Model:** Base de données.
4.  **Architecture:** MVC.
5.  **Blade:** Templates réutilisables (components, layouts).
6.  **AJAX:** Interactions dynamiques (ex: Modales) sans rechargement de page.

---

7.  **Téléchargement d'images:** Possibilité de télécharger et de joindre des images aux notes.
8.  **Support Multi-langue:** Support des langues française et anglaise (fr, en).
9.  **Vite:** Outil de build rapide.
10. **Preline UI:** Librairie UI.
11. **Lucide:** Librairie d'icônes.
12. **Tailwind CSS:** Développement rapide, responsive.
13. **Conventions:**
    - Utiliser l'anglais pour tout le code (variables, fonctions, classes, etc.).
    - Respecter les conventions de nommage PHP (PSR).
14. **Logique Métier:**
    - Toute la logique métier doit être dans les **Services**.
    - Les **Controllers** ne doivent servir qu'à recevoir les requêtes et retourner les réponses.