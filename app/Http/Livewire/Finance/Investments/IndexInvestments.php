<?php

namespace App\Http\Livewire\Finance\Investments;

use App\Http\Livewire\BaseComponent;
use App\Models\Finance\Investment;
use DB, Log;

class IndexInvestments extends BaseComponent
{
    public $search;
    public $sort = 'id';
    public $direction = 'desc';
    public $cant = 10;
    
    public Investment $investment;

    /**
     * Listeners.
     */
    protected $listeners=['render' => 'render', 'deleteInvestment' => 'delete'];

    public function render()
    {
        $query = Investment::query();
        $query->orderby($this->sort, $this->direction);
        $query->where('name', 'like', '%'. $this->search .'%');
        $investments = $query->paginate($this->cant);
        return view('livewire.finance.investments.index-investments', compact('investments'));
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

    public function delete(Investment $investment) {
        DB::beginTransaction();
        try {
            $investment->delete();

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
