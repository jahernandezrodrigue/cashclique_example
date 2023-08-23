<?php

namespace App\Http\Livewire\Temporal\Services;

use App\Http\Livewire\BaseComponent;
use App\Models\Temporal\Service;
use DB, Log;

class IndexServices extends BaseComponent
{
    public $search;
    public $sort = 'id';
    public $direction = 'desc';
    public $cant = 10;
    
    public Service $service;

    /**
     * Listeners.
     */
    protected $listeners=['render' => 'render', 'deleteService' => 'delete'];

    public function render()
    {
        $query = Service::query();
        $query->orderby($this->sort, $this->direction);
        $query->where('name', 'like', '%'. $this->search .'%');
        $services = $query->paginate($this->cant);
        return view('livewire.temporal.services.index-services', compact('services'));
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

    public function delete(Service $service) {
        DB::beginTransaction();
        try {
            $service->delete();

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
