Création d'un site pour mon mariage avec PHP. Découvert du MVC en utilisant composer et twig.

Projet incomplet

## Suivi des taches à faire

- [x] Concevoir la page RSVP/contact avec formulaire

- [x] Intégrer une page FAQ dynamique

- [x] Installer et configurer la base de données

- [x] Écrire les modèles pour l’accès aux données

- [x] Gérer la soumission des formulaires et validation côté serveur

- [ ] Ajouter la gestion des sessions (connexion admin par exemple)

- [x] Créer une interface d’administration simple

- [ ] Intégrer les styles CSS et framework (Bootstrap)

- [ ] Ajouter les scripts JavaScript nécessaires

- [ ] Optimiser le responsive design pour mobile/tablette

- [ ] Intégrer les images et médias (photos, icônes)

- [ ] Ajouter la localisation Google Maps pour le lieu

- [ ] Mettre en place la sécurité basique (CSRF, validation)

- [ ] Tester le site sur plusieurs navigateurs

- [ ] Optimiser la performance (cache, minification)

- [ ] Préparer le déploiement sur serveur distant

- [ ] Gérer les URLs propres et SEO basique

- [ ] Mettre en place un système de logs d’erreurs

- [ ] Sauvegarder et versionner le code (git)

- [ ] Ajouter un fichier README et documentation projet

- [ ] Préparer les tests unitaires simples

- [ ] Intégrer des plugins ou fonctionnalités annexes (ex : galerie photo)

- [ ] Penser à l’accessibilité (a11y)

- [ ] Effectuer une revue complète du code

- [ ] Mettre en place un système de backup de la base de données

- [ ] Rédiger un manuel utilisateur simplifié

- [ ] Installer un certificat SSL (HTTPS)

- [ ] Analyser et corriger les erreurs de logs serveur

- [ ] Prévoir une page “Coming soon” ou maintenance

- [ ] Planifier les futures mises à jour et évolutions


## Structure générale du projet

``` bash
/wedding
│
├── /public
│   ├── index.php            # Point d’entrée (front controller)
│   ├── /assets              # CSS, JS, images publiques
│   └── .htaccess            # Réécriture d’URL pour URLs propres
│
├── /src
│   ├── /Controller          # Contrôleurs (logique métier, gestion requêtes)
│   │    ├── HomeController.php
│   │    ├── RSVPController.php
│   │    └── ...
│   │
│   ├── /Model               # Modèles (accès et manipulation de la base)
│   │    ├── Personne.php
│   │    ├── RSVP.php
│   │    └── ...
│   │
│   ├── /Repository          # (Optionnel) accès DB spécialisé, séparation modèle-dao
│   │
│   ├── Router.php           # Gestion des routes (appel des contrôleurs)
│   └── Database.php         # Classe singleton PDO pour la connexion à la base
│
├── /templates               # Templates Twig (vues)
│   ├── base.twig            # Template de base avec header/footer/nav
│   ├── home.twig
│   ├── rsvp.twig
│   ├── faq.twig
│   └── ...
│
├── /includes                # (Optionnel) fichiers PHP partagés (header.php, footer.php, etc.)
│
├── /vendor                  # Librairies tierces (Twig, etc.), généré par Composer
│
├── composer.json            # Gestion des dépendances PHP
├── README.md                # Documentation projet
└── .gitignore               # Ignorer fichiers non pertinents pour git

```

## Schémas du fonctionnement 

```php
[Client Navigateur]
       |
       | HTTP Request (ex: /rsvp)
       v
[public/index.php]  <-- point d’entrée
       |
       | Appelle le Router
       v
[src/Router.php]
       |
       | Analyse l’URL → décide quel contrôleur et méthode appeler
       v
[src/Controller/RSVPController.php]  <-- exécution de la logique
       |
       | Utilise les modèles (ex: Personne.php) pour récupérer/mettre à jour la BDD
       | Prépare les données à afficher
       v
[templates/rsvp.twig]  <-- rendu HTML via Twig avec les données injectées
       |
       | Envoie la page générée au navigateur
       v
[Client Navigateur]  <-- Affiche la page

---

Détail passage données :  
Dans RSVPController.php :

```php
public function showForm()
{
    $personnes = $this->personneModel->findAll();  // récupère des données
    echo $this->twig->render('rsvp.twig', [
        'personnes' => $personnes,
        'title' => 'RSVP'
    ]);
}

```

