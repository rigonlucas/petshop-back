<?php

namespace App\Console\Commands\Maker;

use App\Console\Commands\Maker\Utilities\HasCustomNamespace;
use App\Console\Commands\Maker\Utilities\LayerPathOveride;
use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;

class MakeRuleCommand extends GeneratorCommand
{
    use HasCustomNamespace;

    protected $signature = 'make-arch:rule {name}';
    protected $description = 'Create a new rule.';
    protected $type = 'Rule';
    protected $hidden = true;
    private string $layerAlias = 'Rules';

    public function handle()
    {
        parent::handle();
    }

    protected function getStub()
    {
        return $this->resolveStubPath('/templates/clean/rule.stub');
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

        return 'core/Modules/' . LayerPathOveride::overideLayerFolder($name, $this->layerAlias) . 'Rule.php';
    }

    protected function rootNamespace()
    {
        return 'Core\\Modules\\';
    }
}
