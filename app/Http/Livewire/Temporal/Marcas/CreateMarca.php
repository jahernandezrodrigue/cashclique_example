<?php

namespace App\Http\Livewire\Temporal\Marcas;

use App\Http\Livewire\BaseComponent;
use App\Models\Temporal\Marca;
use DB, Log;

class CreateMarca extends BaseComponent
{
    public $open = false;
    public $isEdit = false;

    public Marca $marca;

    /**
     * rules 
     */
    protected $rules = [
        'marca.name' => 'required',
        'marca.isActive' => 'boolean',
    ];

    /**
     * Listeners
     */
    protected $listeners=[
        'createMarca' => 'createMarca',
        'editMarca' => 'editMarca',
        'closeModal' => 'closeModal',
        'render' => 'render',
    ];

    /**
     * render
     */
    public function render()
    {
        return view('livewire.temporal.marcas.create-marca');
    }

    /**
     * mount
     */
    public function mount()
    {
        // parent::mount();
        
        $this->marca = new Marca();
        $this->marca->isActive = true;
    }

    /**
     * method open create
     */
    public function createMarca()
    {
        $this->isEdit = false;
        $this->open = true;
    }

    /**
     * method open edit
     */
    public function editMarca(Marca $marca)
    {
        $this->marca = $marca;
        $this->isEdit = true;
        $this->open = true;
    }

    /**
     * method close modal
     */
    public function closeModal()
    {
        $this->reset(['open', 'isEdit']);
        $this->marca = new Marca();
        $this->marca->isActive = true;
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
            // Create Marca
            $marca = $this->marca;
            $marca->save();

            // Commit Transaction
            DB::commit();

            $this->reset(['open', 'isEdit']);
            $this->marca = new Marca();
            $this->marca->isActive = true;
            $this->emitTo('temporal.marcas.index-marcas', 'render');
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
            // Create Marca
            $marca = $this->marca;
            $marca->save();

            // Commit Transaction
            DB::commit();

            $this->reset(['open', 'isEdit']);
            $this->marca = new Marca();
            $this->marca->isActive = true;
            $this->emitTo('temporal.marcas.index-marcas', 'render');
            $this->emit('alert');
            
        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e->getMessage());
            $this->emit('error_alert');
        } 
    }
}
