<?php

use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Temporal\Productos\IndexProductos;
use App\Http\Livewire\Temporal\Marcas\IndexMarcas;
use App\Http\Livewire\Temporal\Ingredientes\IndexIngredientes;
use App\Http\Livewire\Temporal\Tipos\IndexTipos;
use App\Http\Livewire\Temporal\Pinturas\IndexPinturas;
use App\Http\Livewire\Temporal\Temporadas\IndexTemporadas;
use App\Http\Livewire\Temporal\Documentos\IndexDocumentos;
use App\Http\Livewire\Temporal\Cursos\IndexCursos;
use App\Http\Livewire\Temporal\Materias\IndexMaterias;
use App\Http\Livewire\Temporal\Alumnos\IndexAlumnos;

// vvs
use App\Http\Livewire\Temporal\Services\IndexServices;
use App\Http\Livewire\Temporal\Sales\IndexSales;
use App\Http\Livewire\Temporal\Customers\IndexCustomers;
use App\Http\Livewire\Temporal\Employees\IndexEmployees;
use App\Http\Livewire\Temporal\Appointments\IndexAppointments;
use App\Http\Livewire\Temporal\Generates\IndexGenerates;
use App\Http\Livewire\Temporal\Questions\IndexQuestions;

// finance
use App\Http\Livewire\Finance\BudgetTypes\IndexBudgetTypes;
use App\Http\Livewire\Finance\Budgets\IndexBudgets;
use App\Http\Livewire\Finance\DebtTypess\IndexDebtTypess;
use App\Http\Livewire\Finance\Debts\IndexDebts;
use App\Http\Livewire\Finance\ExpenseTypes\IndexExpenseTypes;
use App\Http\Livewire\Finance\Expenses\IndexExpenses;
use App\Http\Livewire\Finance\IncomeTypes\IndexIncomeTypes;
use App\Http\Livewire\Finance\Incomes\IndexIncomes;
use App\Http\Livewire\Finance\InvestmentTypes\IndexInvestmentTypes;
use App\Http\Livewire\Finance\Investments\IndexInvestments;
use App\Http\Livewire\Finance\LoanTypes\IndexLoanTypes;
use App\Http\Livewire\Finance\Loans\IndexLoans;


// controllers
use App\Http\Controllers\GenerateCrudController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/productos', IndexProductos::class)->name('productos');
    Route::get('/marcas', IndexMarcas::class)->name('marcas');
    Route::get('/ingredientes', IndexIngredientes::class)->name('ingredientes');
    Route::get('/tipos', IndexTipos::class)->name('tipos');
    Route::get('/pinturas', IndexPinturas::class)->name('pinturas');
    Route::get('/temporadas', IndexTemporadas::class)->name('temporadas');
    Route::get('/documentos', IndexDocumentos::class)->name('documentos');


    Route::get('/cursos', IndexCursos::class)->name('cursos');
    Route::get('/materias', IndexMaterias::class)->name('materias');
    Route::get('/alumnos', IndexAlumnos::class)->name('alumnos');

    // vvs
    Route::get('/services', IndexServices::class)->name('services');
    Route::get('/sales', IndexSales::class)->name('sales');
    Route::get('/customers', IndexCustomers::class)->name('customers');
    Route::get('/employees', IndexEmployees::class)->name('employees');
    Route::get('/appointments', IndexAppointments::class)->name('appointments');
    Route::get('/generates', IndexGenerates::class)->name('generates');
    Route::get('/questions', IndexQuestions::class)->name('questions');

    //finance
    Route::get('/budgettypes', IndexBudgetTypes::class)->name('budgettypes');
    Route::get('/budgets', IndexBudgets::class)->name('budgets');
    Route::get('/debttypess', IndexDebtTypess::class)->name('debttypess');
    Route::get('/debts', IndexDebts::class)->name('debts');
    Route::get('/expensetypes', IndexExpenseTypes::class)->name('expensetypes');
    Route::get('/expenses', IndexExpenses::class)->name('expenses');
    Route::get('/incometypes', IndexIncomeTypes::class)->name('incometypes');
    Route::get('/incomes', IndexIncomes::class)->name('incomes');
    Route::get('/investmenttypes', IndexInvestmentTypes::class)->name('investmenttypes');
    Route::get('/investments', IndexInvestments::class)->name('investments');
    Route::get('/loantypes', IndexLoanTypes::class)->name('loantypes');
    Route::get('/loans', IndexLoans::class)->name('loans');

    Route::get('generate', [GenerateCrudController::class, 'index'])->name('generate');
});
