<?php

namespace App\Livewire;

use App\Models\Product;
use App\Models\Category;
use App\Models\ProductSize;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On;
use Illuminate\Validation\Rule;
use Livewire\WithFileUploads;

class ProductComponent extends Component
{
    use WithPagination, WithFileUploads;

    public $product_id = null;
    public $category_id = '';
    public $name = '';
    public $price = '';
    public $stock = '';
    public $status = 1;
    public $requires_kitchen = 0;
    public $image, $old_image;

    // AGREGADO: soporte de tamaños (Familiar/Grande/XL, etc.)
    public $has_sizes = false;
    public $sizes = []; // [['name' => 'Familiar', 'price' => 30], ...]

    public $search = '';
    public $isOpen = false;
    public $perPage = 10; // AGREGADO: cantidad de productos por página (10/25/50/'all')

    public function updatingSearch()
    {
        $this->resetPage();
    }

    // AGREGADO: reiniciar a la página 1 cuando cambia la cantidad por página
    public function updatingPerPage()
    {
        $this->resetPage();
    }

    public function render()
    {
        // AGREGADO: si eligen "Todos", usamos un número muy alto en vez de desactivar la paginación
        $perPageValue = $this->perPage === 'all' ? 1000000 : (int) $this->perPage;

        $products = Product::with(['category', 'sizes'])
            ->where('name', 'like', '%' . $this->search . '%')
            ->orderBy('id', 'asc')
            ->paginate($perPageValue);

        $categories = Category::orderBy('name', 'asc')->get();

        return view('livewire.product-component', compact('products', 'categories'));
    }

    public function create()
    {
        $this->resetInputFields();
        $this->openModal();
    }

    public function openModal()
    {
        $this->isOpen = true;
    }

    public function closeModal()
    {
        $this->isOpen = false;
    }

    private function resetInputFields()
    {
        $this->reset(['product_id', 'category_id', 'name', 'requires_kitchen', 'price', 'stock', 'status', 'image', 'old_image', 'has_sizes', 'sizes']);
        $this->status = 1;
        $this->resetValidation();
    }

    // AGREGADO: agregar una fila nueva de tamaño
    public function addSize()
    {
        $this->sizes[] = ['name' => '', 'price' => ''];
    }

    // AGREGADO: quitar una fila de tamaño
    public function removeSize($index)
    {
        unset($this->sizes[$index]);
        $this->sizes = array_values($this->sizes);
    }

    // AGREGADO: al prender/apagar el switch, aseguramos al menos 1 fila cuando se activa
    public function updatedHasSizes($value)
    {
        if ($value && empty($this->sizes)) {
            $this->sizes = [
                ['name' => 'Familiar', 'price' => ''],
                ['name' => 'Grande', 'price' => ''],
                ['name' => 'XL', 'price' => ''],
            ];
        }
    }

    public function store()
    {
        $rules = [
            'category_id' => 'required|exists:categories,id',
            'name' => ['required', 'min:2', Rule::unique('products', 'name')->ignore($this->product_id)],
            'stock' => 'nullable|integer',
            'status' => 'required|boolean',
            'requires_kitchen' => 'required|boolean',
            'image' => $this->product_id ? 'nullable|image|max:2048' : 'required|image|max:2048',
        ];

        // AGREGADO: price solo es obligatorio si el producto NO tiene tamaños.
        // Si tiene tamaños, se valida el array de sizes en su lugar.
        if ($this->has_sizes) {
            $rules['sizes'] = 'required|array|min:1';
            $rules['sizes.*.name'] = 'required|string|max:50';
            $rules['sizes.*.price'] = 'required|numeric|min:0';
        } else {
            $rules['price'] = 'required|numeric';
        }

        $this->validate($rules);

        $data = [
            'category_id' => $this->category_id,
            'name'        => $this->name,
            // Si tiene tamaños, guardamos el precio más bajo como referencia en `price`
            // (útil para ordenar/filtrar por precio en otras partes del sistema).
            'price'       => $this->has_sizes ? collect($this->sizes)->min('price') : $this->price,
            // CORREGIDO: stock puede venir como '' (string vacío) del input, y MySQL
            // rechaza eso para una columna entera aunque sea nullable. Se convierte a null.
            'stock'       => $this->stock !== '' && $this->stock !== null ? $this->stock : null,
            'status'      => $this->status,
            'requires_kitchen' => $this->requires_kitchen
        ];

        if ($this->image) {
            if ($this->old_image) {
                Storage::disk('public')->delete($this->old_image);
            }
            $data['image'] = $this->image->store('products', 'public');
        }

        $product = Product::updateOrCreate(['id' => $this->product_id], $data);

        // AGREGADO: sincronizar tamaños (borra los viejos y crea los actuales, simple y seguro)
        $product->sizes()->delete();
        if ($this->has_sizes) {
            foreach ($this->sizes as $i => $size) {
                $product->sizes()->create([
                    'name'  => $size['name'],
                    'price' => $size['price'],
                    'order' => $i,
                ]);
            }
        }

        $this->dispatch('swal', [
            'title' => $this->product_id ? '¡Actualizado!' : '¡Creado!',
            'text'  => 'El plato se guardó correctamente',
            'icon'  => 'success',
        ]);

        $this->closeModal();
        $this->resetInputFields();
    }

    public function edit($id)
    {
        $product = Product::with('sizes')->findOrFail($id);
        $this->product_id  = $product->id;
        $this->category_id = $product->category_id;
        $this->name        = $product->name;
        $this->price       = $product->price;
        $this->stock       = $product->stock;
        $this->status      = $product->status;
        $this->requires_kitchen = $product->requires_kitchen;
        $this->old_image   = $product->image;

        // AGREGADO: cargar tamaños existentes si los tiene
        if ($product->sizes->isNotEmpty()) {
            $this->has_sizes = true;
            $this->sizes = $product->sizes->map(fn($s) => [
                'name' => $s->name,
                'price' => $s->price,
            ])->toArray();
        } else {
            $this->has_sizes = false;
            $this->sizes = [];
        }

        $this->openModal();
    }

    public function deleteConfirm($id)
    {
        $this->dispatch('confirm-delete', id: $id);
    }

    #[On('delete-confirmed')]
    public function destroy($id)
    {
        Product::findOrFail($id)->delete();

        $this->dispatch('swal', [
            'title' => 'Eliminado',
            'text'  => 'Producto enviado a la papelera',
            'icon'  => 'success',
        ]);
    }
}