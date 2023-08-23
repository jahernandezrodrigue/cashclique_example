<?php

namespace App\Http\Livewire\Temporal\Tarjetas;

use App\Http\Livewire\BaseComponent;
use App\Models\Temporal\Tarjeta;
use DB, Log;

class IndexTarjetas extends BaseComponent
{
    public $search;
    public $sort = 'id';
    public $direction = 'desc';
    public $cant = 10;
    
    public Tarjeta $tarjeta;

    /**
     * Listeners.
     */
    protected $listeners=['render' => 'render', 'deleteTarjeta' => 'delete'];

    public function render()
    {
        $query = Tarjeta::query();
        $query->orderby($this->sort, $this->direction);
        $query->where('name', 'like', '%'. $this->search .'%');
        $tarjetas = $query->paginate($this->cant);
        return view('livewire.temporal.tarjetas.index-tarjetas', compact('tarjetas'));
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

    public function delete(Tarjeta $tarjeta) {
        DB::beginTransaction();
        try {
            $tarjeta->delete();

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
