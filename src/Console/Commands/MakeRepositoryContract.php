<?php

namespace Treggats\CrudRepositoryGenerator\Console\Commands;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Container\Container;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class MakeRepositoryContract extends GeneratorCommand
{
    /**
     * @var array $config
     */
    protected $config;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:contract {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new repository interface';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Contract';

    /**
     * {@inheritdoc}
     */
    public function __construct(Filesystem $files)
    {
        parent::__construct($files);

        $this->config = Container::getInstance()->make('config')->get('crud-repository-generator', []);
    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__ . '/../../stubs/contract.stub';
    }

    /**
     * {@inheritdoc}
     */
    protected function getDefaultModelNamespace()
    {
        return Arr::get($this->config, 'model_namespace');
    }
    /**
     * {@inheritdoc}
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return Arr::get($this->config, 'contract_namespace');
    }
    /**
     * @return string
     */
    public function getModel()
    {
        return Str::finish($this->getDefaultModelNamespace(), '\\') . $this->guessModelClass();
    }

    /**
     * {@inheritdoc}
     */
    protected function buildClass($name)
    {
        $stub = parent::buildClass($name);
        $this->replaceModelClass($stub)
            ->replaceModelNamespace($stub)
            ->replaceModelVariable($stub);
        return $stub;
    }

    /**
     * Replace the model class name for the given stub.
     *
     * @param string $stub
     *
     * @return $this
     */
    protected function replaceModelClass(&$stub)
    {
        $stub = str_replace('DummyModelClass', $this->guessModelClass(), $stub);
        return $this;
    }

    /**
     * Replace the model name for the given stub.
     *
     * @param string $stub
     *
     * @return $this
     */
    protected function replaceModelNamespace(&$stub)
    {
        $stub = str_replace('DummyModelNamespace', $this->getDefaultModelNamespace(), $stub);
        return $this;
    }

    /**
     * Replace the model variable for the given stub.
     *
     * @param string $stub
     *
     * @return $this
     */
    protected function replaceModelVariable(&$stub)
    {
        $variableName = '$' . Arr::last(explode('_', Str::snake($this->guessModelClass())));
        $stub = str_replace('DummyModelVariable', $variableName, $stub);
        return $this;
    }

    /**
     * @return string
     */
    protected function guessModelClass()
    {
        return preg_replace('/RepositoryInterface$/', '', $this->getNameInput());
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
//	public function fire()
//	{
//		if (parent::fire() === false) {
//			return;
//		}
//
//		if ($this->option('contract')) {
//			$arr = ['name' => $this->guessModelClass().'RepositoryInterface'];
//			$this->call('make:contract', $arr);
//		}
//	}
}
