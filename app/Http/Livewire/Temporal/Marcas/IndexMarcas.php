<?php

namespace App\Http\Livewire\Temporal\Marcas;

use App\Http\Livewire\BaseComponent;
use App\Models\Temporal\Marca;
use DB, Log;

class IndexMarcas extends BaseComponent
{
    public $search;
    public $sort = 'id';
    public $direction = 'desc';
    public $cant = 10;
    
    public Marca $marca;

    /**
     * Listeners.
     */
    protected $listeners=['render' => 'render', 'deleteMarca' => 'delete'];

    public function render()
    {
        $query = Marca::query();
        $query->orderby($this->sort, $this->direction);
        $query->where('name', 'like', '%'. $this->search .'%');
        $marcas = $query->paginate($this->cant);
        return view('livewire.temporal.marcas.index-marcas', compact('marcas'));
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

    public function delete(Marca $marca) {
        DB::beginTransaction();
        try {
            $marca->delete();

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
