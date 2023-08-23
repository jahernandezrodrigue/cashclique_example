<?php

namespace App\Http\Livewire\Finance\Investments;

use App\Http\Livewire\BaseComponent;
use App\Models\Finance\Investment;
use DB, Log;

class CreateInvestment extends BaseComponent
{
    public $open = false;
    public $isEdit = false;

    public Investment $investment;

    /**
     * rules 
     */
    protected $rules = [
        'investment.name' => 'required',
        'investment.isActive' => 'boolean',
    ];

    /**
     * Listeners
     */
    protected $listeners=[
        'createInvestment' => 'createInvestment',
        'editInvestment' => 'editInvestment',
        'closeModal' => 'closeModal',
        'render' => 'render',
    ];

    /**
     * render
     */
    public function render()
    {
        return view('livewire.finance.investments.create-investment');
    }

    /**
     * mount
     */
    public function mount()
    {
        // parent::mount();
        
        $this->investment = new Investment();
        $this->investment->isActive = true;
    }

    /**
     * method open create
     */
    public function createInvestment()
    {
        $this->isEdit = false;
        $this->open = true;
    }

    /**
     * method open edit
     */
    public function editInvestment(Investment $investment)
    {
        $this->investment = $investment;
        $this->isEdit = true;
        $this->open = true;
    }

    /**
     * method close modal
     */
    public function closeModal()
    {
        $this->reset(['open', 'isEdit']);
        $this->investment = new Investment();
        $this->investment->isActive = true;
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
            // Create Investment
            $investment = $this->investment;
            $investment->save();

            // Commit Transaction
            DB::commit();

            $this->reset(['open', 'isEdit']);
            $this->investment = new Investment();
            $this->investment->isActive = true;
            $this->emitTo('finance.investments.index-investments', 'render');
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
            // Create Investment
            $investment = $this->investment;
            $investment->save();

            // Commit Transaction
            DB::commit();

            $this->reset(['open', 'isEdit']);
            $this->investment = new Investment();
            $this->investment->isActive = true;
            $this->emitTo('finance.investments.index-investments', 'render');
            $this->emit('alert');
            
        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e->getMessage());
            $this->emit('error_alert');
        } 
    }
}
