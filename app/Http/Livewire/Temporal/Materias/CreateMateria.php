<?php

namespace App\Http\Livewire\Temporal\Materias;

use App\Http\Livewire\BaseComponent;
use App\Models\Temporal\Materia;
use DB, Log;

class CreateMateria extends BaseComponent
{
    public $open = false;
    public $isEdit = false;

    public Materia $materia;

    /**
     * rules 
     */
    protected $rules = [
        'materia.name' => 'required',
        'materia.isActive' => 'boolean',
    ];

    /**
     * Listeners
     */
    protected $listeners=[
        'createMateria' => 'createMateria',
        'editMateria' => 'editMateria',
        'closeModal' => 'closeModal',
        'render' => 'render',
    ];

    /**
     * render
     */
    public function render()
    {
        return view('livewire.temporal.materias.create-materia');
    }

    /**
     * mount
     */
    public function mount()
    {
        // parent::mount();
        
        $this->materia = new Materia();
        $this->materia->isActive = true;
    }

    /**
     * method open create
     */
    public function createMateria()
    {
        $this->isEdit = false;
        $this->open = true;
    }

    /**
     * method open edit
     */
    public function editMateria(Materia $materia)
    {
        $this->materia = $materia;
        $this->isEdit = true;
        $this->open = true;
    }

    /**
     * method close modal
     */
    public function closeModal()
    {
        $this->reset(['open', 'isEdit']);
        $this->materia = new Materia();
        $this->materia->isActive = true;
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
            // Create Materia
            $materia = $this->materia;
            $materia->save();

            // Commit Transaction
            DB::commit();

            $this->reset(['open', 'isEdit']);
            $this->materia = new Materia();
            $this->materia->isActive = true;
            $this->emitTo('temporal.materias.index-materias', 'render');
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
            // Create Materia
            $materia = $this->materia;
            $materia->save();

            // Commit Transaction
            DB::commit();

            $this->reset(['open', 'isEdit']);
            $this->materia = new Materia();
            $this->materia->isActive = true;
            $this->emitTo('temporal.materias.index-materias', 'render');
            $this->emit('alert');
            
        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e->getMessage());
            $this->emit('error_alert');
        } 
    }
}
