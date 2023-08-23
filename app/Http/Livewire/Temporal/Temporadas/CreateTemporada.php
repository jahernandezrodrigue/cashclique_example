<?php

namespace App\Http\Livewire\Temporal\Temporadas;

use App\Http\Livewire\BaseComponent;
use App\Models\Temporal\Temporada;
use DB, Log;

class CreateTemporada extends BaseComponent
{
    public $open = false;
    public $isEdit = false;

    public Temporada $temporada;

    /**
     * rules 
     */
    protected $rules = [
        'temporada.name' => 'required',
        'temporada.isActive' => 'boolean',
    ];

    /**
     * Listeners
     */
    protected $listeners=[
        'createTemporada' => 'createTemporada',
        'editTemporada' => 'editTemporada',
        'closeModal' => 'closeModal',
        'render' => 'render',
    ];

    /**
     * render
     */
    public function render()
    {
        return view('livewire.temporal.temporadas.create-temporada');
    }

    /**
     * mount
     */
    public function mount()
    {
        // parent::mount();
        
        $this->temporada = new Temporada();
        $this->temporada->isActive = true;
    }

    /**
     * method open create
     */
    public function createTemporada()
    {
        $this->isEdit = false;
        $this->open = true;
    }

    /**
     * method open edit
     */
    public function editTemporada(Temporada $temporada)
    {
        $this->temporada = $temporada;
        $this->isEdit = true;
        $this->open = true;
    }

    /**
     * method close modal
     */
    public function closeModal()
    {
        $this->reset(['open', 'isEdit']);
        $this->temporada = new Temporada();
        $this->temporada->isActive = true;
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
            // Create Temporada
            $temporada = $this->temporada;
            $temporada->save();

            // Commit Transaction
            DB::commit();

            $this->reset(['open', 'isEdit']);
            $this->temporada = new Temporada();
            $this->temporada->isActive = true;
            $this->emitTo('temporal.temporadas.index-temporadas', 'render');
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
            // Create Temporada
            $temporada = $this->temporada;
            $temporada->save();

            // Commit Transaction
            DB::commit();

            $this->reset(['open', 'isEdit']);
            $this->temporada = new Temporada();
            $this->temporada->isActive = true;
            $this->emitTo('temporal.temporadas.index-temporadas', 'render');
            $this->emit('alert');
            
        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e->getMessage());
            $this->emit('error_alert');
        } 
    }
}
