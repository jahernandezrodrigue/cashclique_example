<?php

namespace App\Http\Livewire\Temporal\Documentos;

use App\Http\Livewire\BaseComponent;
use App\Models\Temporal\Documento;
use DB, Log;

class CreateDocumento extends BaseComponent
{
    public $open = false;
    public $isEdit = false;

    public Documento $documento;

    /**
     * rules 
     */
    protected $rules = [
        'documento.name' => 'required',
        'documento.isActive' => 'boolean',
    ];

    /**
     * Listeners
     */
    protected $listeners=[
        'createDocumento' => 'createDocumento',
        'editDocumento' => 'editDocumento',
        'closeModal' => 'closeModal',
        'render' => 'render',
    ];

    /**
     * render
     */
    public function render()
    {
        return view('livewire.temporal.documentos.create-documento');
    }

    /**
     * mount
     */
    public function mount()
    {
        // parent::mount();
        
        $this->documento = new Documento();
        $this->documento->isActive = true;
    }

    /**
     * method open create
     */
    public function createDocumento()
    {
        $this->isEdit = false;
        $this->open = true;
    }

    /**
     * method open edit
     */
    public function editDocumento(Documento $documento)
    {
        $this->documento = $documento;
        $this->isEdit = true;
        $this->open = true;
    }

    /**
     * method close modal
     */
    public function closeModal()
    {
        $this->reset(['open', 'isEdit']);
        $this->documento = new Documento();
        $this->documento->isActive = true;
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
            // Create Documento
            $documento = $this->documento;
            $documento->save();

            // Commit Transaction
            DB::commit();

            $this->reset(['open', 'isEdit']);
            $this->documento = new Documento();
            $this->documento->isActive = true;
            $this->emitTo('temporal.documentos.index-documentos', 'render');
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
            // Create Documento
            $documento = $this->documento;
            $documento->save();

            // Commit Transaction
            DB::commit();

            $this->reset(['open', 'isEdit']);
            $this->documento = new Documento();
            $this->documento->isActive = true;
            $this->emitTo('temporal.documentos.index-documentos', 'render');
            $this->emit('alert');
            
        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e->getMessage());
            $this->emit('error_alert');
        } 
    }
}
