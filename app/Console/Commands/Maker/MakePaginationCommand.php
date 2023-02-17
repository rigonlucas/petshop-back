<?php

namespace App\Console\Commands\Maker;

use App\Console\Commands\Maker\Utilities\LayerPathOveride;
use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;

class MakePaginationCommand extends GeneratorCommand
{
    protected $signature = 'make-arch:pagination {name}';
    protected $description = 'Create a new pagination.';
    protected $type = 'Pagiantion';
    protected $hidden = true;
    private string $layerAlias = 'Pagination';

    public function handle()
    {
        parent::handle();
    }

    protected function getStub()
    {
        return $this->resolveStubPath('/templates/clean/pagination.stub');
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
        return 'core/Modules/' . LayerPathOveride::overideLayerFolder($name, $this->layerAlias) . 'Pagination.php';
    }

    protected function rootNamespace()
    {
        return 'Core\\Modules\\';
    }
}
