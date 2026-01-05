---
marp: true
theme: default
_class: lead
paginate: true
backgroundColor: #f9f9f9ff
style: |
  section {
    font-size: 22px;
    color: #040404ff;
    line-height: 1.5;
    padding: 2em;
    
  }
  h1, h2, h3 {
    color: #38bdf8;
    font-weight: 700;
    margin-bottom: 0.6em;
  }
  h1 { font-size: 2.8em; }
  h2 { font-size: 2.2em; }
  h3 { font-size: 1.6em; color: #3d3d3dff; }
  p, li {
    font-size: 1.15em;
    margin-bottom: 0.6em;
  }
  ul, ol {
    margin-left: 1.4em;
    margin-bottom: 1.2em;
  }
  img {
    max-width: 100%;
    display: block;
    margin:  0em auto;
    border-radius: 8px;

  }
 

---



# **Présentation Projet-technique**
### Memo Notepad (Notes, Categories)
**Réalisé par :** BENYEKHLEF Anouar
**Encadré par :** M. ESSARRAJ Fouad



---

## Travail à faire

### Développer l'Application Memo Notepad
*   **Partie Publique:** Interface permettant aux visiteurs de consulter les notes. Fonctionnalités : Recherche par titre, filtre par catégorie, pagination (10 éléments/page).
*   **Partie Admin:** Tableau de bord sécurisé pour les opérations CRUD. Fonctionnalités : Modales pour ajout/édition, AJAX pour les mises à jour asynchrones.

---

## Contexte

*   **Projet de Fin de Formation:** Travail sur le projet de fin de formation, commençant par la branche technique.

*   **Processus 2TUP:** Le projet suit la méthodologie 2TUP (Processus de développement en Y), séparant les branches Fonctionnelle, Technique et Réalisation.
  
![w:600 2TUP](./images/2tup.png)


*   **Solidification des Compétences:** Concentration sur le renforcement des compétences Laravel 12 sans outils d'IA, en s'appuyant sur l'expérience précédente à Solicode.

---

## Besoin - Analyse Technique


### Les technologies à utiliser
#### Front-End
1. **Blade:** Templates réutilisables (components, layouts).
2. **Tailwind CSS:** Développement rapide, responsive.
3. **Preline UI:** Composants intégrés.
4. **Lucide:** Icones.

---

#### Back-End et Architecture
5. **Framework:** Laravel 12.
6. **Architecture N-Tiers:**
  - **Controller:** Requêtes HTTP.
  - **Service:** Logique métier.
  - **Model:** Base de données.

### Fonctionnalités
7. **AJAX:** Interactions dynamiques (ex: Modales) sans rechargement de page.
8. **Téléchargement d'images:** Possibilité de télécharger et de joindre des images aux notes.
9. **Support Multi-langue:** Support des langues française et anglaise (fr, en).



---

## Analyse Fonctionnelle

![w:600 Use Case Diagram](./images/notes_usecase.png)
