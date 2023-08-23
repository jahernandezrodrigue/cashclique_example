<?php

namespace App\Http\Livewire\Temporal\Pinturas;

use App\Http\Livewire\BaseComponent;
use App\Models\Temporal\Pintura;
use DB, Log;

class CreatePintura extends BaseComponent
{
    public $open = false;
    public $isEdit = false;

    public Pintura $pintura;

    /**
     * rules 
     */
    protected $rules = [
        'pintura.name' => 'required',
        'pintura.isActive' => 'boolean',
    ];

    /**
     * Listeners
     */
    protected $listeners=[
        'createPintura' => 'createPintura',
        'editPintura' => 'editPintura',
        'closeModal' => 'closeModal',
        'render' => 'render',
    ];

    /**
     * render
     */
    public function render()
    {
        return view('livewire.temporal.pinturas.create-pintura');
    }

    /**
     * mount
     */
    public function mount()
    {
        // parent::mount();
        
        $this->pintura = new Pintura();
        $this->pintura->isActive = true;
    }

    /**
     * method open create
     */
    public function createPintura()
    {
        $this->isEdit = false;
        $this->open = true;
    }

    /**
     * method open edit
     */
    public function editPintura(Pintura $pintura)
    {
        $this->pintura = $pintura;
        $this->isEdit = true;
        $this->open = true;
    }

    /**
     * method close modal
     */
    public function closeModal()
    {
        $this->reset(['open', 'isEdit']);
        $this->pintura = new Pintura();
        $this->pintura->isActive = true;
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
            // Create Pintura
            $pintura = $this->pintura;
            $pintura->save();

            // Commit Transaction
            DB::commit();

            $this->reset(['open', 'isEdit']);
            $this->pintura = new Pintura();
            $this->pintura->isActive = true;
            $this->emitTo('temporal.pinturas.index-pinturas', 'render');
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
            // Create Pintura
            $pintura = $this->pintura;
            $pintura->save();

            // Commit Transaction
            DB::commit();

            $this->reset(['open', 'isEdit']);
            $this->pintura = new Pintura();
            $this->pintura->isActive = true;
            $this->emitTo('temporal.pinturas.index-pinturas', 'render');
            $this->emit('alert');
            
        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e->getMessage());
            $this->emit('error_alert');
        } 
    }
}
