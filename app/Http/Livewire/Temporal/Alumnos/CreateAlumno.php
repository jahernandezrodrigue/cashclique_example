<?php

namespace App\Http\Livewire\Temporal\Alumnos;

use App\Http\Livewire\BaseComponent;
use App\Models\Temporal\Alumno;
use DB, Log;

class CreateAlumno extends BaseComponent
{
    public $open = false;
    public $isEdit = false;

    public Alumno $alumno;

    /**
     * rules 
     */
    protected $rules = [
        'alumno.name' => 'required',
        'alumno.isActive' => 'boolean',
    ];

    /**
     * Listeners
     */
    protected $listeners=[
        'createAlumno' => 'createAlumno',
        'editAlumno' => 'editAlumno',
        'closeModal' => 'closeModal',
        'render' => 'render',
    ];

    /**
     * render
     */
    public function render()
    {
        return view('livewire.temporal.alumnos.create-alumno');
    }

    /**
     * mount
     */
    public function mount()
    {
        // parent::mount();
        
        $this->alumno = new Alumno();
        $this->alumno->isActive = true;
    }

    /**
     * method open create
     */
    public function createAlumno()
    {
        $this->isEdit = false;
        $this->open = true;
    }

    /**
     * method open edit
     */
    public function editAlumno(Alumno $alumno)
    {
        $this->alumno = $alumno;
        $this->isEdit = true;
        $this->open = true;
    }

    /**
     * method close modal
     */
    public function closeModal()
    {
        $this->reset(['open', 'isEdit']);
        $this->alumno = new Alumno();
        $this->alumno->isActive = true;
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
            // Create Alumno
            $alumno = $this->alumno;
            $alumno->save();

            // Commit Transaction
            DB::commit();

            $this->reset(['open', 'isEdit']);
            $this->alumno = new Alumno();
            $this->alumno->isActive = true;
            $this->emitTo('temporal.alumnos.index-alumnos', 'render');
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
            // Create Alumno
            $alumno = $this->alumno;
            $alumno->save();

            // Commit Transaction
            DB::commit();

            $this->reset(['open', 'isEdit']);
            $this->alumno = new Alumno();
            $this->alumno->isActive = true;
            $this->emitTo('temporal.alumnos.index-alumnos', 'render');
            $this->emit('alert');
            
        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e->getMessage());
            $this->emit('error_alert');
        } 
    }
}
