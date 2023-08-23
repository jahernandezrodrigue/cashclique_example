<?php

namespace App\Http\Livewire\Temporal\Cursos;

use App\Http\Livewire\BaseComponent;
use App\Models\Temporal\Curso;
use DB, Log;

class IndexCursos extends BaseComponent
{
    public $search;
    public $sort = 'id';
    public $direction = 'desc';
    public $cant = 10;
    
    public Curso $curso;

    /**
     * Listeners.
     */
    protected $listeners=['render' => 'render', 'deleteCurso' => 'delete'];

    public function render()
    {
        $query = Curso::query();
        $query->orderby($this->sort, $this->direction);
        $query->where('name', 'like', '%'. $this->search .'%');
        $cursos = $query->paginate($this->cant);
        return view('livewire.temporal.cursos.index-cursos', compact('cursos'));
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

    public function delete(Curso $curso) {
        DB::beginTransaction();
        try {
            $curso->delete();

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
