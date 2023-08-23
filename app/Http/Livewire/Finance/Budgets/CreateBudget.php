<?php

namespace App\Http\Livewire\Finance\Budgets;

use App\Http\Livewire\BaseComponent;
use App\Models\Finance\Budget;
use DB, Log;

class CreateBudget extends BaseComponent
{
    public $open = false;
    public $isEdit = false;

    public Budget $budget;

    /**
     * rules 
     */
    protected $rules = [
        'budget.name' => 'required',
        'budget.isActive' => 'boolean',
    ];

    /**
     * Listeners
     */
    protected $listeners=[
        'createBudget' => 'createBudget',
        'editBudget' => 'editBudget',
        'closeModal' => 'closeModal',
        'render' => 'render',
    ];

    /**
     * render
     */
    public function render()
    {
        return view('livewire.finance.budgets.create-budget');
    }

    /**
     * mount
     */
    public function mount()
    {
        // parent::mount();
        
        $this->budget = new Budget();
        $this->budget->isActive = true;
    }

    /**
     * method open create
     */
    public function createBudget()
    {
        $this->isEdit = false;
        $this->open = true;
    }

    /**
     * method open edit
     */
    public function editBudget(Budget $budget)
    {
        $this->budget = $budget;
        $this->isEdit = true;
        $this->open = true;
    }

    /**
     * method close modal
     */
    public function closeModal()
    {
        $this->reset(['open', 'isEdit']);
        $this->budget = new Budget();
        $this->budget->isActive = true;
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
            // Create Budget
            $budget = $this->budget;
            $budget->save();

            // Commit Transaction
            DB::commit();

            $this->reset(['open', 'isEdit']);
            $this->budget = new Budget();
            $this->budget->isActive = true;
            $this->emitTo('finance.budgets.index-budgets', 'render');
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
            // Create Budget
            $budget = $this->budget;
            $budget->save();

            // Commit Transaction
            DB::commit();

            $this->reset(['open', 'isEdit']);
            $this->budget = new Budget();
            $this->budget->isActive = true;
            $this->emitTo('finance.budgets.index-budgets', 'render');
            $this->emit('alert');
            
        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e->getMessage());
            $this->emit('error_alert');
        } 
    }
}
