<?php

namespace App\Http\Livewire\Finance\Loans;

use App\Http\Livewire\BaseComponent;
use App\Models\Finance\Loan;
use DB, Log;

class IndexLoans extends BaseComponent
{
    public $search;
    public $sort = 'id';
    public $direction = 'desc';
    public $cant = 10;
    
    public Loan $loan;

    /**
     * Listeners.
     */
    protected $listeners=['render' => 'render', 'deleteLoan' => 'delete'];

    public function render()
    {
        $query = Loan::query();
        $query->orderby($this->sort, $this->direction);
        $query->where('name', 'like', '%'. $this->search .'%');
        $loans = $query->paginate($this->cant);
        return view('livewire.finance.loans.index-loans', compact('loans'));
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

    public function delete(Loan $loan) {
        DB::beginTransaction();
        try {
            $loan->delete();

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
