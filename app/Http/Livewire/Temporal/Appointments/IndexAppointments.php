<?php

namespace App\Http\Livewire\Temporal\Appointments;

use App\Http\Livewire\BaseComponent;
use App\Models\Temporal\Appointment;
use DB, Log;

class IndexAppointments extends BaseComponent
{
    public $search;
    public $sort = 'id';
    public $direction = 'desc';
    public $cant = 10;
    
    public Appointment $appointment;

    /**
     * Listeners.
     */
    protected $listeners=['render' => 'render', 'deleteAppointment' => 'delete'];

    public function render()
    {
        $query = Appointment::query();
        $query->orderby($this->sort, $this->direction);
        $query->where('name', 'like', '%'. $this->search .'%');
        $appointments = $query->paginate($this->cant);
        return view('livewire.temporal.appointments.index-appointments', compact('appointments'));
    }

    public function order($sort)
    {
        if ($this->sort==$sort)
        {
            if ($this->direction=='desc'){
                $this->direction='asc';
            }
            else{
                $this->direction='desc';
            }

        } else {
            $this->sort=$sort;
            $this->direction=='asc';
        }
    }

    public function delete(Appointment $appointment) {
        DB::beginTransaction();
        try {
            $appointment->delete();

            // Commit Transaction
            DB::commit();

            $this->emit('alert');
        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e->getMessage());
            $this->emit('error_alert');
        }
    }
}
