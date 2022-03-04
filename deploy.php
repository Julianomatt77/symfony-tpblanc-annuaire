<?php
namespace Deployer;

require 'recipe/symfony.php';

// Config

set('repository', 'https://github.com/Julianomatt77/symfony-tpblanc-annuaire.git');

add('shared_files', []);
add('shared_dirs', []);
add('writable_dirs', []);

// Hosts

host('51.178.42.85')
    ->set('remote_user', 'deployer')
    ->set('deploy_path', '~/symfony-tpblanc-annuaire');

// Tasks

task('build', function () {
    cd('{{release_path}}');
    run('npm run build');
});

after('deploy:failed', 'deploy:unlock');
