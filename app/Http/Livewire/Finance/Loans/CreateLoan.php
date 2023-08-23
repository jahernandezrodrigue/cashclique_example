<?php

namespace App\Http\Livewire\Finance\Loans;

use App\Http\Livewire\BaseComponent;
use App\Models\Finance\Loan;
use DB, Log;

class CreateLoan extends BaseComponent
{
    public $open = false;
    public $isEdit = false;

    public Loan $loan;

    /**
     * rules 
     */
    protected $rules = [
        'loan.name' => 'required',
        'loan.isActive' => 'boolean',
    ];

    /**
     * Listeners
     */
    protected $listeners=[
        'createLoan' => 'createLoan',
        'editLoan' => 'editLoan',
        'closeModal' => 'closeModal',
        'render' => 'render',
    ];

    /**
     * render
     */
    public function render()
    {
        return view('livewire.finance.loans.create-loan');
    }

    /**
     * mount
     */
    public function mount()
    {
        // parent::mount();
        
        $this->loan = new Loan();
        $this->loan->isActive = true;
    }

    /**
     * method open create
     */
    public function createLoan()
    {
        $this->isEdit = false;
        $this->open = true;
    }

    /**
     * method open edit
     */
    public function editLoan(Loan $loan)
    {
        $this->loan = $loan;
        $this->isEdit = true;
        $this->open = true;
    }

    /**
     * method close modal
     */
    public function closeModal()
    {
        $this->reset(['open', 'isEdit']);
        $this->loan = new Loan();
        $this->loan->isActive = true;
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
            // Create Loan
            $loan = $this->loan;
            $loan->save();

            // Commit Transaction
            DB::commit();

            $this->reset(['open', 'isEdit']);
            $this->loan = new Loan();
            $this->loan->isActive = true;
            $this->emitTo('finance.loans.index-loans', 'render');
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
            // Create Loan
            $loan = $this->loan;
            $loan->save();

            // Commit Transaction
            DB::commit();

            $this->reset(['open', 'isEdit']);
            $this->loan = new Loan();
            $this->loan->isActive = true;
            $this->emitTo('finance.loans.index-loans', 'render');
            $this->emit('alert');
            
        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e->getMessage());
            $this->emit('error_alert');
        } 
    }
}
