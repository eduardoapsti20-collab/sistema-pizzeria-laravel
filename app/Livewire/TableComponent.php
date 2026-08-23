<?php

namespace App\Livewire;

use App\Models\Table;
use Livewire\Component;
use Livewire\Attributes\On;
use Illuminate\Validation\Rule;

class TableComponent extends Component
{
    public $name = '';
    public $capacity = '';
    public $status = 'libre';
    public $color = '#f97316';
    public $table_id = null;
    public $search = '';
    public $statusFilter = '';
    public $isOpen = false;

    protected $listeners = ['updatePosition'];

    // AGREGADO: paleta rápida de colores para elegir en el modal,
    // por si el usuario no quiere usar el selector nativo del navegador.
    public $colorPalette = [
        '#f97316', // naranja (mesa)
        '#0ea5e9', // celeste (delivery)
        '#8b5cf6', // violeta (pedido)
        '#10b981', // verde
        '#ef4444', // rojo
        '#eab308', // amarillo
        '#64748b', // gris
        '#ec4899', // rosado
    ];

    public function render()
    {
        $tables = Table::query()
            ->where('name', 'like', '%' . $this->search . '%')
            ->when($this->statusFilter, function ($query) {
                $query->where('status', $this->statusFilter);
            })
            ->latest()
            ->get();

        return view('livewire.table-component', compact('tables'));
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
        $this->resetInputFields();
    }

    private function resetInputFields()
    {
        $this->reset(['name', 'capacity', 'status', 'table_id']);
        $this->color = '#f97316';
        $this->resetValidation();
    }

    /**
     * FIX CLAVE: guardamos la posición, pero le decimos a Livewire que
     * NO vuelva a renderizar/repintar la pantalla después de esto.
     * Así el navegador nunca recibe una versión "vieja" que pise el
     * movimiento que el usuario acaba de hacer con el mouse/dedo.
     */
    public function updatePosition($id, $x, $y)
    {
        Table::where('id', $id)->update([
            'x_pos' => $x,
            'y_pos' => $y
        ]);

        $this->skipRender();
    }

    public function autoArrange()
    {
        $tables = Table::orderBy('name')->get();

        $columns = 5;
        $spacingX = 220;
        $spacingY = 240;
        $startX = 20;
        $startY = 20;

        foreach ($tables as $index => $table) {
            $col = $index % $columns;
            $row = intdiv($index, $columns);

            $table->update([
                'x_pos' => $startX + ($col * $spacingX),
                'y_pos' => $startY + ($row * $spacingY),
            ]);
        }

        $this->dispatch('swal', [
            'title' => '¡Organizado!',
            'text'  => 'Las mesas fueron reordenadas en cuadrícula',
            'icon'  => 'success',
        ]);
    }

    public function store()
    {
        $this->validate([
            'name' => [
                'required',
                'min:2',
                'max:50',
                Rule::unique('tables', 'name')->ignore($this->table_id),
            ],
            'capacity' => 'required|integer|min:1',
            'status' => 'required|in:libre,ocupada,reservada',
            'color' => 'required|regex:/^#[0-9A-Fa-f]{6}$/',
        ]);

        Table::updateOrCreate(
            ['id' => $this->table_id],
            [
                'name' => $this->name,
                'capacity' => $this->capacity,
                'status' => $this->status,
                'color' => $this->color,
                'x_pos' => $this->table_id ? Table::find($this->table_id)->x_pos : 0,
                'y_pos' => $this->table_id ? Table::find($this->table_id)->y_pos : 0,
            ]
        );

        $this->dispatch('swal', [
            'title' => $this->table_id ? '¡Actualizada!' : '¡Creada!',
            'text'  => 'Mesa procesada correctamente',
            'icon'  => 'success',
        ]);

        $this->closeModal();
    }

    public function edit($id)
    {
        $table = Table::findOrFail($id);
        $this->table_id = $table->id;
        $this->name = $table->name;
        $this->capacity = $table->capacity;
        $this->status = $table->status;
        $this->color = $table->color ?? '#f97316';
        $this->openModal();
    }

    public function deleteConfirm($id)
    {
        $this->dispatch('confirm-delete', id: $id);
    }

    #[On('delete-confirmed')]
    public function destroy($id)
    {
        Table::findOrFail($id)->delete();
        $this->dispatch('swal', [
            'title' => 'Eliminada',
            'text'  => 'Mesa enviada a la papelera',
            'icon'  => 'success',
        ]);
    }
}