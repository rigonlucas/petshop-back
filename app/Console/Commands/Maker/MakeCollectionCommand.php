<?php

namespace App\Console\Commands\Maker;

use App\Console\Commands\Maker\Utilities\HasCustomNamespace;
use App\Console\Commands\Maker\Utilities\LayerPathOveride;
use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;

class MakeCollectionCommand extends GeneratorCommand
{
    use HasCustomNamespace;

    protected $signature = 'make-arch:collection {name}';
    protected $description = 'Create a new collection.';
    protected $type = 'Collection';
    protected $hidden = true;
    private string $layerAlias = 'Collections';

    public function handle()
    {
        parent::handle();
    }

    protected function getStub()
    {
        return $this->resolveStubPath('/templates/clean/collection.stub');
    }

    protected function resolveStubPath($stub)
    {
        return is_file($customPath = $this->laravel->basePath(trim($stub, '/')))
            ? $customPath
            : __DIR__ . $stub;
    }

    protected function getPath($name)
    {
        $name = str_replace(
            '\\',
            '/',
            Str::replaceFirst($this->rootNamespace(), '', $name)
        );
        return 'core/Modules/' . LayerPathOveride::overideLayerFolder($name, $this->layerAlias) . 'Collection.php';
    }

    protected function rootNamespace()
    {
        return 'Core\\Modules\\';
    }
}
