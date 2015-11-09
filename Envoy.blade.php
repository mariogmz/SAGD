@servers(['stage' => 'deploy@192.168.100.6'])

@macro('deploy', ['on' => 'stage'])
    change-dir
    git-update

    @if ($reset)
        artisan-clean
        artisan-seed
    @endif

    @if ($migrate)
        artisan-migrate
    @endif

    clear-cache
    artisan-optimize
    artisan-queues-restart
    update-frontend
@endmacro

@task('change-dir')
    cd /var/www/sagd
@endtask

@task('git-update')
    git checkout develop
    git pull origin develop
    git branch -D stage
    git checkout -b stage
@endtask

@task('artisan-clean')
    php artisan db:clean --force
@endtask

@task('artisan-seed')
    php artisan db:seed
@endtask

@task('artisan-migrate')
    php artisan migrate
@endtask

@task('clear-cache')
    curl http://opcache.stache:8082/\?reset\=1
@endtask

@task('artisan-optimize')
    php artisan optimize
@endtask

@task('artisan-queues-restart')
    php artisan queue:restart
@endtask

@task('update-frontend')
    cd app-angular
    nvm use 0.12
    grunt stage
    bash ~/.gzipper.sh
@endtask
