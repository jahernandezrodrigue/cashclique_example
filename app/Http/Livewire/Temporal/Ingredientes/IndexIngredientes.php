<?php

namespace App\Http\Livewire\Temporal\Ingredientes;

use App\Http\Livewire\BaseComponent;
use App\Models\Temporal\Ingrediente;
use DB, Log;

class IndexIngredientes extends BaseComponent
{
    public $search;
    public $sort = 'id';
    public $direction = 'desc';
    public $cant = 10;
    
    public Ingrediente $ingrediente;

    /**
     * Listeners.
     */
    protected $listeners=['render' => 'render', 'deleteIngrediente' => 'delete'];

    public function render()
    {
        $query = Ingrediente::query();
        $query->orderby($this->sort, $this->direction);
        $query->where('name', 'like', '%'. $this->search .'%');
        $ingredientes = $query->paginate($this->cant);
        return view('livewire.temporal.ingredientes.index-ingredientes', compact('ingredientes'));
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

    public function delete(Ingrediente $ingrediente) {
        DB::beginTransaction();
        try {
            $ingrediente->delete();

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
