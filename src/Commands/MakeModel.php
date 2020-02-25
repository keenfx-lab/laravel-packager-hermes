<?php

namespace DelveFore\PackagerHermes\Commands;

use Illuminate\Support\Str;
use Illuminate\Foundation\Console\ModelMakeCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class MakeModel extends ModelMakeCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'make:packager:model';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'create a new model class within a Jeroen-G/laravel-packager package';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->input->setOption('all', false);
        $this->input->setOption('factory', false);
        $this->input->setOption('seed', false);
        $this->input->setOption('migration', false);
        $this->input->setOption('controller', false);
        $this->input->setOption('resource', false);

        if (parent::handle() === false && ! $this->option('force')) {
            return false;
        }

    }

    /**
     * Get the destination class path.
     *
     * @param  string  $name
     * @return string
     */
    protected function getPath($name)
    {
        $name = Str::replaceFirst($this->rootNamespace(), '', $name);
        $name = str_replace('\\', '/', $name);
        $basePath = str_replace('\\', '/', $this->laravel->basePath());
        $namespace = str_replace('\\', '/', $this->rootNamespace());
        $path = $basePath.'/'.'packages/'.$namespace.'/src/'.$name.'.php';
        return $path;
    }

    /**
     * Get the desired class name from the input.
     *
     * @return string
     */
    protected function getNamespaceInput()
    {
        return str_replace('/', '\\', trim($this->argument('namespace')));
    }


    /**
     * Get the root namespace for the class.
     *
     * @return string
     */
    protected function rootNamespace()
    {
        return $this->getNamespaceInput();
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['namespace', InputArgument::REQUIRED, 'The namespace of the package for the model'],
            ['name', InputArgument::REQUIRED, 'The name of the model'],
        ];
    }

}
