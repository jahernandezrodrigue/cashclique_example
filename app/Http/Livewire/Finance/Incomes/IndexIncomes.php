<?php

namespace App\Http\Livewire\Finance\Incomes;

use App\Http\Livewire\BaseComponent;
use App\Models\Finance\Income;
use DB, Log;

class IndexIncomes extends BaseComponent
{
    public $search;
    public $sort = 'id';
    public $direction = 'desc';
    public $cant = 10;
    
    public Income $income;

    /**
     * Listeners.
     */
    protected $listeners=['render' => 'render', 'deleteIncome' => 'delete'];

    public function render()
    {
        $query = Income::query();
        $query->orderby($this->sort, $this->direction);
        $query->where('name', 'like', '%'. $this->search .'%');
        $incomes = $query->paginate($this->cant);
        return view('livewire.finance.incomes.index-incomes', compact('incomes'));
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

    public function delete(Income $income) {
        DB::beginTransaction();
        try {
            $income->delete();

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
