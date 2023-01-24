<?php

namespace App\Console\Commands\Maker;

use App\Console\Commands\Maker\Utilities\LayerPathOveride;
use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;

class MakeEnumErrorCodeCommand extends GeneratorCommand
{
    protected $signature = 'make-clean:enum-error {name}';
    protected $description = 'Create a new enum error.';
    protected $type = 'Clean';
    protected $hidden = true;
    private string $layerAlias = 'Enums';

    public function handle()
    {
        parent::handle();
    }

    protected function getStub()
    {
        return $this->resolveStubPath('/stubs/clean/enum-error.stub');
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

        return 'core/Modules/' . LayerPathOveride::overideLayerFolder($name, $this->layerAlias) . 'Enum.php';
    }

    protected function rootNamespace()
    {
        return 'Core\\';
    }
}
