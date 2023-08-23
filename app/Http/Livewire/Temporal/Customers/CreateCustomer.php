<?php

namespace App\Http\Livewire\Temporal\Customers;

use App\Http\Livewire\BaseComponent;
use App\Models\Temporal\Customer;
use DB, Log;

class CreateCustomer extends BaseComponent
{
    public $open = false;
    public $isEdit = false;

    public Customer $customer;

    /**
     * rules 
     */
    protected $rules = [
        'customer.name' => 'required',
        'customer.isActive' => 'boolean',
    ];

    /**
     * Listeners
     */
    protected $listeners=[
        'createCustomer' => 'createCustomer',
        'editCustomer' => 'editCustomer',
        'closeModal' => 'closeModal',
        'render' => 'render',
    ];

    /**
     * render
     */
    public function render()
    {
        return view('livewire.temporal.customers.create-customer');
    }

    /**
     * mount
     */
    public function mount()
    {
        // parent::mount();
        
        $this->customer = new Customer();
        $this->customer->isActive = true;
    }

    /**
     * method open create
     */
    public function createCustomer()
    {
        $this->isEdit = false;
        $this->open = true;
    }

    /**
     * method open edit
     */
    public function editCustomer(Customer $customer)
    {
        $this->customer = $customer;
        $this->isEdit = true;
        $this->open = true;
    }

    /**
     * method close modal
     */
    public function closeModal()
    {
        $this->reset(['open', 'isEdit']);
        $this->customer = new Customer();
        $this->customer->isActive = true;
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
            // Create Customer
            $customer = $this->customer;
            $customer->save();

            // Commit Transaction
            DB::commit();

            $this->reset(['open', 'isEdit']);
            $this->customer = new Customer();
            $this->customer->isActive = true;
            $this->emitTo('temporal.customers.index-customers', 'render');
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
            // Create Customer
            $customer = $this->customer;
            $customer->save();

            // Commit Transaction
            DB::commit();

            $this->reset(['open', 'isEdit']);
            $this->customer = new Customer();
            $this->customer->isActive = true;
            $this->emitTo('temporal.customers.index-customers', 'render');
            $this->emit('alert');
            
        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e->getMessage());
            $this->emit('error_alert');
        } 
    }
}
