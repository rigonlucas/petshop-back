<?php

namespace App\Console\Commands\Maker\Utilities;

trait HasCustomNamespace
{
    protected function replaceNamespace(&$stub, $name)
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
        $baseNamespace = str_replace('\\' . $this->layerAlias, '', $this->getNamespace($name));
        $stub = str_replace('{{namespaceBase}}', $baseNamespace, $stub);

        return $this;
    }
}