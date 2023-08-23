<?php

namespace App\Http\Livewire\Finance\Budgets;

use App\Http\Livewire\BaseComponent;
use App\Models\Finance\Budget;
use DB, Log;

class IndexBudgets extends BaseComponent
{
    public $search;
    public $sort = 'id';
    public $direction = 'desc';
    public $cant = 10;
    
    public Budget $budget;

    /**
     * Listeners.
     */
    protected $listeners=['render' => 'render', 'deleteBudget' => 'delete'];

    public function render()
    {
        $query = Budget::query();
        $query->orderby($this->sort, $this->direction);
        $query->where('name', 'like', '%'. $this->search .'%');
        $budgets = $query->paginate($this->cant);
        return view('livewire.finance.budgets.index-budgets', compact('budgets'));
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

    public function delete(Budget $budget) {
        DB::beginTransaction();
        try {
            $budget->delete();

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
