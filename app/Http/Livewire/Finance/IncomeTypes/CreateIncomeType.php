<?php

namespace App\Http\Livewire\Finance\IncomeTypes;

use App\Http\Livewire\BaseComponent;
use App\Models\Finance\IncomeType;
use DB, Log;

class CreateIncomeType extends BaseComponent
{
    public $open = false;
    public $isEdit = false;

    public IncomeType $incomeType;

    /**
     * rules 
     */
    protected $rules = [
        'incomeType.name' => 'required',
        'incomeType.isActive' => 'boolean',
    ];

    /**
     * Listeners
     */
    protected $listeners=[
        'createIncomeType' => 'createIncomeType',
        'editIncomeType' => 'editIncomeType',
        'closeModal' => 'closeModal',
        'render' => 'render',
    ];

    /**
     * render
     */
    public function render()
    {
        return view('livewire.finance.income-types.create-income-type');
    }

    /**
     * mount
     */
    public function mount()
    {
        // parent::mount();
        
        $this->incomeType = new IncomeType();
        $this->incomeType->isActive = true;
    }

    /**
     * method open create
     */
    public function createIncomeType()
    {
        $this->isEdit = false;
        $this->open = true;
    }

    /**
     * method open edit
     */
    public function editIncomeType(IncomeType $incomeType)
    {
        $this->incomeType = $incomeType;
        $this->isEdit = true;
        $this->open = true;
    }

    /**
     * method close modal
     */
    public function closeModal()
    {
        $this->reset(['open', 'isEdit']);
        $this->incomeType = new IncomeType();
        $this->incomeType->isActive = true;
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
            // Create IncomeType
            $incomeType = $this->incomeType;
            $incomeType->save();

            // Commit Transaction
            DB::commit();

            $this->reset(['open', 'isEdit']);
            $this->incomeType = new IncomeType();
            $this->incomeType->isActive = true;
            $this->emitTo('finance.income-types.index-income-types', 'render');
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
            // Create IncomeType
            $incomeType = $this->incomeType;
            $incomeType->save();

            // Commit Transaction
            DB::commit();

            $this->reset(['open', 'isEdit']);
            $this->incomeType = new IncomeType();
            $this->incomeType->isActive = true;
            $this->emitTo('finance.income-types.index-income-types', 'render');
            $this->emit('alert');
            
        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e->getMessage());
            $this->emit('error_alert');
        } 
    }
}
