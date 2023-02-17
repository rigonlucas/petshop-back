<?php

namespace App\Console\Commands\Maker\Exportacao;

use App\Console\Commands\Maker\Utilities\HasCustomNamespace;
use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;

class MakeRuleCriaCSVCommand extends GeneratorCommand
{
    use HasCustomNamespace;

    protected $signature = 'make-arch:exportacao-cria-rule {name}';
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
        return $this->resolveStubPath('/templates/clean/exportacao/rule-cria-csv.stub');
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
        $arr = explode('/', $name);
        array_pop($arr);

        return 'core/Modules/' . implode('/', $arr) . '/CriarArquivoCSVRule.php';
    }

    protected function rootNamespace()
    {
        return 'Core\\Modules\\';
    }
}
