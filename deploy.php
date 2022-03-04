<?php
namespace Deployer;

// Projet Symfony, on prend la bonne recette !
require 'recipe/symfony.php';

// Config
// On définit notre repository, pour que Deployer puisse cloner
set('repository', 'git@github.com:Julianomatt77/symfony-tpblanc-annuaire.git');

// On ajoute des fichiers partagés d'une release à l'autre
add('shared_files', []);
// On ajoute des dossiers partagés d'une release à l'autre
add('shared_dirs', [
    'public/uploads',
]);
// On met à jour les droits sur ces dossiers pour que le serveur puisse y écrire
add('writable_dirs', [
    'public/',
]);

// On définit combien de releases on veut garder par défaut
set('keep_releases', 5);

set('ssh_multiplexing', false);

// On bloque l'envoie de stats anonymes
set('allow_anonymous_stats', false);

// On donne le nom de l'utilisateur lié au serveur web (nginx / Apache)
set('http_user', 'www-data');

// Je préfère passer par la commande chmod pour mettre à jour les droits sur les dossiers
set('writable_mode', 'chmod');

// La commande chmod s'appelle avec sudo par défaut sur mes serveurs
set('writable_use_sudo', true);

// On va donner une configuration spécifique pour chaque hôte
host('51.178.42.85')
    // Ici, on ne veut garder que 2 releases sur ce serveur
    ->set('keep_releases', 2)
    // On choisit quelle branche va être déployée
    ->set('branch', 'main')
    // On utilise notre clé SSH locale pour déployer ET manipuler Git sur le serveur
    ->setForwardAgent(true)
    // Le nom de l'utilisateur sur le serveur qui va faire le déploiement (ici, on fera donc un ssh debian@51.178.42.85)
    ->set('remote_user', 'debian')
    // Le chemin où vont être nos fichiers sur le serveur
    ->set('deploy_path', '/var/www/martin');

// Tasks

// Ici, une tâche personnalisée, qui va nous servir si on a besoin de build avec npm
task('build', function () {
    cd('{{release_path}}');
    run('npm run build');
});

// À dé-commenter si vous avez besoin de lancer le build sur le serveur
// after('deploy:vendors', 'build');

// Si le déploiement échoue, on débloque les déploiements sur le serveur
after('deploy:failed', 'deploy:unlock');
