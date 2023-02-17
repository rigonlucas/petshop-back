<?php

namespace App\Console\Commands\Maker;

use App\Console\Commands\Maker\Utilities\HasCustomNamespace;
use App\Console\Commands\Maker\Utilities\LayerPathOveride;
use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;

class MakeSimplePresenterCommand extends GeneratorCommand
{
    use HasCustomNamespace;

    protected $signature = 'make-arch:presenter {name}';
    protected $description = 'Create a new presenter.';
    protected $type = 'Presenter';
    protected $hidden = true;
    private $layerAlias = 'Presenters';

    public function handle()
    {
        parent::handle();
    }

    protected function getStub()
    {
        return $this->resolveStubPath('/templates/clean/simple-presenter.stub');
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

        return 'core/Modules/' . LayerPathOveride::overideLayerFolder($name, $this->layerAlias) . 'Presenter.php';
    }

    protected function rootNamespace()
    {
        return 'Core\\Modules\\';
    }
}
