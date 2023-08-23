<?php

namespace App\Clasess;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class GenerateModel
{
    public $stubModel;
    public $fiels;
    public $class;
    public $classvar;
    public $namespace = 'App\Models';
    public $pathInsertModel;
    public $template = '';
    public $baseModelPath = 'App/Models';
    public $directories;
    public $classFile;

    public function getNamespace()
    {
        $directories = preg_split('/[.\/(\\\\)]+/', $this->class);
        $camelCase = str(array_pop($directories))->camel();
        $kebabCase = str($camelCase)->kebab();

        $this->classFile = str($kebabCase)->studly();

        $this->directories = $directories;
        $path = str($this->modelPath())->replaceFirst(base_path().DIRECTORY_SEPARATOR, '');

        $modelPath = $this->generatePathFromNamespace($this->classNamespace());

        dd([
            'path' => $path,
            'folderModelPath' => $modelPath,
            'modelPath' => $modelPath.$camelCase->value,
            'namespaces' => $this->classNamespace(),
            'class' => str($kebabCase)->studly()->value,
            'classvar' => $kebabCase->value,
            'fillable' => $this->fillable(),
        ]);

    }

    public function modelPath()
    {
        return $this->baseModelPath.collect()
            ->concat($this->directories)
            ->push($this->classFile)
            ->implode('/');
    }

    public function classNamespace()
    {
        $newBaseModelPath = str_replace("/", "\\", $this->baseModelPath);

        return empty($this->directories)
            ? $newBaseModelPath
            : $newBaseModelPath.'\\'.collect()
                ->concat($this->directories)
                ->map([Str::class, 'studly'])
                ->implode('\\');
    }


    public function __construct($fiels)
    {        
        $this->class = 'Finance/Expense';

        $this->fiels = $fiels;

        $this->getNamespace();
        
        $this->stubModel = base_path('app/Clasess/stubs/model.stub');

        if($this->existsFile()) {
            $this->template = file_get_contents($this->stubModel);
        }
    }

    public function buildModel($name)
    {
        $this->makingDirectory();
        //dd('fre');
        $modelPath = $this->generatePathFromNamespace($this->namespace);
        if (!File::exists($modelPath)) {
            return false;
        }
        $modelPath = $modelPath . $this->class . '.php';
        
        $this->reeplaceTemplate();

        File::put($modelPath, $this->template);


        return $modelPath;

    }

    public function existsFile() 
    {
        if (File::exists($stubPath = $this->stubModel)) {
            return true;
        }
        return false;
    }

    public function reeplaceTemplate()
    {
        $template = preg_replace(
            ['/\[namespace\]/', '/\[class\]/', '/\[tablename\]/', '/\[fillable\]/'],
            [$this->namespace, $this->class, 'tipos', $this->fillable()],
            $this->template
        );
        $this->template = $template;
    }

    public function makingDirectory()
    {
        $modelPath = $this->generatePathFromNamespace($this->namespace);
        if(!is_dir($modelPath)) {
            mkdir($modelPath, 0777, true);
        }
    }

    public static function generatePathFromNamespace($namespace)
    {
        $name = str($namespace)->finish('\\')->replaceFirst(app()->getNamespace(), '');
        return app('path').'/'.str_replace('\\', '/', $name);
    }

    public function fillable () {

        /** @var array $filterColumns Exclude the unwanted columns */
        $filterColumns = $this->fiels;

        // Add quotes to the unwanted columns for fillable
        array_walk($filterColumns, function (&$value) {
            $value = "'" . $value . "'";
        });

        // CSV format
        return implode(',', $filterColumns);
    }
}