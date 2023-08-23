<?php

namespace App\Http\Livewire\Finance\Expenses;

use App\Http\Livewire\BaseComponent;
use App\Models\Finance\Expense;
use DB, Log;

class IndexExpenses extends BaseComponent
{
    public $search;
    public $sort = 'id';
    public $direction = 'desc';
    public $cant = 10;
    
    public Expense $expense;

    /**
     * Listeners.
     */
    protected $listeners=['render' => 'render', 'deleteExpense' => 'delete'];

    public function render()
    {
        $query = Expense::query();
        $query->orderby($this->sort, $this->direction);
        $query->where('name', 'like', '%'. $this->search .'%');
        $expenses = $query->paginate($this->cant);
        return view('livewire.finance.expenses.index-expenses', compact('expenses'));
    }

    public function order($sort)
    {
        if ($this->sort==$sort)
        {
            if ($this->direction=='desc'){
                $this->direction='asc';
            }
            else{
                $this->direction='desc';
            }

        } else {
            $this->sort=$sort;
            $this->direction=='asc';
        }
    }

    public function delete(Expense $expense) {
        DB::beginTransaction();
        try {
            $expense->delete();

            // Commit Transaction
            DB::commit();

            $this->emit('alert');
        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e->getMessage());
            $this->emit('error_alert');
        }
    }
}
