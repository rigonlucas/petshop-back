<?php

namespace App\Console\Commands\Maker\Exportacao;

use App\Console\Commands\Maker\Utilities\HasCustomNamespace;
use App\Console\Commands\Maker\Utilities\LayerPathOveride;
use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;

class MakeRuleSetCommand extends GeneratorCommand
{
    use HasCustomNamespace;

    protected $signature = 'make-arch:exportacao-ruleset {name}';
    protected $description = 'Create a new rule.';
    protected $type = 'Ruleset';
    protected $hidden = true;
    private string $layerAlias = 'Rulesets';

    public function handle()
    {
        parent::handle();
    }

    protected function getStub()
    {
        return $this->resolveStubPath('/templates/clean/exportacao/rule-set.stub');
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

        return 'core/Modules/' . LayerPathOveride::overideLayerFolder($name, $this->layerAlias) . 'Ruleset.php';
    }

    protected function rootNamespace()
    {
        return 'Core\\Modules\\';
    }

    /*protected function replaceNamespace(&$stub, $name)
    {
        $searches = [
            ['DummyNamespace', 'DummyRootNamespace', 'NamespacedDummyUserModel'],
            ['{{ namespace }}', '{{ rootNamespace }}', '{{ namespacedUserModel }}'],
            ['{{namespace}}', '{{rootNamespace}}', '{{namespacedUserModel}}', '{{nameSpaceArq}}'],
        ];

        foreach ($searches as $search) {
            $stub = str_replace(
                $search,
                [
                    $this->getNamespace($name),
                    $this->rootNamespace(),
                    $this->userProviderModel(),
                ],
                $stub
            );
        }
        $replaceBaseNamespace = str_replace('\\' . $this->layerAlias, '', $this->getNamespace($name));
        $stub = str_replace('{{batata}}', $replaceBaseNamespace, $stub);

        return $this;
    }*/
}
