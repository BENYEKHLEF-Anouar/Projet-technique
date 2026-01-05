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
### Memo Notepad (Notes,Categories)
**Réalisé par :** BENYEKHLEF Anouar
**Encadré par :** M. ESSARRAJ Fouad



---

## Travail à faire

### Développer l'Application Memo Notepad
*   **Partie Publique:** Interface for visitors to view notes. Features: Title search, Category filter, Pagination (10 items/page).
*   **Partie Admin:** Secure dashboard for CRUD operations. Features: Modals for add/edit, AJAX for asynchronous updates.

---

## Contexte

*   **Processus 2TUP:** Project follows the 2TUP (Y Development Process) methodology, separating Functional, Technical, and Realization branches.
*   **Solidification des Compétences:** Focus on reinforcing Laravel 12 skills without AI tools, building on previous Solicode experience.

---

## Besoin - Analyse Technique

### Stack
#### Front-End
- **Blade:** Templates réutilisables (components, layouts).
- **Tailwind CSS:** Développement rapide, responsive.
- **Preline UI:** Composants intégrés.
- **Lucide:** Icones.

#### Back-End et Architecture
- **Framework:** Laravel 12.
- **Architecture N-Tiers:**
  - **Controller:** Requêtes HTTP.
  - **Service:** Logique métier.
  - **Model:** Base de données.

### Features
*   **CRUD:** Create, Read, Update, Delete.
*   **AJAX:** Dynamic interactions (e.g., Modals) without page reloads.

### Naming Conventions
- **Controllers:** `PascalCase` + `Controller` suffix (e.g., `NoteController`).
- **Models:** `PascalCase` singular (e.g., `Note`).
- **Tables:** `snake_case` plural (e.g., `notes`).
- **Variables/Methods:** `camelCase` (e.g., `getNotes`).

---

## Analyse Fonctionnelle

![w:600 Use Case Diagram](./images/notepad_usecase.png)
