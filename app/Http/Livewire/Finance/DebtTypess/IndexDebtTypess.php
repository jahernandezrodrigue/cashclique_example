<?php

namespace App\Http\Livewire\Finance\DebtTypess;

use App\Http\Livewire\BaseComponent;
use App\Models\Finance\DebtTypes;
use DB, Log;

class IndexDebtTypess extends BaseComponent
{
    public $search;
    public $sort = 'id';
    public $direction = 'desc';
    public $cant = 10;
    
    public DebtTypes $debtTypes;

    /**
     * Listeners.
     */
    protected $listeners=['render' => 'render', 'deleteDebtTypes' => 'delete'];

    public function render()
    {
        $query = DebtTypes::query();
        $query->orderby($this->sort, $this->direction);
        $query->where('name', 'like', '%'. $this->search .'%');
        $debtTypess = $query->paginate($this->cant);
        return view('livewire.finance.debt-typess.index-debt-typess', compact('debtTypess'));
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

    public function delete(DebtTypes $debtTypes) {
        DB::beginTransaction();
        try {
            $debtTypes->delete();

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
