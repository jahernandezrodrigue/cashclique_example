<?php

namespace App\Http\Livewire\Temporal\Cursos;

use App\Http\Livewire\BaseComponent;
use App\Models\Temporal\Curso;
use DB, Log;

class CreateCurso extends BaseComponent
{
    public $open = false;
    public $isEdit = false;

    public Curso $curso;

    /**
     * rules 
     */
    protected $rules = [
        'curso.name' => 'required',
        'curso.isActive' => 'boolean',
    ];

    /**
     * Listeners
     */
    protected $listeners=[
        'createCurso' => 'createCurso',
        'editCurso' => 'editCurso',
        'closeModal' => 'closeModal',
        'render' => 'render',
    ];

    /**
     * render
     */
    public function render()
    {
        return view('livewire.temporal.cursos.create-curso');
    }

    /**
     * mount
     */
    public function mount()
    {
        // parent::mount();
        
        $this->curso = new Curso();
        $this->curso->isActive = true;
    }

    /**
     * method open create
     */
    public function createCurso()
    {
        $this->isEdit = false;
        $this->open = true;
    }

    /**
     * method open edit
     */
    public function editCurso(Curso $curso)
    {
        $this->curso = $curso;
        $this->isEdit = true;
        $this->open = true;
    }

    /**
     * method close modal
     */
    public function closeModal()
    {
        $this->reset(['open', 'isEdit']);
        $this->curso = new Curso();
        $this->curso->isActive = true;
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
            // Create Curso
            $curso = $this->curso;
            $curso->save();

            // Commit Transaction
            DB::commit();

            $this->reset(['open', 'isEdit']);
            $this->curso = new Curso();
            $this->curso->isActive = true;
            $this->emitTo('temporal.cursos.index-cursos', 'render');
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
            // Create Curso
            $curso = $this->curso;
            $curso->save();

            // Commit Transaction
            DB::commit();

            $this->reset(['open', 'isEdit']);
            $this->curso = new Curso();
            $this->curso->isActive = true;
            $this->emitTo('temporal.cursos.index-cursos', 'render');
            $this->emit('alert');
            
        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e->getMessage());
            $this->emit('error_alert');
        } 
    }
}
