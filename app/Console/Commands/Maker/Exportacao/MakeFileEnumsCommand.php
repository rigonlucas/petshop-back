<?php

namespace App\Console\Commands\Maker\Exportacao;

use App\Console\Commands\Maker\Utilities\HasCustomNamespace;
use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;

class MakeFileEnumsCommand extends GeneratorCommand
{
    use HasCustomNamespace;

    protected $signature = 'make-arch:exportacao-file-enum {name}';
    protected $description = 'Create a new output.';
    protected $type = 'Enums';
    protected $hidden = true;
    private string $layerAlias = 'Enums';

    public function handle()
    {
        parent::handle();
    }

    protected function getStub()
    {
        return $this->resolveStubPath('/templates/clean/exportacao/file-data-enum.stub');
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

        return 'core/Modules/' . implode('/', $arr) . '/FileDataEnum.php';
    }

    protected function rootNamespace()
    {
        return 'Core\\Modules\\';
    }
}
