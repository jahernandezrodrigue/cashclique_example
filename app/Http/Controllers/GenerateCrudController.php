<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use App\Clasess\GenerateCrud;

class GenerateCrudController extends Controller
{
    public function index(Request $request)
    {
        $fields = [
            'producto_referencia',
            'producto_serie_texto',
            'producto_nombreÍndice',
            'producto_activo',
            'producto_serie',
            'producto_modeloÍndice',
            'producto_codigo',
            'producto_costo',
            'producto_precio',
            'producto_contador',
            'producto_numero_parte',
        ];

        $generateCrud = new GenerateCrud($fields);
        $generateCrud->main();

        dd('ffff');

        $message = '';
        $messageImports = '';
        $messageRoutes = '';

        $modules = [
            // 'BudgetType',
            // 'Budget',
            // 'DebtTypes',
            // 'Debt',
            // 'ExpenseType',
            // 'Expense',
            // 'IncomeType',
            // 'Income',
            // 'InvestmentType',
            // 'Investment',
            // 'LoanType',
            // 'Loan',
        ];

       /*
        
       */

       

        // if(!$request->filled('class')) {
        //     dd( "configure modulo en el codigo  ?class=Class");
        //     return;
        // }

        // $class = $request->class;

        
        try {
            foreach ($modules as $item) {
                $class = $item;
                

            
                $pluralclass = $class.'s';
                $pluralclassminuscula = strtolower($pluralclass);

                // crear modelo y migracion
                $exitCode1 = Artisan::call("make:model", [
                    "name" => "Finance/$class",
                    "-m" => true,  // Crear migración
                ]);

                // crear componente index
                $exitCode2 = Artisan::call("make:jex", [
                    "name" => "Finance/$pluralclass/$class",
                    "--stub" => "jex/index"
                ]);

                // crear componente create
                $exitCode3 = Artisan::call("make:jex", [
                    "name" => "Finance/$pluralclass/$class",
                    "--stub" => "jex/create"
                ]);

                // ejecutar migracion
                $exitCode4 = Artisan::call("migrate");

                if (true ) {
                $message = $message . '<br>'. $this->message($class, $pluralclass, $pluralclassminuscula);
                $messageImports = $messageImports . ''. $this->messageImports($class, $pluralclass, $pluralclassminuscula);
                $messageRoutes = $messageRoutes . ''. $this->messageRoutes($class, $pluralclass, $pluralclassminuscula);
                } else {
                    return "Error al ejecutar el comando";
                }
            }

            echo $message;
            echo '<br> imports';
            echo $messageImports;
            echo '<br>routes';
            echo $messageRoutes;
        } catch (\Exception $e) {
            return "Ocurrió una excepción: " . $e->getMessage();
        }
    }


    public function message($class, $pluralclass, $pluralclassminuscula)
    {
        $html = "
                <!DOCTYPE html>
                <html>
                <head>
                    <title>Resultado del Comando</title>
                    <style>
                        body {
                            font-family: Arial, sans-serif;
                            margin: 20px;
                        }
                        h2 {
                            color: #333;
                        }
                        hr {
                            margin-top: 10px;
                            border: none;
                            border-top: 1px solid #ccc;
                        }
                        pre {
                            background-color: #f7f7f7;
                            padding: 10px;
                            border-radius: 5px;
                            font-size: 14px;
                        }
                        code {
                            color: #333;
                        }
                        strong {
                            color: #007bff;
                        }
                    </style>
                </head>
                <body>
                    <h2>Hecho: Comando ejecutado exitosamente</h2>
                    <hr>
                
                    <p>Además, para usar tu nuevo modelo <code>{$class}</code>, puedes agregar la siguiente línea en tu archivo de rutas (<code>routes/web.php</code>):</p>
                  
                    <pre><code>use App\Http\Livewire\Finance\\{$pluralclass}\\Index{$pluralclass};</code></pre>
                    <pre><code>Route::get('/{$pluralclassminuscula}', Index{$pluralclass}::class)->name('{$pluralclassminuscula}');</code></pre>
                    

                    <p>Ahora podrás acceder a la lista de <strong>{$pluralclass}</strong> visitando <code>/{$pluralclassminuscula}</code> en tu navegador.</p>
                
                    <p>¡Bien hecho!</p>
                </body>
                </html>
                ";
                
                return $html;
    }

    public function messageImports($class, $pluralclass, $pluralclassminuscula)
    {
        $html = "
                <!DOCTYPE html>
                <html>
                <head>
                    <title>Resultado del Comando</title>
                    <style>
                        body {
                            font-family: Arial, sans-serif;
                            margin: 20px;
                        }
                        h2 {
                            color: #333;
                        }
                        hr {
                            margin-top: 10px;
                            border: none;
                            border-top: 1px solid #ccc;
                        }
                        pre {
                            background-color: #f7f7f7;
                            padding: 10px;
                            border-radius: 5px;
                            font-size: 14px;
                        }
                        code {
                            color: #333;
                        }
                        strong {
                            color: #007bff;
                        }
                    </style>
                </head>
                <body>
                    <pre><code>use App\Http\Livewire\Finance\\{$pluralclass}\\Index{$pluralclass};</code></pre>
                </body>
                </html>
                ";
                
                return $html;
    }

    public function messageRoutes($class, $pluralclass, $pluralclassminuscula)
    {
        $html = "
                <!DOCTYPE html>
                <html>
                <head>
                    <title>Resultado del Comando</title>
                    <style>
                        body {
                            font-family: Arial, sans-serif;
                            margin: 20px;
                        }
                        h2 {
                            color: #333;
                        }
                        hr {
                            margin-top: 10px;
                            border: none;
                            border-top: 1px solid #ccc;
                        }
                        pre {
                            background-color: #f7f7f7;
                            padding: 10px;
                            border-radius: 5px;
                            font-size: 14px;
                        }
                        code {
                            color: #333;
                        }
                        strong {
                            color: #007bff;
                        }
                    </style>
                </head>
                <body>
                    <pre><code>Route::get('/{$pluralclassminuscula}', Index{$pluralclass}::class)->name('{$pluralclassminuscula}');</code></pre>
                </body>
                </html>
                ";
                
                return $html;
    }
}
