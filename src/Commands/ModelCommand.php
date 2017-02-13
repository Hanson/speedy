<?php

namespace Hanson\Speedy\Commands;

use Speedy;
use Illuminate\Console\GeneratorCommand;

class ModelCommand extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'speedy:model';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create models from speedy config';

    protected $model;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function fire()
    {
        $this->handle();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        foreach (config('speedy.class.model') as $name => $model) {
            $this->createModel($name);
        }
    }

    protected function createModel($stub)
    {
        $this->model = $stub;

        $name = Speedy::getDefaultNamespace($stub);

        $path = $this->getPath($name);

        if ($this->alreadyExists($name)) {
            $this->error($name.' already exists!');

            return false;
        }

        $this->makeDirectory($path);

        $this->files->put($path, $this->buildClass($name));

        $this->info($name.' created successfully.');
    }


    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__ . "/../stubs/{$this->model}.stub";
    }

    protected function buildClass($name)
    {
        $stub = $this->files->get($this->getStub());

        return $this->replaceNamespace($stub, $name)->replaceTable($stub)->replaceClass($stub, $name);
    }

    protected function replaceTable(&$stub)
    {
        $stub =  str_replace('DummyTable', $this->model, $stub);

        return $this;
    }
}
