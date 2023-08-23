<?php

namespace App\Http\Livewire\Finance\InvestmentTypes;

use App\Http\Livewire\BaseComponent;
use App\Models\Finance\InvestmentType;
use DB, Log;

class IndexInvestmentTypes extends BaseComponent
{
    public $search;
    public $sort = 'id';
    public $direction = 'desc';
    public $cant = 10;
    
    public InvestmentType $investmentType;

    /**
     * Listeners.
     */
    protected $listeners=['render' => 'render', 'deleteInvestmentType' => 'delete'];

    public function render()
    {
        $query = InvestmentType::query();
        $query->orderby($this->sort, $this->direction);
        $query->where('name', 'like', '%'. $this->search .'%');
        $investmentTypes = $query->paginate($this->cant);
        return view('livewire.finance.investment-types.index-investment-types', compact('investmentTypes'));
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

    public function delete(InvestmentType $investmentType) {
        DB::beginTransaction();
        try {
            $investmentType->delete();

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
