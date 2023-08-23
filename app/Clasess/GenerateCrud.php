<?php

namespace App\Clasess;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\File;

class GenerateCrud
{
    /**
     * The filesystem instance.
     *
     * @var \Illuminate\Filesystem\Filesystem
     */
    protected $files;
    public $namespace;
    public $modelPath;
    public $class;
    public $fiels;

    public function __construct($fiels) // Filesystem $files)
    {
        $this->fiels = $fiels;
    }

    public function main()
    {
        // Generate model
        $generateModel = new GenerateModel($this->fiels);
        $generateModel->buildModel('Temporal/User');

        // Generate migration
    }



    /*

    protected function buildModel()
    {
        $stubModel = base_path('app/Clasess/stubs/model.stub');
        $template = '';
        if (File::exists($stubPath = $stubModel)) {
            $template = file_get_contents($stubPath);
        }

        $newTemplate = preg_replace(
            ['/\[namespace\]/', '/\[class\]/', '/\[tablename\]/', '/\[fillable\]/'],
            [$this->namespace, $this->class, 'tipos', $this->fillable()],
            $template
        );

        $modelPath = $this->generatePathFromNamespace($this->namespace);
        if(!is_dir($modelPath)) {
            mkdir($modelPath, 0777, true);
        }
        
        if (!File::exists($modelPath)) {
            return false;
        }
        $modelPath = $modelPath . $this->class . '.php';
        File::put($modelPath, $newTemplate);

        return $modelPath;
    }

    protected function makeDirectory($path)
    {
        if (!$this->files->isDirectory(dirname($path))) {
            $this->files->makeDirectory(dirname($path), 0777, true, true);
        }

        return $path;
    }

    public static function generatePathFromNamespace($namespace)
    {
        $name = str($namespace)->finish('\\')->replaceFirst(app()->getNamespace(), '');
        return app('path').'/'.str_replace('\\', '/', $name);
    }

    public function fillable () {
        // @var array $filterColumns Exclude the unwanted columns
        $filterColumns = $this->fiels;

        // Add quotes to the unwanted columns for fillable
        array_walk($filterColumns, function (&$value) {
            $value = "'" . $value . "'";
        });

        // CSV format
        return implode(',', $filterColumns);
    }

    */

}
