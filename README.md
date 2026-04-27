# gestion-licence
Application web Symfony permettant de planifier, gérer et consulter les interventions pédagogiques (modules, enseignants, années scolaires) d’une promotion de licence.

Elle permet notamment de : 
- structurer l’ensemble des enseignements sous forme de blocs, modules et périodes de cours ; 
- gérer les intervenants et leurs disponibilités ; 
- planifier les différentes interventions (cours, ateliers, projets, conférences, évaluations, etc.) sur l’année ; 
- offrir une vision claire, cohérente et mise à jour du planning de la seule promotion concernée ; 
- éviter les conflits d’horaires ou les chevauchements d’interventions ; 
- remplacer ou compléter les outils traditionnels (tableurs, échanges e-mail) par une solution centralisée, fiable et plus efficace.

# Les fonctionnalités 
- calendrier : consulter les interventions de la période souhaitée
- CRUD : intervention, corps enseignant,modules, bloc enseignement, années scolaire et type d'intervention 
- module : visualisation d'une arborescence des différents modules par bloc d'enseignement
  
# Contexte
Etant en 2èeme année de BTS SIO option SLAM, nous avons effectue un projet en duo pour mettre en pratique notre apprentissage de symfony.
durée : Du 5 janvier 2026 au 28 février 2026

# Méthode
- utilisation de backlog
- méthode agile
- sprint 1 semaine avec compte rendu
- roadmap

# Technologies
- Symfony
- Twig
- Tailwing
- JavaScript
- PHP

# Installation de projet et Démarage

Requis : 
composer
Dans php.ini : décommentez ces lignes 

extension=fileinfo
extension=gd
extension=mbstring

1) Téléchargez le projet
2) Dans le CMD:
   - composer update
   - php bin/console doctrine:schema:drop --force
   - doctrine : fixture load
3) symfony serve
4) mettre les logs de admin@admin.fr et mot de passe : admin

<img width="1075" height="585" alt="image" src="https://github.com/user-attachments/assets/9558e1d5-e053-4932-a335-cbd401425990" />


# Documentation supplémentaires
Nous avons un Guide utilisateur,un dossier spécification technique et un autre dossier fonctionelle.

[guide_utilisateur_gestion_licence.pdf](https://github.com/user-attachments/files/27116112/guide_utilisateur_gestion_licence.pdf)
[dossier_specifications_techniques_gestion_licence.pdf](https://github.com/user-attachments/files/27116117/dossier_specifications_techniques_gestion_licence.pdf)
[dossier_specification_fonctionnelles_gestion_licence.pdf](https://github.com/user-attachments/files/27116123/dossier_specification_fonctionnelles_gestion_licence.pdf)

