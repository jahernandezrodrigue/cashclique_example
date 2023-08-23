<?php

namespace App\Http\Livewire\Finance\LoanTypes;

use App\Http\Livewire\BaseComponent;
use App\Models\Finance\LoanType;
use DB, Log;

class CreateLoanType extends BaseComponent
{
    public $open = false;
    public $isEdit = false;

    public LoanType $loanType;

    /**
     * rules 
     */
    protected $rules = [
        'loanType.name' => 'required',
        'loanType.isActive' => 'boolean',
    ];

    /**
     * Listeners
     */
    protected $listeners=[
        'createLoanType' => 'createLoanType',
        'editLoanType' => 'editLoanType',
        'closeModal' => 'closeModal',
        'render' => 'render',
    ];

    /**
     * render
     */
    public function render()
    {
        return view('livewire.finance.loan-types.create-loan-type');
    }

    /**
     * mount
     */
    public function mount()
    {
        // parent::mount();
        
        $this->loanType = new LoanType();
        $this->loanType->isActive = true;
    }

    /**
     * method open create
     */
    public function createLoanType()
    {
        $this->isEdit = false;
        $this->open = true;
    }

    /**
     * method open edit
     */
    public function editLoanType(LoanType $loanType)
    {
        $this->loanType = $loanType;
        $this->isEdit = true;
        $this->open = true;
    }

    /**
     * method close modal
     */
    public function closeModal()
    {
        $this->reset(['open', 'isEdit']);
        $this->loanType = new LoanType();
        $this->loanType->isActive = true;
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
            // Create LoanType
            $loanType = $this->loanType;
            $loanType->save();

            // Commit Transaction
            DB::commit();

            $this->reset(['open', 'isEdit']);
            $this->loanType = new LoanType();
            $this->loanType->isActive = true;
            $this->emitTo('finance.loan-types.index-loan-types', 'render');
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
            // Create LoanType
            $loanType = $this->loanType;
            $loanType->save();

            // Commit Transaction
            DB::commit();

            $this->reset(['open', 'isEdit']);
            $this->loanType = new LoanType();
            $this->loanType->isActive = true;
            $this->emitTo('finance.loan-types.index-loan-types', 'render');
            $this->emit('alert');
            
        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e->getMessage());
            $this->emit('error_alert');
        } 
    }
}
