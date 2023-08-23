<?php

namespace App\Http\Livewire\Temporal\Tarjetas;

use App\Http\Livewire\BaseComponent;
use App\Models\Temporal\Tarjeta;
use DB, Log;

class CreateTarjeta extends BaseComponent
{
    public $open = false;
    public $isEdit = false;

    public Tarjeta $tarjeta;

    /**
     * rules 
     */
    protected $rules = [
        'tarjeta.name' => 'required',
        'tarjeta.isActive' => 'boolean',
    ];

    /**
     * Listeners
     */
    protected $listeners=[
        'createTarjeta' => 'createTarjeta',
        'editTarjeta' => 'editTarjeta',
        'closeModal' => 'closeModal',
        'render' => 'render',
    ];

    /**
     * render
     */
    public function render()
    {
        return view('livewire.temporal.tarjetas.create-tarjeta');
    }

    /**
     * mount
     */
    public function mount()
    {
        // parent::mount();
        
        $this->tarjeta = new Tarjeta();
        $this->tarjeta->isActive = true;
    }

    /**
     * method open create
     */
    public function createTarjeta()
    {
        $this->isEdit = false;
        $this->open = true;
    }

    /**
     * method open edit
     */
    public function editTarjeta(Tarjeta $tarjeta)
    {
        $this->tarjeta = $tarjeta;
        $this->isEdit = true;
        $this->open = true;
    }

    /**
     * method close modal
     */
    public function closeModal()
    {
        $this->reset(['open', 'isEdit']);
        $this->tarjeta = new Tarjeta();
        $this->tarjeta->isActive = true;
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
            // Create Tarjeta
            $tarjeta = $this->tarjeta;
            $tarjeta->save();

            // Commit Transaction
            DB::commit();

            $this->reset(['open', 'isEdit']);
            $this->tarjeta = new Tarjeta();
            $this->tarjeta->isActive = true;
            $this->emitTo('temporal.tarjetas.index-tarjetas', 'render');
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
            // Create Tarjeta
            $tarjeta = $this->tarjeta;
            $tarjeta->save();

            // Commit Transaction
            DB::commit();

            $this->reset(['open', 'isEdit']);
            $this->tarjeta = new Tarjeta();
            $this->tarjeta->isActive = true;
            $this->emitTo('temporal.tarjetas.index-tarjetas', 'render');
            $this->emit('alert');
            
        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e->getMessage());
            $this->emit('error_alert');
        } 
    }
}
