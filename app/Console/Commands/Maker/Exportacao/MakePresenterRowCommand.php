<?php

namespace App\Console\Commands\Maker\Exportacao;

use App\Console\Commands\Maker\Utilities\HasCustomNamespace;
use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;

class MakePresenterRowCommand extends GeneratorCommand
{
    use HasCustomNamespace;

    protected $signature = 'make-arch:exportacao-row {name}';
    protected $description = 'Create a new presetner.';
    protected $type = 'Presenter';
    protected $hidden = true;
    private string $layerAlias = 'Presenters';

    public function handle()
    {
        parent::handle();
    }

    protected function getStub()
    {
        return $this->resolveStubPath('/templates/clean/exportacao/row-presenter.stub');
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

        return 'core/Modules/' . implode('/', $arr) . '/CSVPresenter.php';
    }

    protected function rootNamespace()
    {
        return 'Core\\Modules\\';
    }
}
