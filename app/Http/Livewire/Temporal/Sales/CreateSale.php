<?php

namespace App\Http\Livewire\Temporal\Sales;

use App\Http\Livewire\BaseComponent;
use App\Models\Temporal\Sale;
use DB, Log;

class CreateSale extends BaseComponent
{
    public $open = false;
    public $isEdit = false;

    public Sale $sale;

    /**
     * rules 
     */
    protected $rules = [
        'sale.name' => 'required',
        'sale.isActive' => 'boolean',
    ];

    /**
     * Listeners
     */
    protected $listeners=[
        'createSale' => 'createSale',
        'editSale' => 'editSale',
        'closeModal' => 'closeModal',
        'render' => 'render',
    ];

    /**
     * render
     */
    public function render()
    {
        return view('livewire.temporal.sales.create-sale');
    }

    /**
     * mount
     */
    public function mount()
    {
        // parent::mount();
        
        $this->sale = new Sale();
        $this->sale->isActive = true;
    }

    /**
     * method open create
     */
    public function createSale()
    {
        $this->isEdit = false;
        $this->open = true;
    }

    /**
     * method open edit
     */
    public function editSale(Sale $sale)
    {
        $this->sale = $sale;
        $this->isEdit = true;
        $this->open = true;
    }

    /**
     * method close modal
     */
    public function closeModal()
    {
        $this->reset(['open', 'isEdit']);
        $this->sale = new Sale();
        $this->sale->isActive = true;
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
            // Create Sale
            $sale = $this->sale;
            $sale->save();

            // Commit Transaction
            DB::commit();

            $this->reset(['open', 'isEdit']);
            $this->sale = new Sale();
            $this->sale->isActive = true;
            $this->emitTo('temporal.sales.index-sales', 'render');
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
            // Create Sale
            $sale = $this->sale;
            $sale->save();

            // Commit Transaction
            DB::commit();

            $this->reset(['open', 'isEdit']);
            $this->sale = new Sale();
            $this->sale->isActive = true;
            $this->emitTo('temporal.sales.index-sales', 'render');
            $this->emit('alert');
            
        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e->getMessage());
            $this->emit('error_alert');
        } 
    }
}
