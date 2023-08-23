<?php

namespace App\Http\Livewire\Temporal\Tipos;

use App\Http\Livewire\BaseComponent;
use App\Models\Temporal\Tipo;
use DB, Log;

class IndexTipos extends BaseComponent
{
    public $search;
    public $sort = 'id';
    public $direction = 'desc';
    public $cant = 10;
    
    public Tipo $tipo;

    /**
     * Listeners.
     */
    protected $listeners=['render' => 'render', 'deleteTipo' => 'delete'];

    public function render()
    {
        $query = Tipo::query();
        $query->orderby($this->sort, $this->direction);
        $query->where('name', 'like', '%'. $this->search .'%');
        $tipos = $query->paginate($this->cant);
        return view('livewire.temporal.tipos.index-tipos', compact('tipos'));
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

    public function delete(Tipo $tipo) {
        DB::beginTransaction();
        try {
            $tipo->delete();

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
