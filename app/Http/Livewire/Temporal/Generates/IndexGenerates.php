<?php

namespace App\Http\Livewire\Temporal\Generates;

use App\Http\Livewire\BaseComponent;
use App\Models\Temporal\Generate;
use DB, Log;

class IndexGenerates extends BaseComponent
{
    public $search;
    public $sort = 'id';
    public $direction = 'desc';
    public $cant = 10;
    
    public Generate $generate;

    /**
     * Listeners.
     */
    protected $listeners=['render' => 'render', 'deleteGenerate' => 'delete'];

    public function render()
    {
        $query = Generate::query();
        $query->orderby($this->sort, $this->direction);
        $query->where('name', 'like', '%'. $this->search .'%');
        $generates = $query->paginate($this->cant);
        return view('livewire.temporal.generates.index-generates', compact('generates'));
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

    public function delete(Generate $generate) {
        DB::beginTransaction();
        try {
            $generate->delete();

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
