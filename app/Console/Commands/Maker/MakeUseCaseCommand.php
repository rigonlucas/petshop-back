<?php

namespace App\Console\Commands\Maker;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;

class MakeUseCaseCommand extends GeneratorCommand
{

    protected $signature = 'make-clean:usecase 
        {name} 
        {--entities=*}
        {--collections=*}
        {--gateways=*}';
    protected $description = 'Create a new Use case.';
    protected $type = 'Clean';

    public function handle()
    {
        $name = $this->argument('name');

        $arrayFoldersFileStruct = array_reverse(explode('/', $name));
        $pathStubTemplate = str_replace($arrayFoldersFileStruct[0], '#MY_FOLDER#/' . $arrayFoldersFileStruct[0], $name);

        $entities = $this->getEntities();
        $collections = $this->getCollections();
        $gateways = $this->getGateways();

        foreach ($entities as $entity) {
            $this->call(
                'make-clean:entity',
                ['name' => str_replace($arrayFoldersFileStruct[0], 'Entities/' . ucfirst($entity), $name)]
            );
        }
        foreach ($collections as $collection) {
            $this->call(
                'make-clean:collection',
                ['name' => str_replace($arrayFoldersFileStruct[0], 'Collections/' . ucfirst($collection), $name)]
            );
        }
        foreach ($gateways as $gateway) {
            $this->call(
                'make-clean:collection',
                ['name' => str_replace($arrayFoldersFileStruct[0], 'Gateways/' . ucfirst($gateway), $name)]
            );
        }

        $this->call(
            'make-clean:exception',
            ['name' => str_replace('#MY_FOLDER#', 'Exceptions', $pathStubTemplate)]
        );
        $this->call(
            'make-clean:output',
            ['name' => str_replace('#MY_FOLDER#', 'Outputs', $pathStubTemplate)]
        );
        $this->call(
            'make-clean:output-presenter',
            ['name' => str_replace('#MY_FOLDER#', 'Presenters/Outputs', $pathStubTemplate)]
        );

        $this->call(
            'make-clean:enum-error',
            ['name' => str_replace($arrayFoldersFileStruct[0], 'Enums/' . 'ErrorCode', $name)]
        );

        $this->call(
            'make-clean:input',
            ['name' => str_replace('#MY_FOLDER#', 'Inputs', $pathStubTemplate)]
        );

        $this->call(
            'make-clean:rule',
            ['name' => str_replace('#MY_FOLDER#', 'Rules', $pathStubTemplate)]
        );

        $this->call(
            'make-clean:ruleset',
            ['name' => str_replace('#MY_FOLDER#', 'Rulesets', $pathStubTemplate)]
        );

        parent::handle();
    }

    public function getEntities(): array
    {
        return $this->option('entities') ? explode(',', trim($this->option('entities')[0])) : [];
    }

    public function getCollections(): array
    {
        return $this->option('collections') ? explode(',', trim($this->option('collections')[0])) : [];
    }

    public function getGateways(): MakeUseCaseCommand
    {
        $gateways = $this;
        return $gateways;
    }

    protected function getStub()
    {
        return $this->resolveStubPath('/stubs/clean/usecase.stub');
    }

    protected function resolveStubPath($stub)
    {
        return is_file($customPath = $this->laravel->basePath(trim($stub, '/')))
            ? $customPath
            : __DIR__ . $stub;
    }

    protected function getPath($name)
    {
        $name = str_replace('\\', '/', Str::replaceFirst($this->rootNamespace(), '', $name));

        return 'core/Modules/' . $name . 'UseCase.php';
    }

    protected function rootNamespace()
    {
        return 'Core\\';
    }
}
