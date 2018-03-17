<?php
namespace Deployer;

require 'recipe/common.php';

set('allow_anonymous_stats', false);
set('deploy_path', "{{deploy_path_custom}}");

// Servers
inventory('hosts.yml');

// Tasks
desc('Update code');
task('git:update-code', function(){

    // If option `tag` is not set and option `revision` is set
    if (input()->hasOption('revision')) {
        $revision = input()->getOption('revision');
    }

    cd('{{deploy_path}}');
    run('git fetch');

    if (!empty($revision)) {
        run("git checkout $revision");
    }
    else {
        run('git pull origin master');
    }
});

desc('Update theme');
task(
    'grav:update-theme', function() {
    cd('{{deploy_path}}/htdocs/user/themes/it4mage-theme');
    run('git pull origin master');
}
);

desc('Clear cache');
task(
    'grav:clear-cache', function() {
        cd('{{deploy_path}}/htdocs');
        run('php bin/grav clear-cache');
}
);


// Deploy
desc('Deploy');
task('deploy', [
    'git:update-code',
    'grav:update-theme',
    'grav:clear-cache',
    'success'
]);
