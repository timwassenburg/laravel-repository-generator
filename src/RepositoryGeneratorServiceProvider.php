<?php

namespace TimWassenburg\RepositoryGenerator;

use Illuminate\Support\Facades\File;
use Illuminate\Support\ServiceProvider;
use TimWassenburg\RepositoryGenerator\Console\MakeRepository;
use TimWassenburg\RepositoryGenerator\Console\MakeRepositoryInterface;

class RepositoryGeneratorServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        if (config('repository-generator.auto_bind_interfaces')) {
            $this->bindInterfaces();
        }

        $this->mergeConfigFrom(__DIR__.'/../config/repository-generator.php', 'repository-generator');
    }

    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                MakeRepository::class,
                MakeRepositoryInterface::class,
            ]);

            $this->publishes([
                __DIR__.'/../config/repository-generator.php' => config_path('repository-generator.php'),
            ], 'config');
        }
    }

    protected function bindInterfaces()
    {
        $path = app_path('Repositories/Eloquent');
        $files = (file_exists($path)) ? File::files($path) : [];

        foreach ($files as $file) {
            $repository = 'App\Repositories\Eloquent\\'.$file->getFilenameWithoutExtension();
            $repositoryInterface = 'App\Repositories\\'.$file->getFilenameWithoutExtension().'Interface';

            $this->app->bind($repositoryInterface, $repository);
        }
    }
}
