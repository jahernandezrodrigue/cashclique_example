<?php

namespace App\Http\Livewire\Temporal\Documentos;

use App\Http\Livewire\BaseComponent;
use App\Models\Temporal\Documento;
use DB, Log;

class IndexDocumentos extends BaseComponent
{
    public $search;
    public $sort = 'id';
    public $direction = 'desc';
    public $cant = 10;
    
    public Documento $documento;

    /**
     * Listeners.
     */
    protected $listeners=['render' => 'render', 'deleteDocumento' => 'delete'];

    public function render()
    {
        $query = Documento::query();
        $query->orderby($this->sort, $this->direction);
        $query->where('name', 'like', '%'. $this->search .'%');
        $documentos = $query->paginate($this->cant);
        return view('livewire.temporal.documentos.index-documentos', compact('documentos'));
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

    public function delete(Documento $documento) {
        DB::beginTransaction();
        try {
            $documento->delete();

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
