<?php

namespace App\Http\Livewire\Finance\BudgetTypes;

use App\Http\Livewire\BaseComponent;
use App\Models\Finance\BudgetType;
use DB, Log;

class CreateBudgetType extends BaseComponent
{
    public $open = false;
    public $isEdit = false;

    public BudgetType $budgetType;

    /**
     * rules 
     */
    protected $rules = [
        'budgetType.name' => 'required',
        'budgetType.isActive' => 'boolean',
    ];

    /**
     * Listeners
     */
    protected $listeners=[
        'createBudgetType' => 'createBudgetType',
        'editBudgetType' => 'editBudgetType',
        'closeModal' => 'closeModal',
        'render' => 'render',
    ];

    /**
     * render
     */
    public function render()
    {
        return view('livewire.finance.budget-types.create-budget-type');
    }

    /**
     * mount
     */
    public function mount()
    {
        // parent::mount();
        
        $this->budgetType = new BudgetType();
        $this->budgetType->isActive = true;
    }

    /**
     * method open create
     */
    public function createBudgetType()
    {
        $this->isEdit = false;
        $this->open = true;
    }

    /**
     * method open edit
     */
    public function editBudgetType(BudgetType $budgetType)
    {
        $this->budgetType = $budgetType;
        $this->isEdit = true;
        $this->open = true;
    }

    /**
     * method close modal
     */
    public function closeModal()
    {
        $this->reset(['open', 'isEdit']);
        $this->budgetType = new BudgetType();
        $this->budgetType->isActive = true;
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
            // Create BudgetType
            $budgetType = $this->budgetType;
            $budgetType->save();

            // Commit Transaction
            DB::commit();

            $this->reset(['open', 'isEdit']);
            $this->budgetType = new BudgetType();
            $this->budgetType->isActive = true;
            $this->emitTo('finance.budget-types.index-budget-types', 'render');
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
            // Create BudgetType
            $budgetType = $this->budgetType;
            $budgetType->save();

            // Commit Transaction
            DB::commit();

            $this->reset(['open', 'isEdit']);
            $this->budgetType = new BudgetType();
            $this->budgetType->isActive = true;
            $this->emitTo('finance.budget-types.index-budget-types', 'render');
            $this->emit('alert');
            
        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e->getMessage());
            $this->emit('error_alert');
        } 
    }
}
