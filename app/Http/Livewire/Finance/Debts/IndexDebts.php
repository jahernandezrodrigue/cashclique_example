<?php

namespace App\Http\Livewire\Finance\Debts;

use App\Http\Livewire\BaseComponent;
use App\Models\Finance\Debt;
use DB, Log;

class IndexDebts extends BaseComponent
{
    public $search;
    public $sort = 'id';
    public $direction = 'desc';
    public $cant = 10;
    
    public Debt $debt;

    /**
     * Listeners.
     */
    protected $listeners=['render' => 'render', 'deleteDebt' => 'delete'];

    public function render()
    {
        $query = Debt::query();
        $query->orderby($this->sort, $this->direction);
        $query->where('name', 'like', '%'. $this->search .'%');
        $debts = $query->paginate($this->cant);
        return view('livewire.finance.debts.index-debts', compact('debts'));
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

    public function delete(Debt $debt) {
        DB::beginTransaction();
        try {
            $debt->delete();

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
