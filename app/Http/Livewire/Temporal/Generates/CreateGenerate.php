<?php

namespace App\Http\Livewire\Temporal\Generates;

use App\Http\Livewire\BaseComponent;
use App\Models\Temporal\Generate;
use App\Clasess\GenerateCrud;
use DB, Log;

class CreateGenerate extends BaseComponent
{
    public $open = false;
    public $isEdit = false;

    public Generate $generate;

    /**
     * rules 
     */
    protected $rules = [
        'generate.name' => 'required',
        'generate.folder' => 'required',
        'generate.isActive' => 'boolean',
    ];

    /**
     * Listeners
     */
    protected $listeners=[
        'createGenerate' => 'createGenerate',
        'editGenerate' => 'editGenerate',
        'closeModal' => 'closeModal',
        'render' => 'render',
    ];

    /**
     * render
     */
    public function render()
    {
        return view('livewire.temporal.generates.create-generate');
    }

    /**
     * mount
     */
    public function mount()
    {
        // parent::mount();
        
        $this->generate = new Generate();
        $this->generate->isActive = true;
    }

    /**
     * method open create
     */
    public function createGenerate()
    {
        $this->isEdit = false;
        $this->open = true;
    }

    /**
     * method open edit
     */
    public function editGenerate(Generate $generate)
    {
        $this->generate = $generate;
        $this->isEdit = true;
        $this->open = true;
    }

    /**
     * method close modal
     */
    public function closeModal()
    {
        $this->reset(['open', 'isEdit']);
        $this->generate = new Generate();
        $this->generate->isActive = true;
    }

    /**
     * method submit
     */
    public function submit()
    {
        $this->validate();
        $this->generatemod();
        // $this->isEdit ? $this->update():$this->store();
    }

    /**
     * method generatemod
     */
    public function generatemod()
    {
        $folder = $this->generate['folder'];
        $class = $this->generate['name'];

        $GenerateCrud = new GenerateCrud();
        $GenerateCrud->index($folder, $class);

        $this->closeModal();
    }

    /**
     * method store
     */
    public function store()
    {
        DB::beginTransaction();
        try {
            // Create Generate
            $generate = $this->generate;
            $generate->save();

            // Commit Transaction
            DB::commit();

            $this->reset(['open', 'isEdit']);
            $this->generate = new Generate();
            $this->generate->isActive = true;
            $this->emitTo('temporal.generates.index-generates', 'render');
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
            // Create Generate
            $generate = $this->generate;
            $generate->save();

            // Commit Transaction
            DB::commit();

            $this->reset(['open', 'isEdit']);
            $this->generate = new Generate();
            $this->generate->isActive = true;
            $this->emitTo('temporal.generates.index-generates', 'render');
            $this->emit('alert');
            
        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e->getMessage());
            $this->emit('error_alert');
        } 
    }
}
