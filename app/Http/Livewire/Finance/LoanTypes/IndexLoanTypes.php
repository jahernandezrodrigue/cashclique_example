<?php

namespace App\Http\Livewire\Finance\LoanTypes;

use App\Http\Livewire\BaseComponent;
use App\Models\Finance\LoanType;
use DB, Log;

class IndexLoanTypes extends BaseComponent
{
    public $search;
    public $sort = 'id';
    public $direction = 'desc';
    public $cant = 10;
    
    public LoanType $loanType;

    /**
     * Listeners.
     */
    protected $listeners=['render' => 'render', 'deleteLoanType' => 'delete'];

    public function render()
    {
        $query = LoanType::query();
        $query->orderby($this->sort, $this->direction);
        $query->where('name', 'like', '%'. $this->search .'%');
        $loanTypes = $query->paginate($this->cant);
        return view('livewire.finance.loan-types.index-loan-types', compact('loanTypes'));
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

    public function delete(LoanType $loanType) {
        DB::beginTransaction();
        try {
            $loanType->delete();

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
