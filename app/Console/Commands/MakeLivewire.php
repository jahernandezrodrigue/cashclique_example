<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Livewire\Commands\MakeCommand;

class MakeLivewire extends MakeCommand
{
    protected $signature = 'make:jex {name} {--force} {--inline} {--test} {--stub= : If you have several stubs, stored in subfolders }';

    protected $description = 'Create a new Livewire component';

    public function handle()
    {
        $this->parser = new MyComponentParser(
            config('livewire.class_namespace'),
            config('livewire.view_path'),
            $this->argument('name'),
            $this->option('stub')
        );

        if (!$this->isClassNameValid($name = $this->parser->className())) {
            $this->line("<options=bold,reverse;fg=red> WHOOPS! </> 😳 \n");
            $this->line("<fg=red;options=bold>Class is invalid:</> {$name}");

            return;
        }

        if ($this->isReservedClassName($name)) {
            $this->line("<options=bold,reverse;fg=red> WHOOPS! </> 😳 \n");
            $this->line("<fg=red;options=bold>Class is reserved:</> {$name}");

            return;
        }

        $force = $this->option('force');
        $inline = $this->option('inline');
        $test = $this->option('test');

        $showWelcomeMessage = $this->isFirstTimeMakingAComponent();

        $class = $this->createClass($force, $inline);
        $view = $this->createView($force, $inline);

        if ($test) {
            $test = $this->createTest($force);
        }

        $this->refreshComponentAutodiscovery();

        if($class || $view) {
            $this->line("<options=bold,reverse;fg=green> COMPONENT CREATED </> 🤙\n");
            $class && $this->line("<options=bold;fg=green>CLASS:</> {$this->parser->relativeClassPath()}");

            if (! $inline) {
                $view && $this->line("<options=bold;fg=green>VIEW:</>  {$this->parser->relativeViewPath()}");
            }

            if ($test) {
                $test && $this->line("<options=bold;fg=green>TEST:</>  {$this->parser->relativeTestPath()}");
            }

            if ($showWelcomeMessage && ! app()->runningUnitTests()) {
                $this->writeWelcomeMessage();
            }
        }
    }

    private function getReservedName()
    {
        return [
            'parent',
            'component',
            'interface',
            '__halt_compiler',
            'abstract',
            'and',
            'array',
            'as',
            'break',
            'callable',
            'case',
            'catch',
            'class',
            'clone',
            'const',
            'continue',
            'declare',
            'default',
            'die',
            'do',
            'echo',
            'else',
            'elseif',
            'empty',
            'enddeclare',
            'endfor',
            'endforeach',
            'endif',
            'endswitch',
            'endwhile',
            'eval',
            'exit',
            'extends',
            'final',
            'finally',
            'fn',
            'for',
            'foreach',
            'function',
            'global',
            'goto',
            'if',
            'implements',
            'include',
            'include_once',
            'instanceof',
            'insteadof',
            'interface',
            'isset',
            'list',
            'namespace',
            'new',
            'or',
            'print',
            'private',
            'protected',
            'public',
            'require',
            'require_once',
            'return',
            'static',
            'switch',
            'throw',
            'trait',
            'try',
            'unset',
            'use',
            'var',
            'while',
            'xor',
            'yield',
        ];
    }
}
