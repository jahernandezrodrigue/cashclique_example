<?php

namespace App\Http\Livewire\Temporal\Employees;

use App\Http\Livewire\BaseComponent;
use App\Models\Temporal\Employee;
use DB, Log;

class IndexEmployees extends BaseComponent
{
    public $search;
    public $sort = 'id';
    public $direction = 'desc';
    public $cant = 10;
    
    public Employee $employee;

    /**
     * Listeners.
     */
    protected $listeners=['render' => 'render', 'deleteEmployee' => 'delete'];

    public function render()
    {
        $query = Employee::query();
        $query->orderby($this->sort, $this->direction);
        $query->where('name', 'like', '%'. $this->search .'%');
        $employees = $query->paginate($this->cant);
        return view('livewire.temporal.employees.index-employees', compact('employees'));
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

    public function delete(Employee $employee) {
        DB::beginTransaction();
        try {
            $employee->delete();

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
