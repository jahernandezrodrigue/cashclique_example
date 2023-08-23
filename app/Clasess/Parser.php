<?php

namespace App\Clasess;

use Illuminate\Support\Str;

class Parser
{
    protected $modelNamespace = 'App';

    protected function getModelPath($name)
    {
        return $this->makeDirectory(app_path($this->getNamespacePath($this->modelNamespace) . "{$name}.php"));
    }

    private function getNamespacePath($namespace)
    {
        $str = Str::start(Str::finish(Str::after($namespace, 'App'), '\\'), '\\');

        return str_replace('\\', '/', $str);
    }
}