<?php

namespace App\Http\Livewire\Temporal\Productos;

use App\Http\Livewire\BaseComponent;
use App\Models\Temporal\Producto;
use DB, Log;

class CreateProducto extends BaseComponent
{
    public $open = false;
    public $isEdit = false;

    public Producto $producto;

    /**
     * rules 
     */
    protected $rules = [
        'producto.name' => 'required',
        'producto.isActive' => 'boolean',
    ];

    /**
     * Listeners
     */
    protected $listeners=[
        'createProducto' => 'createProducto',
        'editProducto' => 'editProducto',
        'closeModal' => 'closeModal',
        'render' => 'render',
    ];

    /**
     * render
     */
    public function render()
    {
        return view('livewire.temporal.productos.create-producto');
    }

    /**
     * mount
     */
    public function mount()
    {
        // parent::mount();
        
        $this->producto = new Producto();
        $this->producto->isActive = true;
    }

    /**
     * method open create
     */
    public function createProducto()
    {
        $this->isEdit = false;
        $this->open = true;
    }

    /**
     * method open edit
     */
    public function editProducto(Producto $producto)
    {
        $this->producto = $producto;
        $this->isEdit = true;
        $this->open = true;
    }

    /**
     * method close modal
     */
    public function closeModal()
    {
        $this->reset(['open', 'isEdit']);
        $this->producto = new Producto();
        $this->producto->isActive = true;
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
            // Create Producto
            $producto = $this->producto;
            $producto->save();

            // Commit Transaction
            DB::commit();

            $this->reset(['open', 'isEdit']);
            $this->producto = new Producto();
            $this->producto->isActive = true;
            $this->emitTo('temporal.productos.index-productos', 'render');
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
            // Create Producto
            $producto = $this->producto;
            $producto->save();

            // Commit Transaction
            DB::commit();

            $this->reset(['open', 'isEdit']);
            $this->producto = new Producto();
            $this->producto->isActive = true;
            $this->emitTo('temporal.productos.index-productos', 'render');
            $this->emit('alert');
            
        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e->getMessage());
            $this->emit('error_alert');
        } 
    }
}
