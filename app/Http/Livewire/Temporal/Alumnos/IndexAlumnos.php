<?php

namespace App\Http\Livewire\Temporal\Alumnos;

use App\Http\Livewire\BaseComponent;
use App\Models\Temporal\Alumno;
use DB, Log;

class IndexAlumnos extends BaseComponent
{
    public $search;
    public $sort = 'id';
    public $direction = 'desc';
    public $cant = 10;
    
    public Alumno $alumno;

    /**
     * Listeners.
     */
    protected $listeners=['render' => 'render', 'deleteAlumno' => 'delete'];

    public function render()
    {
        $query = Alumno::query();
        $query->orderby($this->sort, $this->direction);
        $query->where('name', 'like', '%'. $this->search .'%');
        $alumnos = $query->paginate($this->cant);
        return view('livewire.temporal.alumnos.index-alumnos', compact('alumnos'));
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

    public function delete(Alumno $alumno) {
        DB::beginTransaction();
        try {
            $alumno->delete();

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
