<?php

namespace App\Http\Livewire\Finance\ExpenseTypes;

use App\Http\Livewire\BaseComponent;
use App\Models\Finance\ExpenseType;
use DB, Log;

class CreateExpenseType extends BaseComponent
{
    public $open = false;
    public $isEdit = false;

    public ExpenseType $expenseType;

    /**
     * rules 
     */
    protected $rules = [
        'expenseType.name' => 'required',
        'expenseType.isActive' => 'boolean',
    ];

    /**
     * Listeners
     */
    protected $listeners=[
        'createExpenseType' => 'createExpenseType',
        'editExpenseType' => 'editExpenseType',
        'closeModal' => 'closeModal',
        'render' => 'render',
    ];

    /**
     * render
     */
    public function render()
    {
        return view('livewire.finance.expense-types.create-expense-type');
    }

    /**
     * mount
     */
    public function mount()
    {
        // parent::mount();
        
        $this->expenseType = new ExpenseType();
        $this->expenseType->isActive = true;
    }

    /**
     * method open create
     */
    public function createExpenseType()
    {
        $this->isEdit = false;
        $this->open = true;
    }

    /**
     * method open edit
     */
    public function editExpenseType(ExpenseType $expenseType)
    {
        $this->expenseType = $expenseType;
        $this->isEdit = true;
        $this->open = true;
    }

    /**
     * method close modal
     */
    public function closeModal()
    {
        $this->reset(['open', 'isEdit']);
        $this->expenseType = new ExpenseType();
        $this->expenseType->isActive = true;
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
            // Create ExpenseType
            $expenseType = $this->expenseType;
            $expenseType->save();

            // Commit Transaction
            DB::commit();

            $this->reset(['open', 'isEdit']);
            $this->expenseType = new ExpenseType();
            $this->expenseType->isActive = true;
            $this->emitTo('finance.expense-types.index-expense-types', 'render');
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
            // Create ExpenseType
            $expenseType = $this->expenseType;
            $expenseType->save();

            // Commit Transaction
            DB::commit();

            $this->reset(['open', 'isEdit']);
            $this->expenseType = new ExpenseType();
            $this->expenseType->isActive = true;
            $this->emitTo('finance.expense-types.index-expense-types', 'render');
            $this->emit('alert');
            
        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e->getMessage());
            $this->emit('error_alert');
        } 
    }
}
