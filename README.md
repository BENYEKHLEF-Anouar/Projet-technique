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
### Memo Notepad (Notes, Categories) <br>
**Réalisé par :** BENYEKHLEF Anouar <br>
**Encadré par :** M. ESSARRAJ Fouad

---

## **Plan**

1.  **Méthode Waterfall**
2.  **Exigences :** Travail à faire
3.  **Contexte :** Projet de Fin de Formation
4.  **Analyse Technique**
5.  **Analyse :** Analyse Fonctionnelle
6.  **Conception**
7.  **Versions (v1 - v8)**
8.  **Conclusion**

---

## Méthode Waterfall (En cascade)

![w:900 Waterfall](./images/waterfall.png)



---

## Exigences: Travail à faire

### Développer l'Application Memo Notepad
*   **Partie Publique:** Interface permettant aux visiteurs de consulter les notes. Fonctionnalités : Recherche par titre, filtre par catégorie, pagination (10 éléments/page).
*   **Partie Admin:** Tableau de bord sécurisé pour les opérations CRUD. Fonctionnalités : Modales pour ajout/édition, AJAX pour les mises à jour asynchrones.

---

## Contexte: Projet de Fin de Formation

*   **Projet de Fin de Formation:** Travail sur le projet de fin de formation, commençant par la branche technique.

*   **Processus 2TUP:** Le projet suit la méthodologie 2TUP (Processus de développement en Y), séparant les branches Fonctionnelle, Technique et Réalisation.
  
![w:600 2TUP](./images/2tup-2.png)


*   **Solidification des Compétences:** Concentration sur le renforcement des compétences Laravel 12 sans outils d'IA, en s'appuyant sur l'expérience précédente à Solicode.

---

## Analyse Technique


### Les technologies à utiliser

1.  **Base de données:** MySQL.
2.  **Framework:** Laravel 12.
3.  **Architecture N-Tiers:**
    - **Controller:** Requêtes HTTP.
    - **Service:** Logique métier.
    - **Model:** Base de données.
4.  **Architecture:** MVC.
5.  **Blade:** Templates réutilisables (components, layouts).
6.  **AJAX:** Interactions dynamiques (ex: Modales) sans rechargement de page.  
7. **Alpine.js:** Librairie JavaScript pour les interactions dynamiques.
8. **Spatie:** Librairie pour la gestion des permissions et rôles.

---

9.  **Téléchargement d'images:** Possibilité de télécharger et de joindre des images aux notes.
10. **Support Multi-langue:** Support des langues française et anglaise (fr, en).
11. **Vite:** Outil de build rapide.
12. **Preline UI:** Librairie UI.
13. **Lucide:** Librairie d'icônes.
14.  **Tailwind CSS:** Développement rapide, responsive.

---

## Analyse: Analyse Fonctionnelle

![w:1000 Use Case Diagram](./images/notepad_usecase45.png)

---

## Conception

![w:950 Class Diagram](./images/diagram_class.png)


---

## Versions

| Version | Description | Branche |
| :--- | :--- | :--- |
| **v1** | Public Side (Consultation, Recherche, Filtre) | `public` |
| **v2** | Admin Side (CRUD, Modales) | `admin` |
| **v3** | Authentification / Authorization (Gates) | `gates` |
| **v4** | SPA / AJAX | `spa-ajax` |
| **v5** | SPA / Alpine.js | `spa-alpine` |
| **v6** | Spatie / Authorization | `spatie` |
| **v7** | API | `api` |
| **v8** | Mobile App | `mobile` |

---

## **v1** : Public Side

* **Live Coding :** Création du portfolio personnel

---

## **v2** : Admin Side

* **Live Coding :** Gestion des articles (CRUD)

---

## **v3** : Authentification / Authorization

* **Live Coding :** 

---

## **v4** : SPA / AJAX

* **Live Coding :** 
  - Bouton “Ajouter” via modale
  - Barre de recherche dynamique

---

## **v5** : SPA / Alpine.js

* **Live Coding :** 

---

## **v6** : Spatie / Authorization

* **Live Coding :**

---

## **v7** : API

* **Live Coding :** 

---

## **v8** : Mobile App

* **Live Coding :** 
---

## **Conclusion**






