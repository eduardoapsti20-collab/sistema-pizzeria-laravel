{{-- Tarjeta de información de la mesa. Recibe: $table --}}
<div class="w-full mt-2 bg-white border border-slate-200 rounded-xl p-3 shadow-[0_10px_25px_-5px_rgba(0,0,0,0.1)] group-hover:border-orange-400 transition-all">
    <div class="flex justify-between items-start mb-3">
        <div class="flex flex-col">
            <span class="text-[13px] font-black text-slate-800 uppercase tracking-tighter leading-none">{{ $table->name }}</span>
            <span class="text-[10px] font-bold text-slate-400 mt-1">{{ $table->capacity }} PAX</span>
        </div>
        <div class="flex gap-1">
            @can('mesas.editar')
                <button wire:click="edit({{ $table->id }})"
                    class="p-1 text-slate-400 hover:text-orange-600 transition-colors">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </button>
            @endcan
            @can('mesas.eliminar')
                <button wire:click="deleteConfirm({{ $table->id }})"
                    class="p-1 text-slate-400 hover:text-red-600 transition-colors">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </button>
            @endcan
        </div>
    </div>

    <div class="mb-2">
        @if ($table->status === 'ocupada')
            <span class="inline-block text-[9px] font-black uppercase tracking-wider text-red-700 bg-red-50 border border-red-100 px-2 py-0.5 rounded-md">Ocupada</span>
        @elseif ($table->status === 'reservada')
            <span class="inline-block text-[9px] font-black uppercase tracking-wider text-amber-700 bg-amber-50 border border-amber-100 px-2 py-0.5 rounded-md">Reservada</span>
        @else
            <span class="inline-block text-[9px] font-black uppercase tracking-wider text-emerald-700 bg-emerald-50 border border-emerald-100 px-2 py-0.5 rounded-md">Libre</span>
        @endif
    </div>

    @can('ordenes.crear')
        <div class="grid grid-cols-1 gap-2">
            <a href="{{ route('orders.create', encrypt($table->id)) }}"
                class="flex items-center justify-center py-2 bg-orange-600 text-white text-[10px] font-bold uppercase rounded-lg hover:bg-orange-700 transition-all shadow-sm">
                Gestionar
            </a>
        </div>
    @endcan
</div>