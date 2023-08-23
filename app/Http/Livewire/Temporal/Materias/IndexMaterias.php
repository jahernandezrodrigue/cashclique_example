<?php

namespace App\Http\Livewire\Temporal\Materias;

use App\Http\Livewire\BaseComponent;
use App\Models\Temporal\Materia;
use DB, Log;

class IndexMaterias extends BaseComponent
{
    public $search;
    public $sort = 'id';
    public $direction = 'desc';
    public $cant = 10;
    
    public Materia $materia;

    /**
     * Listeners.
     */
    protected $listeners=['render' => 'render', 'deleteMateria' => 'delete'];

    public function render()
    {
        $query = Materia::query();
        $query->orderby($this->sort, $this->direction);
        $query->where('name', 'like', '%'. $this->search .'%');
        $materias = $query->paginate($this->cant);
        return view('livewire.temporal.materias.index-materias', compact('materias'));
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

    public function delete(Materia $materia) {
        DB::beginTransaction();
        try {
            $materia->delete();

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
