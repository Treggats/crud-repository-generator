<?php

namespace Treggats\CrudRepositoryGenerator;

use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;

class CrudRepositoryGeneratorServiceProvider extends ServiceProvider
{
    /**
     * @var string $configPath
     */
    protected $configPath;

    /**
     * {@inheritdoc}
     */
    public function __construct(Application $app)
    {
        parent::__construct($app);
        $this->configPath = __DIR__ . '/../config/crud-repository-generator.php';
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $publishPath = $this->app->make('path.config') . DIRECTORY_SEPARATOR . 'crud-repository-generator.php';
        $this->publishes([$this->configPath => $publishPath], 'config');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom($this->configPath, 'crud-repository-generator');

        if ($this->app->runningInConsole()) {
            $this->commands([
                Console\Commands\MakeRepository::class,
                Console\Commands\MakeRepositoryContract::class,
            ]);
        }
    }
}
