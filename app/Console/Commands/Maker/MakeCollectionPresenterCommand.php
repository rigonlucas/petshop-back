<?php

namespace App\Console\Commands\Maker;

use App\Console\Commands\Maker\Utilities\LayerPathOveride;
use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;

class MakeCollectionPresenterCommand extends GeneratorCommand
{

    protected $signature = 'make-clean:collection-presenter {name}';
    protected $description = 'Create a new collection presenter.';
    protected $type = 'Clean';
    private string $layerAlias = 'Presenters/Collections';

    public function handle()
    {
        parent::handle();
    }

    protected function getStub()
    {
        return $this->resolveStubPath('/stubs/clean/collection-presenter.stub');
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

        return 'core/Modules/' . LayerPathOveride::overideLayerFolder(
                $name,
                $this->layerAlias
            ) . 'CollectionPresenter.php';
    }

    protected function rootNamespace()
    {
        return 'Core\\';
    }
}
