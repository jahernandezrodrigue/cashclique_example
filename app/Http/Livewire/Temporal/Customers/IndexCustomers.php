<?php

namespace App\Http\Livewire\Temporal\Customers;

use App\Http\Livewire\BaseComponent;
use App\Models\Temporal\Customer;
use DB, Log;

class IndexCustomers extends BaseComponent
{
    public $search;
    public $sort = 'id';
    public $direction = 'desc';
    public $cant = 10;
    
    public Customer $customer;

    /**
     * Listeners.
     */
    protected $listeners=['render' => 'render', 'deleteCustomer' => 'delete'];

    public function render()
    {
        $query = Customer::query();
        $query->orderby($this->sort, $this->direction);
        $query->where('name', 'like', '%'. $this->search .'%');
        $customers = $query->paginate($this->cant);
        return view('livewire.temporal.customers.index-customers', compact('customers'));
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

    public function delete(Customer $customer) {
        DB::beginTransaction();
        try {
            $customer->delete();

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
