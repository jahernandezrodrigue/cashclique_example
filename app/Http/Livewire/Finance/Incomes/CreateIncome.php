<?php

namespace App\Http\Livewire\Finance\Incomes;

use App\Http\Livewire\BaseComponent;
use App\Models\Finance\Income;
use DB, Log;

class CreateIncome extends BaseComponent
{
    public $open = false;
    public $isEdit = false;

    public Income $income;

    /**
     * rules 
     */
    protected $rules = [
        'income.name' => 'required',
        'income.isActive' => 'boolean',
    ];

    /**
     * Listeners
     */
    protected $listeners=[
        'createIncome' => 'createIncome',
        'editIncome' => 'editIncome',
        'closeModal' => 'closeModal',
        'render' => 'render',
    ];

    /**
     * render
     */
    public function render()
    {
        return view('livewire.finance.incomes.create-income');
    }

    /**
     * mount
     */
    public function mount()
    {
        // parent::mount();
        
        $this->income = new Income();
        $this->income->isActive = true;
    }

    /**
     * method open create
     */
    public function createIncome()
    {
        $this->isEdit = false;
        $this->open = true;
    }

    /**
     * method open edit
     */
    public function editIncome(Income $income)
    {
        $this->income = $income;
        $this->isEdit = true;
        $this->open = true;
    }

    /**
     * method close modal
     */
    public function closeModal()
    {
        $this->reset(['open', 'isEdit']);
        $this->income = new Income();
        $this->income->isActive = true;
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
            // Create Income
            $income = $this->income;
            $income->save();

            // Commit Transaction
            DB::commit();

            $this->reset(['open', 'isEdit']);
            $this->income = new Income();
            $this->income->isActive = true;
            $this->emitTo('finance.incomes.index-incomes', 'render');
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
            // Create Income
            $income = $this->income;
            $income->save();

            // Commit Transaction
            DB::commit();

            $this->reset(['open', 'isEdit']);
            $this->income = new Income();
            $this->income->isActive = true;
            $this->emitTo('finance.incomes.index-incomes', 'render');
            $this->emit('alert');
            
        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e->getMessage());
            $this->emit('error_alert');
        } 
    }
}
