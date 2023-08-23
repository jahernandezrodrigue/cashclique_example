<?php

namespace App\Http\Livewire\Finance\InvestmentTypes;

use App\Http\Livewire\BaseComponent;
use App\Models\Finance\InvestmentType;
use DB, Log;

class CreateInvestmentType extends BaseComponent
{
    public $open = false;
    public $isEdit = false;

    public InvestmentType $investmentType;

    /**
     * rules 
     */
    protected $rules = [
        'investmentType.name' => 'required',
        'investmentType.isActive' => 'boolean',
    ];

    /**
     * Listeners
     */
    protected $listeners=[
        'createInvestmentType' => 'createInvestmentType',
        'editInvestmentType' => 'editInvestmentType',
        'closeModal' => 'closeModal',
        'render' => 'render',
    ];

    /**
     * render
     */
    public function render()
    {
        return view('livewire.finance.investment-types.create-investment-type');
    }

    /**
     * mount
     */
    public function mount()
    {
        // parent::mount();
        
        $this->investmentType = new InvestmentType();
        $this->investmentType->isActive = true;
    }

    /**
     * method open create
     */
    public function createInvestmentType()
    {
        $this->isEdit = false;
        $this->open = true;
    }

    /**
     * method open edit
     */
    public function editInvestmentType(InvestmentType $investmentType)
    {
        $this->investmentType = $investmentType;
        $this->isEdit = true;
        $this->open = true;
    }

    /**
     * method close modal
     */
    public function closeModal()
    {
        $this->reset(['open', 'isEdit']);
        $this->investmentType = new InvestmentType();
        $this->investmentType->isActive = true;
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
            // Create InvestmentType
            $investmentType = $this->investmentType;
            $investmentType->save();

            // Commit Transaction
            DB::commit();

            $this->reset(['open', 'isEdit']);
            $this->investmentType = new InvestmentType();
            $this->investmentType->isActive = true;
            $this->emitTo('finance.investment-types.index-investment-types', 'render');
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
            // Create InvestmentType
            $investmentType = $this->investmentType;
            $investmentType->save();

            // Commit Transaction
            DB::commit();

            $this->reset(['open', 'isEdit']);
            $this->investmentType = new InvestmentType();
            $this->investmentType->isActive = true;
            $this->emitTo('finance.investment-types.index-investment-types', 'render');
            $this->emit('alert');
            
        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e->getMessage());
            $this->emit('error_alert');
        } 
    }
}
