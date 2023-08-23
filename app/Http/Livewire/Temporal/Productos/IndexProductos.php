<?php

namespace App\Http\Livewire\Temporal\Productos;

use App\Http\Livewire\BaseComponent;
use App\Models\Temporal\Producto;
use DB, Log;

class IndexProductos extends BaseComponent
{
    public $search;
    public $sort = 'id';
    public $direction = 'desc';
    public $cant = 10;
    
    public Producto $producto;

    /**
     * Listeners.
     */
    protected $listeners=['render' => 'render', 'deleteProducto' => 'delete'];

    public function render()
    {
        $query = Producto::query();
        $query->orderby($this->sort, $this->direction);
        $query->where('name', 'like', '%'. $this->search .'%');
        $productos = $query->paginate($this->cant);
        return view('livewire.temporal.productos.index-productos', compact('productos'));
    }

    public function order($sort)
    {
        if ($this->sort==$sort)
        {
            if ($this->direction=='desc'){
                $this->direction='asc';
            }
            else{
                $this->direction='desc';
            }

        } else {
            $this->sort=$sort;
            $this->direction=='asc';
        }
    }

    public function delete(Producto $producto) {
        DB::beginTransaction();
        try {
            $producto->delete();

            // Commit Transaction
            DB::commit();

            $this->emit('alert');
        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e->getMessage());
            $this->emit('error_alert');
        }
    }
}
