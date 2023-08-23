<?php

namespace App\Http\Livewire\Temporal\Pinturas;

use App\Http\Livewire\BaseComponent;
use App\Models\Temporal\Pintura;
use DB, Log;

class IndexPinturas extends BaseComponent
{
    public $search;
    public $sort = 'id';
    public $direction = 'desc';
    public $cant = 10;
    
    public Pintura $pintura;

    /**
     * Listeners.
     */
    protected $listeners=['render' => 'render', 'deletePintura' => 'delete'];

    public function render()
    {
        $query = Pintura::query();
        $query->orderby($this->sort, $this->direction);
        $query->where('name', 'like', '%'. $this->search .'%');
        $pinturas = $query->paginate($this->cant);
        return view('livewire.temporal.pinturas.index-pinturas', compact('pinturas'));
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

    public function delete(Pintura $pintura) {
        DB::beginTransaction();
        try {
            $pintura->delete();

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
