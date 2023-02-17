<?php

namespace App\Console\Commands\Maker;

use App\Console\Commands\Maker\Utilities\HasCustomNamespace;
use App\Console\Commands\Maker\Utilities\LayerPathOveride;
use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;

class MakeExceptionCommand extends GeneratorCommand
{
    use HasCustomNamespace;

    protected $signature = 'make-arch:exception {name}';
    protected $description = 'Create a new Service.';
    protected $type = 'Exception';
    protected $hidden = true;
    private string $layerAlias = 'Exceptions';

    public function handle()
    {
        parent::handle();
    }

    protected function getStub()
    {
        return $this->resolveStubPath('/templates/clean/exception.stub');
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

        return 'core/Modules/' . LayerPathOveride::overideLayerFolder($name, $this->layerAlias) . 'Exception.php';
    }

    protected function rootNamespace()
    {
        return 'Core\\Modules\\';
    }
}
