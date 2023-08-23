<?php

namespace App\Http\Livewire\Finance\Debts;

use App\Http\Livewire\BaseComponent;
use App\Models\Finance\Debt;
use DB, Log;

class CreateDebt extends BaseComponent
{
    public $open = false;
    public $isEdit = false;

    public Debt $debt;

    /**
     * rules 
     */
    protected $rules = [
        'debt.name' => 'required',
        'debt.isActive' => 'boolean',
    ];

    /**
     * Listeners
     */
    protected $listeners=[
        'createDebt' => 'createDebt',
        'editDebt' => 'editDebt',
        'closeModal' => 'closeModal',
        'render' => 'render',
    ];

    /**
     * render
     */
    public function render()
    {
        return view('livewire.finance.debts.create-debt');
    }

    /**
     * mount
     */
    public function mount()
    {
        // parent::mount();
        
        $this->debt = new Debt();
        $this->debt->isActive = true;
    }

    /**
     * method open create
     */
    public function createDebt()
    {
        $this->isEdit = false;
        $this->open = true;
    }

    /**
     * method open edit
     */
    public function editDebt(Debt $debt)
    {
        $this->debt = $debt;
        $this->isEdit = true;
        $this->open = true;
    }

    /**
     * method close modal
     */
    public function closeModal()
    {
        $this->reset(['open', 'isEdit']);
        $this->debt = new Debt();
        $this->debt->isActive = true;
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
            // Create Debt
            $debt = $this->debt;
            $debt->save();

            // Commit Transaction
            DB::commit();

            $this->reset(['open', 'isEdit']);
            $this->debt = new Debt();
            $this->debt->isActive = true;
            $this->emitTo('finance.debts.index-debts', 'render');
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
            // Create Debt
            $debt = $this->debt;
            $debt->save();

            // Commit Transaction
            DB::commit();

            $this->reset(['open', 'isEdit']);
            $this->debt = new Debt();
            $this->debt->isActive = true;
            $this->emitTo('finance.debts.index-debts', 'render');
            $this->emit('alert');
            
        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e->getMessage());
            $this->emit('error_alert');
        } 
    }
}
