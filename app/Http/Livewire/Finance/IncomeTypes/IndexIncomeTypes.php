<?php

namespace App\Http\Livewire\Finance\IncomeTypes;

use App\Http\Livewire\BaseComponent;
use App\Models\Finance\IncomeType;
use DB, Log;

class IndexIncomeTypes extends BaseComponent
{
    public $search;
    public $sort = 'id';
    public $direction = 'desc';
    public $cant = 10;
    
    public IncomeType $incomeType;

    /**
     * Listeners.
     */
    protected $listeners=['render' => 'render', 'deleteIncomeType' => 'delete'];

    public function render()
    {
        $query = IncomeType::query();
        $query->orderby($this->sort, $this->direction);
        $query->where('name', 'like', '%'. $this->search .'%');
        $incomeTypes = $query->paginate($this->cant);
        return view('livewire.finance.income-types.index-income-types', compact('incomeTypes'));
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

    public function delete(IncomeType $incomeType) {
        DB::beginTransaction();
        try {
            $incomeType->delete();

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
