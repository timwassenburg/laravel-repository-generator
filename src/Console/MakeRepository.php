<?php

namespace TimWassenburg\RepositoryGenerator\Console;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;

class MakeRepository extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:repository {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new repository class';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Repository';

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__.'/../../stubs/repository.stub';
    }

    public function handle()
    {
        // Generate the repository interface
        $this->call('make:repository-interface', ['name' => $this->getNameInput().'Interface']);

        return parent::handle();
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace.'\Repositories\Eloquent';
    }

    /**
     * Replace the namespace for the given stub.
     *
     * @param  string  $stub
     * @param  string  $name
     * @return $this
     */
    protected function replaceNamespace(&$stub, $name)
    {
        $classname = Str::replace('Repository', '', $this->getNameInput());
        $stub = Str::replace('{{ Model }}', $classname, $stub);
        $stub = Str::replace('{{ namespacedModel }}', 'App\Models\\'.$classname, $stub);

        return parent::replaceNamespace($stub, $name);
    }
}
