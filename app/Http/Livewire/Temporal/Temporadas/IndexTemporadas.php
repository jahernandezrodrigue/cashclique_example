<?php

namespace App\Http\Livewire\Temporal\Temporadas;

use App\Http\Livewire\BaseComponent;
use App\Models\Temporal\Temporada;
use DB, Log;

class IndexTemporadas extends BaseComponent
{
    public $search;
    public $sort = 'id';
    public $direction = 'desc';
    public $cant = 10;
    
    public Temporada $temporada;

    /**
     * Listeners.
     */
    protected $listeners=['render' => 'render', 'deleteTemporada' => 'delete'];

    public function render()
    {
        $query = Temporada::query();
        $query->orderby($this->sort, $this->direction);
        $query->where('name', 'like', '%'. $this->search .'%');
        $temporadas = $query->paginate($this->cant);
        return view('livewire.temporal.temporadas.index-temporadas', compact('temporadas'));
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

    public function delete(Temporada $temporada) {
        DB::beginTransaction();
        try {
            $temporada->delete();

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
