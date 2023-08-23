<?php

namespace App\Http\Livewire\Temporal\Employees;

use App\Http\Livewire\BaseComponent;
use App\Models\Temporal\Employee;
use DB, Log;

class CreateEmployee extends BaseComponent
{
    public $open = false;
    public $isEdit = false;

    public Employee $employee;

    /**
     * rules 
     */
    protected $rules = [
        'employee.name' => 'required',
        'employee.surname' => 'required',
        'employee.phone' => 'required',
        'employee.email' => 'required',
        'employee.isActive' => 'boolean',
    ];

    /**
     * Listeners
     */
    protected $listeners=[
        'createEmployee' => 'createEmployee',
        'editEmployee' => 'editEmployee',
        'closeModal' => 'closeModal',
        'render' => 'render',
    ];

    /**
     * render
     */
    public function render()
    {
        return view('livewire.temporal.employees.create-employee');
    }

    /**
     * mount
     */
    public function mount()
    {
        // parent::mount();
        
        $this->employee = new Employee();
        $this->employee->isActive = true;
    }

    /**
     * method open create
     */
    public function createEmployee()
    {
        $this->isEdit = false;
        $this->open = true;
    }

    /**
     * method open edit
     */
    public function editEmployee(Employee $employee)
    {
        $this->employee = $employee;
        $this->isEdit = true;
        $this->open = true;
    }

    /**
     * method close modal
     */
    public function closeModal()
    {
        $this->reset(['open', 'isEdit']);
        $this->employee = new Employee();
        $this->employee->isActive = true;
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
            // Create Employee
            $employee = $this->employee;
            $employee->save();

            // Commit Transaction
            DB::commit();

            $this->reset(['open', 'isEdit']);
            $this->employee = new Employee();
            $this->employee->isActive = true;
            $this->emitTo('temporal.employees.index-employees', 'render');
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
            // Create Employee
            $employee = $this->employee;
            $employee->save();

            // Commit Transaction
            DB::commit();

            $this->reset(['open', 'isEdit']);
            $this->employee = new Employee();
            $this->employee->isActive = true;
            $this->emitTo('temporal.employees.index-employees', 'render');
            $this->emit('alert');
            
        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e->getMessage());
            $this->emit('error_alert');
        } 
    }
}
