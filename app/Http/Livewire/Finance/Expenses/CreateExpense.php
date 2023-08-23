<?php

namespace App\Http\Livewire\Finance\Expenses;

use App\Http\Livewire\BaseComponent;
use App\Models\Finance\Expense;
use DB, Log;

class CreateExpense extends BaseComponent
{
    public $open = false;
    public $isEdit = false;

    public Expense $expense;

    /**
     * rules 
     */
    protected $rules = [
        'expense.name' => 'required',
        'expense.isActive' => 'boolean',
    ];

    /**
     * Listeners
     */
    protected $listeners=[
        'createExpense' => 'createExpense',
        'editExpense' => 'editExpense',
        'closeModal' => 'closeModal',
        'render' => 'render',
    ];

    /**
     * render
     */
    public function render()
    {
        return view('livewire.finance.expenses.create-expense');
    }

    /**
     * mount
     */
    public function mount()
    {
        // parent::mount();
        
        $this->expense = new Expense();
        $this->expense->isActive = true;
    }

    /**
     * method open create
     */
    public function createExpense()
    {
        $this->isEdit = false;
        $this->open = true;
    }

    /**
     * method open edit
     */
    public function editExpense(Expense $expense)
    {
        $this->expense = $expense;
        $this->isEdit = true;
        $this->open = true;
    }

    /**
     * method close modal
     */
    public function closeModal()
    {
        $this->reset(['open', 'isEdit']);
        $this->expense = new Expense();
        $this->expense->isActive = true;
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
            // Create Expense
            $expense = $this->expense;
            $expense->save();

            // Commit Transaction
            DB::commit();

            $this->reset(['open', 'isEdit']);
            $this->expense = new Expense();
            $this->expense->isActive = true;
            $this->emitTo('finance.expenses.index-expenses', 'render');
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
            // Create Expense
            $expense = $this->expense;
            $expense->save();

            // Commit Transaction
            DB::commit();

            $this->reset(['open', 'isEdit']);
            $this->expense = new Expense();
            $this->expense->isActive = true;
            $this->emitTo('finance.expenses.index-expenses', 'render');
            $this->emit('alert');
            
        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e->getMessage());
            $this->emit('error_alert');
        } 
    }
}
