<?php

namespace App\Http\Livewire\Temporal\Ingredientes;

use App\Http\Livewire\BaseComponent;
use App\Models\Temporal\Ingrediente;
use DB, Log;

class CreateIngrediente extends BaseComponent
{
    public $open = false;
    public $isEdit = false;

    public Ingrediente $ingrediente;

    /**
     * rules 
     */
    protected $rules = [
        'ingrediente.name' => 'required',
        'ingrediente.isActive' => 'boolean',
    ];

    /**
     * Listeners
     */
    protected $listeners=[
        'createIngrediente' => 'createIngrediente',
        'editIngrediente' => 'editIngrediente',
        'closeModal' => 'closeModal',
        'render' => 'render',
    ];

    /**
     * render
     */
    public function render()
    {
        return view('livewire.temporal.ingredientes.create-ingrediente');
    }

    /**
     * mount
     */
    public function mount()
    {
        // parent::mount();
        
        $this->ingrediente = new Ingrediente();
        $this->ingrediente->isActive = true;
    }

    /**
     * method open create
     */
    public function createIngrediente()
    {
        $this->isEdit = false;
        $this->open = true;
    }

    /**
     * method open edit
     */
    public function editIngrediente(Ingrediente $ingrediente)
    {
        $this->ingrediente = $ingrediente;
        $this->isEdit = true;
        $this->open = true;
    }

    /**
     * method close modal
     */
    public function closeModal()
    {
        $this->reset(['open', 'isEdit']);
        $this->ingrediente = new Ingrediente();
        $this->ingrediente->isActive = true;
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
            // Create Ingrediente
            $ingrediente = $this->ingrediente;
            $ingrediente->save();

            // Commit Transaction
            DB::commit();

            $this->reset(['open', 'isEdit']);
            $this->ingrediente = new Ingrediente();
            $this->ingrediente->isActive = true;
            $this->emitTo('temporal.ingredientes.index-ingredientes', 'render');
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
            // Create Ingrediente
            $ingrediente = $this->ingrediente;
            $ingrediente->save();

            // Commit Transaction
            DB::commit();

            $this->reset(['open', 'isEdit']);
            $this->ingrediente = new Ingrediente();
            $this->ingrediente->isActive = true;
            $this->emitTo('temporal.ingredientes.index-ingredientes', 'render');
            $this->emit('alert');
            
        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e->getMessage());
            $this->emit('error_alert');
        } 
    }
}
