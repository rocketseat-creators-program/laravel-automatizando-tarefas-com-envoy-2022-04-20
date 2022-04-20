@servers(['producao' => 'do', 'dev' => 'do-dev', 'hml' => 'do-hml'])

@story('deploy')
    atualizar
    limpar-cache
@endstory

@story('atualizar-dependencias')
    composer-update
    npm-update
@endstory

@task('listar', ['on'=> 'producao'])
    whoami
    pwd
    ls
@endtask

@task('limpar-cache', ['on' => ['producao', 'dev', 'hml'], 'parallel' => true])
    su - patrick
    cd /var/www/html/experts-club/exemplo-sistema-01
    php artisan optimize:clear
@endtask

@task('npm-install', ['on' => 'producao'])
    su - patrick
    cd /var/www/html/experts-club/exemplo-sistema-01
    npm install
@endtask

@task('npm-update', ['on' => 'producao'])
    su - patrick
    cd /var/www/html/experts-club/exemplo-sistema-01
    npm update
@endtask

@task('composer-update', ['on' => 'producao'])
    su - patrick
    cd /var/www/html/experts-club/exemplo-sistema-01
    composer update -vv
@endtask

@task('atualizar', ['on' => 'producao'])
    su - patrick
    cd /var/www/html/experts-club/exemplo-sistema-01
    git pull
    composer dump-autoload -o
    php artisan optimize:clear
    npm run production
@endtask

@task('migrate', ['on' => 'producao'])
    su - patrick
    cd /var/www/html/experts-club/exemplo-sistema-01
    composer dump-autoload -o
    php artisan migrate
@endtask

@task('pull', ['on' => 'producao'])
    su - patrick
    cd /var/www/html/experts-club/exemplo-sistema-01
    git pull origin {{ $branch }}
@endtask

@task('artisan', ['on' => 'producao'])
    su - patrick
    cd /var/www/html/experts-club/exemplo-sistema-01

    @if ($parametro)
        php artisan {{ $parametro }}
    @endif

    php artisan
@endtask

@task('rollback', ['on' => 'producao', 'confirm' => true])
    su - patrick
    cd /var/www/html/experts-club/exemplo-sistema-01
    php artisan migrate:rollback
@endtask
