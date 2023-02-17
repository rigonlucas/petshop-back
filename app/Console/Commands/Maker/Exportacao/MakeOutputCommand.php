<?php

namespace App\Console\Commands\Maker\Exportacao;

use App\Console\Commands\Maker\Utilities\HasCustomNamespace;
use App\Console\Commands\Maker\Utilities\LayerPathOveride;
use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;

class MakeOutputCommand extends GeneratorCommand
{
    use HasCustomNamespace;

    protected $signature = 'make-arch:exportacao-output {name}';
    protected $description = 'Create a new output.';
    protected $type = 'Output';
    protected $hidden = true;
    private string $layerAlias = 'Outputs';

    public function handle()
    {
        parent::handle();
    }

    protected function getStub()
    {
        return $this->resolveStubPath('/templates/clean/exportacao/output-exportacao.stub');
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

        return 'core/Modules/' . LayerPathOveride::overideLayerFolder($name, $this->layerAlias) . 'Output.php';
    }

    protected function rootNamespace()
    {
        return 'Core\\Modules\\';
    }
}
