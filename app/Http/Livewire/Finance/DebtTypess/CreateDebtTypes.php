<?php

namespace App\Http\Livewire\Finance\DebtTypess;

use App\Http\Livewire\BaseComponent;
use App\Models\Finance\DebtTypes;
use DB, Log;

class CreateDebtTypes extends BaseComponent
{
    public $open = false;
    public $isEdit = false;

    public DebtTypes $debtTypes;

    /**
     * rules 
     */
    protected $rules = [
        'debtTypes.name' => 'required',
        'debtTypes.isActive' => 'boolean',
    ];

    /**
     * Listeners
     */
    protected $listeners=[
        'createDebtTypes' => 'createDebtTypes',
        'editDebtTypes' => 'editDebtTypes',
        'closeModal' => 'closeModal',
        'render' => 'render',
    ];

    /**
     * render
     */
    public function render()
    {
        return view('livewire.finance.debt-typess.create-debt-types');
    }

    /**
     * mount
     */
    public function mount()
    {
        // parent::mount();
        
        $this->debtTypes = new DebtTypes();
        $this->debtTypes->isActive = true;
    }

    /**
     * method open create
     */
    public function createDebtTypes()
    {
        $this->isEdit = false;
        $this->open = true;
    }

    /**
     * method open edit
     */
    public function editDebtTypes(DebtTypes $debtTypes)
    {
        $this->debtTypes = $debtTypes;
        $this->isEdit = true;
        $this->open = true;
    }

    /**
     * method close modal
     */
    public function closeModal()
    {
        $this->reset(['open', 'isEdit']);
        $this->debtTypes = new DebtTypes();
        $this->debtTypes->isActive = true;
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
            // Create DebtTypes
            $debtTypes = $this->debtTypes;
            $debtTypes->save();

            // Commit Transaction
            DB::commit();

            $this->reset(['open', 'isEdit']);
            $this->debtTypes = new DebtTypes();
            $this->debtTypes->isActive = true;
            $this->emitTo('finance.debt-typess.index-debt-typess', 'render');
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
            // Create DebtTypes
            $debtTypes = $this->debtTypes;
            $debtTypes->save();

            // Commit Transaction
            DB::commit();

            $this->reset(['open', 'isEdit']);
            $this->debtTypes = new DebtTypes();
            $this->debtTypes->isActive = true;
            $this->emitTo('finance.debt-typess.index-debt-typess', 'render');
            $this->emit('alert');
            
        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e->getMessage());
            $this->emit('error_alert');
        } 
    }
}
