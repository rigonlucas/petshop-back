<?php

namespace App\Console\Commands\Maker;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;

class MakeUseCaseCommand extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make-clean:usecase 
        {name} 
        {--entities=*}
        {--collections=*}
        {--gateways=*}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new Use case.';

    protected $type = 'Clean';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $name = $this->argument('name');
        $foldersAndFile = explode('/', $name);
        $arrayStruct = array_reverse($foldersAndFile);
        $pathStub = str_replace($arrayStruct[0], '#MY_FOLDER#/' . $arrayStruct[0], $name);

        $options = $this->options();
//        dd($options);
        $entities = $this->option('entities') ? explode(',', trim($this->option('entities')[0])) : [];
        $collections = $this->option('collections') ? explode(',', trim($this->option('collections')[0])) : [];
        $gateways = $this->option('gateways') ? explode(',', trim($this->option('gateways')[0])) : [];

        foreach ($entities as $entity) {
            $this->call(
                'make-clean:entity',
                ['name' => str_replace($arrayStruct[0], 'Entities/' . ucfirst($entity), $name)]
            );
        }
        foreach ($collections as $collection) {
            $this->call(
                'make-clean:collection',
                ['name' => str_replace($arrayStruct[0], 'Collections/' . ucfirst($collection), $name)]
            );
        }
        foreach ($gateways as $gateway) {
            $this->call(
                'make-clean:collection',
                ['name' => str_replace($arrayStruct[0], 'Gateways/' . ucfirst($gateway), $name)]
            );
        }

        $this->call(
            'make-clean:exception',
            ['name' => str_replace('#MY_FOLDER#', 'Exceptions', $pathStub)]
        );
        $this->call(
            'make-clean:output',
            ['name' => str_replace('#MY_FOLDER#', 'Outputs', $pathStub)]
        );
        $this->call(
            'make-clean:output-presenter',
            ['name' => str_replace('#MY_FOLDER#', 'Presenters/Outputs', $pathStub)]
        );

        $this->call(
            'make-clean:enum-error',
            ['name' => str_replace($arrayStruct[0], 'Enums/' . 'ErrorCode', $name)]
        );

        $this->call(
            'make-clean:input',
            ['name' => str_replace('#MY_FOLDER#', 'Inputs', $pathStub)]
        );

        $this->call(
            'make-clean:rule',
            ['name' => str_replace('#MY_FOLDER#', 'Rules', $pathStub)]
        );

        $this->call(
            'make-clean:ruleset',
            ['name' => str_replace('#MY_FOLDER#', 'Rulesets', $pathStub)]
        );

        parent::handle();
    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return $this->resolveStubPath('/stubs/clean/usecase.stub');
    }

    /**
     * Resolve the fully-qualified path to the stub.
     *
     * @param string $stub
     * @return string
     */
    protected function resolveStubPath($stub)
    {
        return is_file($customPath = $this->laravel->basePath(trim($stub, '/')))
            ? $customPath
            : __DIR__ . $stub;
    }

    /**
     * Get the destination class path.
     *
     * @param string $name
     * @return string
     */
    protected function getPath($name)
    {
        $name = str_replace('\\', '/', Str::replaceFirst($this->rootNamespace(), '', $name));

        return 'core/Modules/' . $name . 'UseCase.php';
    }

    /**
     * Get the root namespace for the class.
     *
     * @return string
     */
    protected function rootNamespace()
    {
        return 'Core\\';
    }
}
