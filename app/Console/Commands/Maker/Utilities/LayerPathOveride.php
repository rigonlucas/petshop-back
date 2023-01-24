<?php

namespace App\Console\Commands\Maker\Utilities;

class LayerPathOveride
{
    public static function overideLayerFolder(string $name, string $folderName): string
    {
        $foldersAndFile = explode('/', $name);
        $arrayStruct = array_reverse($foldersAndFile);
        if ($arrayStruct[1] != $folderName) {
            /*dd(
                $name,
                $folderName,
                $arrayStruct,
                str_replace($arrayStruct[0], $folderName, $name) . '/' . $arrayStruct[0]
            );*/
            return str_replace($arrayStruct[0], $folderName, $name) . '/' . $arrayStruct[0];
        }
        //dd($name);
        return $name;
    }
}