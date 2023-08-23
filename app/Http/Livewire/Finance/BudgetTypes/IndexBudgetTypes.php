<?php

namespace App\Http\Livewire\Finance\BudgetTypes;

use App\Http\Livewire\BaseComponent;
use App\Models\Finance\BudgetType;
use DB, Log;

class IndexBudgetTypes extends BaseComponent
{
    public $search;
    public $sort = 'id';
    public $direction = 'desc';
    public $cant = 10;
    
    public BudgetType $budgetType;

    /**
     * Listeners.
     */
    protected $listeners=['render' => 'render', 'deleteBudgetType' => 'delete'];

    public function render()
    {
        $query = BudgetType::query();
        $query->orderby($this->sort, $this->direction);
        $query->where('name', 'like', '%'. $this->search .'%');
        $budgetTypes = $query->paginate($this->cant);
        return view('livewire.finance.budget-types.index-budget-types', compact('budgetTypes'));
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

    public function delete(BudgetType $budgetType) {
        DB::beginTransaction();
        try {
            $budgetType->delete();

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
