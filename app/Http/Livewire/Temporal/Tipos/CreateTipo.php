<?php

namespace App\Http\Livewire\Temporal\Tipos;

use App\Http\Livewire\BaseComponent;
use App\Models\Temporal\Tipo;
use DB, Log;

class CreateTipo extends BaseComponent
{
    public $open = false;
    public $isEdit = false;

    public Tipo $tipo;

    /**
     * rules 
     */
    protected $rules = [
        'tipo.name' => 'required',
        'tipo.isActive' => 'boolean',
    ];

    /**
     * Listeners
     */
    protected $listeners=[
        'createTipo' => 'createTipo',
        'editTipo' => 'editTipo',
        'closeModal' => 'closeModal',
        'render' => 'render',
    ];

    /**
     * render
     */
    public function render()
    {
        return view('livewire.temporal.tipos.create-tipo');
    }

    /**
     * mount
     */
    public function mount()
    {
        // parent::mount();
        
        $this->tipo = new Tipo();
        $this->tipo->isActive = true;
    }

    /**
     * method open create
     */
    public function createTipo()
    {
        $this->isEdit = false;
        $this->open = true;
    }

    /**
     * method open edit
     */
    public function editTipo(Tipo $tipo)
    {
        $this->tipo = $tipo;
        $this->isEdit = true;
        $this->open = true;
    }

    /**
     * method close modal
     */
    public function closeModal()
    {
        $this->reset(['open', 'isEdit']);
        $this->tipo = new Tipo();
        $this->tipo->isActive = true;
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
            // Create Tipo
            $tipo = $this->tipo;
            $tipo->save();

            // Commit Transaction
            DB::commit();

            $this->reset(['open', 'isEdit']);
            $this->tipo = new Tipo();
            $this->tipo->isActive = true;
            $this->emitTo('temporal.tipos.index-tipos', 'render');
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
            // Create Tipo
            $tipo = $this->tipo;
            $tipo->save();

            // Commit Transaction
            DB::commit();

            $this->reset(['open', 'isEdit']);
            $this->tipo = new Tipo();
            $this->tipo->isActive = true;
            $this->emitTo('temporal.tipos.index-tipos', 'render');
            $this->emit('alert');
            
        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e->getMessage());
            $this->emit('error_alert');
        } 
    }
}
