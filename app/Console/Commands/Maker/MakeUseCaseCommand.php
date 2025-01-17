<?php

namespace App\Console\Commands\Maker;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;

class MakeUseCaseCommand extends GeneratorCommand
{

    protected $signature = 'make-arch:usecase 
        {name} 
        {--entities=*}
        {--collections=*}
        {--gateways=*}
        {--exceptions=*}
        {--rules=*}
        {--pagination=}';
    protected $description = 'Create a new Use case.';
    protected $type = 'Caso de uso';
    protected $hidden = true;

    public function handle()
    {
        $name = $this->argument('name');

        $arrayFoldersFileStruct = array_reverse(explode('/', $name));
        $pathStubTemplate = str_replace($arrayFoldersFileStruct[0], '#MY_FOLDER#/' . $arrayFoldersFileStruct[0], $name);
        $entities = $this->getEntities();
        $collections = $this->getCollections();
        $gateways = $this->getGateways();
        $exceptions = $this->getExceptions();
        $rules = $this->getRules();

        foreach ($entities as $entity) {
            $this->call(
                'make-arch:entity',
                ['name' => str_replace($arrayFoldersFileStruct[0], 'Entities/' . ucfirst($entity), $name)]
            );
        }
        foreach ($collections as $collection) {
            $this->call(
                'make-arch:collection',
                ['name' => str_replace($arrayFoldersFileStruct[0], 'Collections/' . ucfirst($collection), $name)]
            );
        }
        foreach ($gateways as $gateway) {
            $this->call(
                'make-arch:gateway',
                ['name' => str_replace($arrayFoldersFileStruct[0], 'Gateways/' . ucfirst($gateway), $name)]
            );
        }

        foreach ($exceptions as $exception) {
            $this->call(
                'make-arch:exception',
                ['name' => str_replace($arrayFoldersFileStruct[0], 'Exceptions/' . ucfirst($exception), $name)]
            );
        }

        foreach ($rules as $rule) {
            $this->call(
                'make-arch:rule',
                ['name' => str_replace($arrayFoldersFileStruct[0], 'Rules/' . ucfirst($rule), $name)]
            );
        }

        $this->call(
            'make-arch:exception',
            ['name' => str_replace('#MY_FOLDER#', 'Exceptions', $pathStubTemplate)]
        );
        $this->call(
            'make-arch:output',
            ['name' => str_replace('#MY_FOLDER#', 'Outputs', $pathStubTemplate)]
        );
        $this->call(
            'make-arch:output-presenter',
            ['name' => str_replace('#MY_FOLDER#/', '', $pathStubTemplate)]
        );

        $this->call(
            'make-arch:enum-error',
            ['name' => str_replace($arrayFoldersFileStruct[0], 'Enums/' . 'ErrorCode', $name)]
        );

        $this->call(
            'make-arch:input',
            ['name' => str_replace('#MY_FOLDER#', 'Inputs', $pathStubTemplate)]
        );

        $this->call(
            'make-arch:rule',
            ['name' => str_replace('#MY_FOLDER#', 'Rules', $pathStubTemplate)]
        );

        $this->call(
            'make-arch:ruleset',
            ['name' => str_replace('#MY_FOLDER#', 'Rulesets', $pathStubTemplate)]
        );
        $pagination = (bool)$this->option('pagination') ?? null;
        if ($pagination) {
            $this->call(
                'make-arch:pagination',
                ['name' => str_replace('#MY_FOLDER#', 'Pagination', $pathStubTemplate)]
            );

            $this->call(
                'make-arch:sort',
                ['name' => str_replace('#MY_FOLDER#', 'Resolvers', $pathStubTemplate)]
            );
        }

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

    public function getGateways(): array
    {
        return $this->option('gateways') ? explode(',', trim($this->option('gateways')[0])) : [];
    }

    private function getExceptions(): array
    {
        return $this->option('exceptions') ? explode(',', trim($this->option('exceptions')[0])) : [];
    }

    private function getRules()
    {
        return $this->option('rules') ? explode(',', trim($this->option('rules')[0])) : [];
    }

    protected function getStub()
    {
        return $this->resolveStubPath('/templates/clean/usecase.stub');
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
        return 'Core\\Modules\\';
    }
}
