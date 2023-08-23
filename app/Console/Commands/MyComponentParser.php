<?php

namespace App\Console\Commands;

use Livewire\Commands\ComponentParser;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use function Livewire\str;

#[\AllowDynamicProperties]
class MyComponentParser extends ComponentParser
{
    public function classFile()
    {
        if(basename($this->stubDirectory) == 'index') {
            return 'Index'.$this->componentClass.'s.php';
        }
        if(basename($this->stubDirectory) == 'create') {
            return 'Create'.$this->componentClass.'.php';
        }
        if(basename($this->stubDirectory) == 'show') {
            return 'Show'.$this->componentClass.'.php';
        }
        return $this->componentClass.'.php';
    }

    public function classNamespace()
    {
        return empty($this->directories)
            ? $this->baseClassNamespace
            : $this->baseClassNamespace.'\\'.collect()
                ->concat($this->directories)
                ->map([Str::class, 'studly'])
                ->implode('\\');
    }

    public function className()
    {
        return $this->componentClass;
    }

    public function classContents($inline = false)
    {
        $stubName = $inline ? 'livewire.inline.stub' : 'livewire.stub';

        if (File::exists($stubPath = base_path($this->stubDirectory.$stubName))) {
            $template = file_get_contents($stubPath);
        } else {
            $template = file_get_contents(__DIR__.DIRECTORY_SEPARATOR.$stubName);
        }

        if ($inline) {
            $template = preg_replace('/\[quote\]/', $this->wisdomOfTheTao(), $template);
        }

         return preg_replace(
            ['/\[namespace\]/', '/\[class\]/', '/\[view\]/', '/\[classvar\]/', '/\[view-component\]/'],
            [$this->classNamespace(), $this->className(), $this->viewName(), lcfirst($this->className()), $this->viewImportName()],
            $template
        );
    }

    public function viewPath()
    {
        return $this->baseViewPath.collect()
            ->concat($this->directories)
            ->map([Str::class, 'kebab'])
            ->push($this->viewFile())
            ->implode(DIRECTORY_SEPARATOR);
    }

    public function relativeViewPath() : string
    {
        return str($this->viewPath())->replaceFirst(base_path().'/', '');
    }

    public function viewFile()
    {
        if(basename($this->stubDirectory) == 'index') {
            return 'index-'.$this->component.'s.blade.php';
        }
        if(basename($this->stubDirectory) == 'create') {
            return 'create-'.$this->component.'.blade.php';
        }
        if(basename($this->stubDirectory) == 'show') {
            return 'show-'.$this->component.'.blade.php';
        }
        return $this->component.'.blade.php';
    }

    public function viewName()
    {
        $thecomponent = $this->component;

        if(basename($this->stubDirectory) == 'index') {
            $thecomponent = 'index-'.$this->component.'s';
        }
        if(basename($this->stubDirectory) == 'create') {
            $thecomponent = 'create-'.$this->component;
        }
        if(basename($this->stubDirectory) == 'show') {
            $thecomponent = 'show-'.$this->component;
        }

        return collect()
            ->when(config('livewire.view_path') != resource_path(), function ($collection) {
                return $collection->concat(explode('/',str($this->baseViewPath)->after(resource_path('views'))));
            })
            ->filter()
            ->concat($this->directories)
            ->map([Str::class, 'kebab'])
            ->push($thecomponent) // ->push($this->component)
            ->implode('.');
    }
    public function viewImportName()
    {
        $thecomponent = $this->component;

        if(basename($this->stubDirectory) == 'index') {
            $thecomponent = 'create-'.$this->component;
        }
        if(basename($this->stubDirectory) == 'create') {
            $thecomponent = 'index-'.$this->component.'s';
        }
        // if(basename($this->stubDirectory) == 'show') {
        //     $thecomponent = 'show-'.$this->component;
        // }


        $rr = collect()
            ->when(config('livewire.view_path') != resource_path(), function ($collection) {
                return $collection->concat(explode('/',str($this->baseViewPath)->after(resource_path('views'))));
            })
            ->filter()
            ->concat($this->directories)
            ->map([Str::class, 'kebab'])
            ->push($thecomponent) // ->push($this->component)
            ->implode('.');
        
        $originalCadena = $rr;
        $partes = explode('.', $originalCadena);  // Dividir la cadena en partes usando el punto como separador
        $partesSinLivewire = array_filter($partes, function ($parte) {
            return $parte !== "livewire";  // Filtrar las partes que no son "livewire"
        });
        $nuevaCadena = implode('.', $partesSinLivewire);  // Volver a unir las partes con puntos
        return $nuevaCadena;
    }

    public function viewContents()
    {
        if( ! File::exists($stubPath = base_path($this->stubDirectory.'livewire.view.stub'))) {
            $stubPath = __DIR__.DIRECTORY_SEPARATOR.'livewire.view.stub';
        }
        
        return preg_replace(
            ['/\[namespace\]/', '/\[class\]/', '/\[view\]/', '/\[classvar\]/', '/\[view-component\]/'],
            [$this->classNamespace(), $this->className(), $this->viewName(), lcfirst($this->className()), $this->viewImportName()],
            file_get_contents($stubPath)
        );
    }

    public function testNamespace()
    {
        return empty($this->directories)
            ? $this->baseTestNamespace
            : $this->baseTestNamespace.'\\'.collect()
                ->concat($this->directories)
                ->map([Str::class, 'studly'])
                ->implode('\\');
    }

    public function testClassName()
    {
        return $this->componentClass.'Test';
    }

    public function testFile()
    {
        return $this->componentClass.'Test.php';
    }

    public function testPath()
    {
        return $this->baseTestPath.collect()
        ->concat($this->directories)
        ->push($this->testFile())
        ->implode('/');
    }

    public function relativeTestPath() : string
    {
        return str($this->testPath())->replaceFirst(base_path().'/', '');
    }

    public function testContents()
    {
        $stubName = 'livewire.test.stub';

        if(File::exists($stubPath = base_path($this->stubDirectory.$stubName))) {
            $template = file_get_contents($stubPath);
        } else {
            $template = file_get_contents(__DIR__.DIRECTORY_SEPARATOR.$stubName);
        }

        return preg_replace(
            ['/\[testnamespace\]/', '/\[classwithnamespace\]/', '/\[testclass\]/', '/\[class\]/'],
            [$this->testNamespace(), $this->classNamespace() . '\\' . $this->className(), $this->testClassName(), $this->className()],
            $template
        );
    }

    public function wisdomOfTheTao()
    {
        $wisdom = require __DIR__.DIRECTORY_SEPARATOR.'the-tao.php';

        return Arr::random($wisdom);
    }

    public static function generatePathFromNamespace($namespace)
    {
        $name = str($namespace)->finish('\\')->replaceFirst(app()->getNamespace(), '');
        return app('path').'/'.str_replace('\\', '/', $name);
    }

    public static function generateTestPathFromNamespace($namespace)
    {
        return str(base_path($namespace))
            ->replace('\\', '/', $namespace)
            ->replaceFirst('T', 't');
    }
}
