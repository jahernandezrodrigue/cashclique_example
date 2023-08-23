<?php

namespace App\Http\Livewire\Finance\ExpenseTypes;

use App\Http\Livewire\BaseComponent;
use App\Models\Finance\ExpenseType;
use DB, Log;

class IndexExpenseTypes extends BaseComponent
{
    public $search;
    public $sort = 'id';
    public $direction = 'desc';
    public $cant = 10;
    
    public ExpenseType $expenseType;

    /**
     * Listeners.
     */
    protected $listeners=['render' => 'render', 'deleteExpenseType' => 'delete'];

    public function render()
    {
        $query = ExpenseType::query();
        $query->orderby($this->sort, $this->direction);
        $query->where('name', 'like', '%'. $this->search .'%');
        $expenseTypes = $query->paginate($this->cant);
        return view('livewire.finance.expense-types.index-expense-types', compact('expenseTypes'));
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

    public function delete(ExpenseType $expenseType) {
        DB::beginTransaction();
        try {
            $expenseType->delete();

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
