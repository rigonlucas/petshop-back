<?php

namespace App\Console\Commands\Maker\Utilities;

class LayerPathOveride
{
    public static function overide(string $name, string $folderName): string
    {
        $foldersAndFile = explode('/', $name);
        $arrayStruct = array_reverse($foldersAndFile);
        if ($arrayStruct[1] != $folderName) {
            return str_replace($arrayStruct[0], $folderName, $name) . '/' . $arrayStruct[0];
        }
        return $name;
    }
}