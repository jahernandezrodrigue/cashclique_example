<?php

namespace App\Http\Livewire\Temporal\Services;

use App\Http\Livewire\BaseComponent;
use App\Models\Temporal\Service;
use DB, Log;

class CreateService extends BaseComponent
{
    public $open = false;
    public $isEdit = false;

    public Service $service;

    /**
     * rules 
     */
    protected $rules = [
        'service.name' => 'required',
        'service.isActive' => 'boolean',
    ];

    /**
     * Listeners
     */
    protected $listeners=[
        'createService' => 'createService',
        'editService' => 'editService',
        'closeModal' => 'closeModal',
        'render' => 'render',
    ];

    /**
     * render
     */
    public function render()
    {
        return view('livewire.temporal.services.create-service');
    }

    /**
     * mount
     */
    public function mount()
    {
        // parent::mount();
        
        $this->service = new Service();
        $this->service->isActive = true;
    }

    /**
     * method open create
     */
    public function createService()
    {
        $this->isEdit = false;
        $this->open = true;
    }

    /**
     * method open edit
     */
    public function editService(Service $service)
    {
        $this->service = $service;
        $this->isEdit = true;
        $this->open = true;
    }

    /**
     * method close modal
     */
    public function closeModal()
    {
        $this->reset(['open', 'isEdit']);
        $this->service = new Service();
        $this->service->isActive = true;
    }

    /**
     * method submit
     */
    public function submit()
    {
        $this->validate();
        $this->isEdit ? $this->update():$this->store();
    }

    /**
     * method store
     */
    public function store()
    {
        DB::beginTransaction();
        try {
            // Create Service
            $service = $this->service;
            $service->save();

            // Commit Transaction
            DB::commit();

            $this->reset(['open', 'isEdit']);
            $this->service = new Service();
            $this->service->isActive = true;
            $this->emitTo('temporal.services.index-services', 'render');
            $this->emit('alert');

        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e->getMessage());
            $this->emit('error_alert');
        } 
    }

    /**
     * method update
     */
    public function update()
    {
        DB::beginTransaction();
        try {
            // Create Service
            $service = $this->service;
            $service->save();

            // Commit Transaction
            DB::commit();

            $this->reset(['open', 'isEdit']);
            $this->service = new Service();
            $this->service->isActive = true;
            $this->emitTo('temporal.services.index-services', 'render');
            $this->emit('alert');
            
        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e->getMessage());
            $this->emit('error_alert');
        } 
    }
}
