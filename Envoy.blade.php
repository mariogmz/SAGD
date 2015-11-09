@servers(['stage' => 'deploy@192.168.100.6'])

@setup
    $cleanAndSeedDb = isset($reset) ? true : false;
    $migrateDb = isset($migrate) ? true : false;
    $composerUpdate = isset($composer) ? true : false;
    $remoteBranch = isset($branch) ? $branch : 'develop';
@endsetup

@task('deploy', ['on' => 'stage'])
    cd /var/www/sagd

    echo "Actualizando código"
    git checkout develop
    git pull
    git branch -D stage
    git checkout -b stage origin/{{$remoteBranch}}

    echo "Actualizando dependencias"
    @if ($composerUpdate)
        rm composer.lock
        composer install
    @endif

    @if ($cleanAndSeedDb)
        echo "Limpiando base de datos y estableciendo seed inicial"
        php artisan db:clean mysql sagd_local --force
        php artisan db:seed
    @endif

    @if ($migrateDb)
        echo "Migrando base de datos"
        php artisan migrate
    @endif

    echo "Optimizando codigo"
    php artisan optimize

    echo "Reiniciando queues"
    php artisan queue:restart

    echo "Limpiando cache"
    curl http://opcache.stage:8082/\?reset\=1 > /dev/null

    echo "Recompilando front-end"
    cd app-angular
    npm install
    bower install
    grunt stage
    bash ../bin/gzipper.sh
@endtask
