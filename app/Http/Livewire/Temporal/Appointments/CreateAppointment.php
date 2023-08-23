<?php

namespace App\Http\Livewire\Temporal\Appointments;

use App\Http\Livewire\BaseComponent;
use App\Models\Temporal\Appointment;
use DB, Log;

class CreateAppointment extends BaseComponent
{
    public $open = false;
    public $isEdit = false;

    public Appointment $appointment;

    /**
     * rules 
     */
    protected $rules = [
        'appointment.name' => 'required',
        'appointment.isActive' => 'boolean',
    ];

    /**
     * Listeners
     */
    protected $listeners=[
        'createAppointment' => 'createAppointment',
        'editAppointment' => 'editAppointment',
        'closeModal' => 'closeModal',
        'render' => 'render',
    ];

    /**
     * render
     */
    public function render()
    {
        return view('livewire.temporal.appointments.create-appointment');
    }

    /**
     * mount
     */
    public function mount()
    {
        // parent::mount();
        
        $this->appointment = new Appointment();
        $this->appointment->isActive = true;
    }

    /**
     * method open create
     */
    public function createAppointment()
    {
        $this->isEdit = false;
        $this->open = true;
    }

    /**
     * method open edit
     */
    public function editAppointment(Appointment $appointment)
    {
        $this->appointment = $appointment;
        $this->isEdit = true;
        $this->open = true;
    }

    /**
     * method close modal
     */
    public function closeModal()
    {
        $this->reset(['open', 'isEdit']);
        $this->appointment = new Appointment();
        $this->appointment->isActive = true;
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
            // Create Appointment
            $appointment = $this->appointment;
            $appointment->save();

            // Commit Transaction
            DB::commit();

            $this->reset(['open', 'isEdit']);
            $this->appointment = new Appointment();
            $this->appointment->isActive = true;
            $this->emitTo('temporal.appointments.index-appointments', 'render');
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
            // Create Appointment
            $appointment = $this->appointment;
            $appointment->save();

            // Commit Transaction
            DB::commit();

            $this->reset(['open', 'isEdit']);
            $this->appointment = new Appointment();
            $this->appointment->isActive = true;
            $this->emitTo('temporal.appointments.index-appointments', 'render');
            $this->emit('alert');
            
        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e->getMessage());
            $this->emit('error_alert');
        } 
    }
}
