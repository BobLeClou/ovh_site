# Livre d'Or - Application PHP

Ce projet est une application web développée en PHP avec une base de données SQLite. Il permet aux utilisateurs de laisser des messages dans un livre d’or, de s’inscrire, de se connecter, et offre également un panneau d'administration pour la gestion des utilisateurs.

---

## Fonctionnalités principales

### 🔐 Authentification

- Inscription avec pseudo et mot de passe (hashé avec `password_hash`).
- Connexion sécurisée avec gestion de session.
- Rôles utilisateurs : `user`, `moderator`, `administrator`.

### 📖 Livre d'Or

- Affichage des messages postés par les utilisateurs.
- Formulaire pour ajouter un message (nom + message, 250 caractères max).
- Suppression de messages via une interface (si connecté avec les bons droits).

### 🛠️ Panneau d'administration (Dashboard)

Accessible uniquement aux utilisateurs ayant le rôle `moderator` ou `administrator`.

- Liste de tous les utilisateurs inscrits.
- **Supprimer un utilisateur** :
  - Les modérateurs ne peuvent pas supprimer les modérateurs/administrateurs.
  - Les administrateurs ne peuvent pas supprimer d'autres administrateurs.
- **Changer le rôle d’un utilisateur** (accessible uniquement aux administrateurs) :
  - Un administrateur peut changer le rôle d’un utilisateur en `user` ou `moderator`.

### 🧹 Outils de maintenance

- Depuis le dashboard, un bouton permet de **réinitialiser la base de données** :
  - Supprime les fichiers `.db`.
  - Exécute de nouveau le script `init_db.php` pour recréer la base et injecter des données par défaut.

### 🧭 Navigation

- Barre de navigation (navbar) dynamique affichant :
  - Les liens vers les pages principales.
  - Le pseudo de l’utilisateur connecté.
  - Un bouton de déconnexion.
  - Un lien vers le dashboard si l’utilisateur est modérateur ou administrateur.
- Pied de page (footer) commun à toutes les pages.

---

## Structure du projet

```
/www/
│
├── css/
│   └── style-global.css         # Style commun à toutes les pages
│
├── templates/
│   ├── navbar.php               # Barre de navigation réutilisable
│   └── footer.php               # Pied de page réutilisable
│
├── auth/
│   ├── login.php
│   ├── register.php
│   ├── logout.php
│   └── auth_utils.php
│
├── goldenbook/
│   ├── goldenbook.php
│   ├── submit.php
│   ├── delete.php
│   └── message.php
│
├── dashboard/
│   └── dashboard.php
│
├── database/
│   ├── init_db.php
│   └── *.db
│
├── index.php
└── README.md
```

---

## Configuration requise

- Serveur web avec PHP 7.4+
- SQLite activé
- Un dossier `www/` correctement configuré avec droits en écriture pour les fichiers `.db`

---

## Lancement du projet

1. Cloner ou déposer le projet dans le dossier racine du serveur (`/www/`).
2. S’assurer que les fichiers `.db` peuvent être créés.
3. Lancer le projet via l’URL locale ou distante.
4. Les comptes suivants sont créés par défaut :
   - **admin** / `bonjour` (rôle : administrator)
   - **user** / `bonjour` (rôle : moderator)

---

## Auteurs

Projet réalisé dans le cadre d’un test de développement web PHP.