<?php

namespace App\Http\Livewire\Temporal\Sales;

use App\Http\Livewire\BaseComponent;
use App\Models\Temporal\Sale;
use DB, Log;

class IndexSales extends BaseComponent
{
    public $search;
    public $sort = 'id';
    public $direction = 'desc';
    public $cant = 10;
    
    public Sale $sale;

    /**
     * Listeners.
     */
    protected $listeners=['render' => 'render', 'deleteSale' => 'delete'];

    public function render()
    {
        $query = Sale::query();
        $query->orderby($this->sort, $this->direction);
        $query->where('name', 'like', '%'. $this->search .'%');
        $sales = $query->paginate($this->cant);
        return view('livewire.temporal.sales.index-sales', compact('sales'));
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

    public function delete(Sale $sale) {
        DB::beginTransaction();
        try {
            $sale->delete();

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
