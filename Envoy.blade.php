@include('vendor/autoload.php')

@setup
    $env = isset($env) ? $env : 'production';
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__, '.env.' . $env);
    try {
    $dotenv->load();
    $dotenv->required(['DEPLOY_SERVER', 'DEPLOY_REPOSITORY', 'DEPLOY_PATH'])->notEmpty();
    } catch (Exception $ex) {
    echo $ex->getMessage();
    exit;
    }

    $servers = json_decode($_ENV['DEPLOY_SERVER'], true) ?? [];
    $repo = $_ENV['DEPLOY_REPOSITORY'] ?? null;
    $path = $_ENV['DEPLOY_PATH'] ?? null;
    $branch = isset($branch) ? $branch : ($_ENV['DEPLOY_BRANCH'] ?? 'main');

    if (empty($servers)) throw new Exception('Careful - Your deployment servers empty');
    if (substr($path, 0, 1) !== '/') throw new Exception('Careful - Your deployment path does not begin with /');

    $date = (new DateTime())->format('YmdHis');
    $path = rtrim($path, '/');
    $release = $path . '/' . $date;
    $cleanup_number = isset($cleanupnumber) ? $cleanupnumber : 4;
@endsetup

@servers($servers)

@task('init', ['on' => array_keys($servers), 'parallel' => true])
    if [ ! -d {{ $path }}/current ]; then
    cd {{ $path }}
    git clone {{ $repo }} --branch={{ $branch }} --depth=1 -q {{ $release }}
    echo "Repository cloned"

    mv {{ $release }}/storage {{ $path }}/storage
    ln -s {{ $path }}/storage {{ $release }}/storage
    ln -s {{ $path }}/storage/public {{ $release }}/public/storage
    echo "Storage directories set up"

    cp {{ $release }}/.env.{{ $env }} {{ $path }}/.env
    ln -s {{ $path }}/.env {{ $release }}/.env
    echo "Enviroment file setup"

    rm -rf {{ $release }}
    echo "Deployment path already initialised. Run 'envoy run deploy' now."
    else
    echo "Deployment path already initialised (current symlink exists)!"
    fi
@endtask

@story('deploy', ['on' => array_keys($servers), 'parallel' => true])
    deployment_start
    deployment_links
    deployment_composer
    deployment_cache
    deployment_finish
    deployment_option_cleanup
@endstory

@story('rollback', ['on' => array_keys($servers), 'parallel' => true])
    deployment_rollback
@endstory

@task('cleanup', ['on' => array_keys($servers), 'parallel' => true])
    cd {{ $path }}
    echo "Processing clean up old deployments" {{ $cleanup_number }}
    find . -maxdepth 1 -name "20*" | sort | head -n {{ $cleanup_number }} | xargs rm -Rf
    echo "Cleaned up old deployments"
@endtask

@task('deployment_start')
    cd {{ $path }}
    echo "Deployment ({{ $date }}) started"
    git clone {{ $repo }} --branch={{ $branch }} --depth=1 -q {{ $release }}
    echo "Repository cloned"
@endtask

@task('deployment_links')
    cd {{ $path }}

    rm -rf {{ $release }}/storage
    ln -s {{ $path }}/storage {{ $release }}/storage
    ln -s {{ $path }}/storage/public {{ $release }}/public/storage
    echo "Storage directories set up"

    cp {{ $release }}/.env.{{ $env }} {{ $path }}/.env
    ln -s {{ $path }}/.env {{ $release }}/.env

    cp -r {{ $release }}/conf {{ $path }}/confcd
    echo "Enviroment file setup"
@endtask

@task('deployment_composer')
    echo "Installing composer depencencies"
    cd {{ $release }}
    composer install --prefer-dist --no-scripts -q -o
@endtask

@task('deployment_cache')
    php {{ $release }}/artisan cache:clear --quiet
    php {{ $release }}/artisan api:cache --quiet
    php {{ $release }}/artisan config:cache --quiet
    echo "Cache cleared"
@endtask

@task('deployment_finish')
    ln -nfs {{ $release }} {{ $path }}/current

    echo "Deployment ({{ $date }}) finished"
@endtask

@task('deployment_option_cleanup')
    cd {{ $path }}
    @if (isset($cleanup) && $cleanup)
        find . -maxdepth 1 -name "20*" | sort | head -n 1 | xargs rm -Rf
        echo "Cleaned up old deployments"
    @endif
@endtask

@task('deployment_rollback')
    cd {{ $path }}
    ln -nfs {{ $path }}/$(find . -maxdepth 1 -name "20*" | sort | tail -n 2 | head -n 1)
    {{ $path }}/current
    echo "Roller back to $(find . -maxdepth 1 -name "20*" | sort | tail -n 2 | head -n 1)"
    echo "Deleting $(find . -maxdepth 1 -name "20*" | sort | tail -n 1 | head -n 1)"
    rm -rf {{ $path }}/$(find . -maxdepth 1 -name "20*" | sort | tail -n 1 | head -n 1)
    echo "Done!"
@endtask
