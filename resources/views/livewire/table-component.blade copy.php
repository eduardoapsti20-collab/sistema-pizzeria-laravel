@php
    // Tamaño "real" (sin escalar) del lienzo de escritorio: se ajusta
    // automáticamente según dónde estén las mesas más lejanas.
    $canvasWidth = max(1200, ($tables->max('x_pos') ?? 0) + 260);
    $canvasHeight = max(820, ($tables->max('y_pos') ?? 0) + 280);
@endphp

<div class="min-h-screen">
    <div class="max-w-[1800px] mx-auto space-y-4" style="min-width: 0;">

        {{-- HEADER --}}
        <header class="bg-white border border-slate-200 px-6 py-4 rounded-xl shadow-sm space-y-4">
            <div class="flex flex-wrap items-center justify-between gap-4">
                <div class="flex items-center gap-3">
                    <div class="w-11 h-11 rounded-xl bg-orange-600 flex items-center justify-center text-white shadow-md shadow-orange-200">
                        <i class="fa-solid fa-pizza-slice text-lg"></i>
                    </div>
                    <div class="flex flex-col leading-tight">
                        <h1 class="text-lg font-black tracking-tighter text-slate-900 uppercase">
                            Distribución <span class="text-orange-600">de Salones</span>
                        </h1>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Mapa del local</p>
                    </div>
                </div>

                <div class="flex items-center gap-2">
                    {{-- El botón "Organizar" solo tiene sentido en el mapa arrastrable --}}
                    @can('mesas.editar')
                        <button wire:click="autoArrange"
                            wire:confirm="¿Reordenar todas las mesas en cuadrícula? Esto moverá las mesas de su posición actual."
                            class="hidden md:flex px-5 py-2.5 bg-white border border-slate-200 hover:border-orange-400 hover:text-orange-600 text-slate-600 text-[11px] font-black rounded-lg transition-all active:scale-95 uppercase tracking-widest items-center gap-2">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path d="M4 6h16M4 12h16M4 18h16" stroke-width="2" stroke-linecap="round" />
                            </svg>
                            Organizar
                        </button>
                    @endcan

                    @can('mesas.crear')
                        <button wire:click="create"
                            class="px-5 py-2.5 bg-slate-900 hover:bg-orange-600 text-white text-[11px] font-black rounded-lg transition-all active:scale-95 shadow-lg shadow-slate-200 uppercase tracking-widest">
                            + Añadir Mesa
                        </button>
                    @endcan
                </div>
            </div>

            {{-- BARRA DE CONTROLES: buscador + filtros + contador en vivo --}}
            <div class="flex flex-wrap items-center justify-between gap-3 pt-3 border-t border-slate-100">
                <div class="flex flex-wrap items-center gap-2">
                    <div class="relative">
                        <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-3 text-slate-400 text-xs"></i>
                        <input wire:model.live.debounce.300ms="search" type="text" placeholder="Buscar mesa..."
                            class="bg-slate-50 border border-slate-200 rounded-lg pl-9 pr-4 py-2.5 text-xs font-semibold w-full sm:w-56 focus:ring-4 focus:ring-orange-500/10 focus:border-orange-500 outline-none transition-all">
                    </div>

                    <div class="flex items-center gap-1 bg-slate-50 border border-slate-200 rounded-lg p-1 overflow-x-auto">
                        <button wire:click="$set('statusFilter', '')"
                            class="px-3 py-1.5 text-[10px] font-black uppercase rounded-md transition-all whitespace-nowrap {{ $statusFilter === '' ? 'bg-slate-900 text-white shadow' : 'text-slate-500 hover:text-slate-800' }}">
                            Todas
                        </button>
                        <button wire:click="$set('statusFilter', 'libre')"
                            class="px-3 py-1.5 text-[10px] font-black uppercase rounded-md transition-all flex items-center gap-1.5 whitespace-nowrap {{ $statusFilter === 'libre' ? 'bg-emerald-600 text-white shadow' : 'text-slate-500 hover:text-slate-800' }}">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Libres
                        </button>
                        <button wire:click="$set('statusFilter', 'ocupada')"
                            class="px-3 py-1.5 text-[10px] font-black uppercase rounded-md transition-all flex items-center gap-1.5 whitespace-nowrap {{ $statusFilter === 'ocupada' ? 'bg-red-600 text-white shadow' : 'text-slate-500 hover:text-slate-800' }}">
                            <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span> Ocupadas
                        </button>
                        <button wire:click="$set('statusFilter', 'reservada')"
                            class="px-3 py-1.5 text-[10px] font-black uppercase rounded-md transition-all flex items-center gap-1.5 whitespace-nowrap {{ $statusFilter === 'reservada' ? 'bg-amber-600 text-white shadow' : 'text-slate-500 hover:text-slate-800' }}">
                            <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span> Reservadas
                        </button>
                    </div>
                </div>

                {{-- CONTADOR EN VIVO --}}
                <div class="flex items-center gap-4 text-[11px] font-bold text-slate-500">
                    <span class="flex items-center gap-1.5">
                        <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                        {{ $tables->where('status', 'libre')->count() }} Libres
                    </span>
                    <span class="flex items-center gap-1.5">
                        <span class="w-2 h-2 rounded-full bg-red-500"></span>
                        {{ $tables->where('status', 'ocupada')->count() }} Ocupadas
                    </span>
                    <span class="flex items-center gap-1.5">
                        <span class="w-2 h-2 rounded-full bg-amber-500"></span>
                        {{ $tables->where('status', 'reservada')->count() }} Reservadas
                    </span>
                    <span class="text-slate-300">|</span>
                    <span>{{ $tables->count() }} Total</span>
                </div>
            </div>

            {{-- Pista solo visible en el mapa de escritorio --}}
            <div class="hidden md:flex items-center gap-1.5 text-[10px] font-bold text-slate-400 -mt-1">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path d="M8 9l-4 4 4 4m8-8l4 4-4 4M12 3v18" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
                El mapa se ajusta automáticamente para mostrar todas tus mesas
            </div>
        </header>

        {{-- ============================================================ --}}
        {{-- VERSIÓN ESCRITORIO / TABLET: mapa arrastrable, auto-escalado  --}}
        {{-- para que TODAS las mesas quepan siempre en el recuadro       --}}
        {{-- ============================================================ --}}
        <div id="floor-canvas"
            class="hidden md:block relative w-full bg-slate-50 rounded-xl border border-slate-200 shadow-[inset_0_2px_10px_rgba(0,0,0,0.05)] overflow-auto"
            style="max-height: 75vh; min-height: 420px; -webkit-overflow-scrolling: touch; box-sizing: border-box;">

            <div id="floor-content" class="relative p-10"
                data-base-width="{{ $canvasWidth }}"
                data-base-height="{{ $canvasHeight }}"
                style="width: {{ $canvasWidth }}px; height: {{ $canvasHeight }}px; transform-origin: top left; margin: 0 auto;">

                <div class="absolute inset-0 opacity-[0.2] pointer-events-none"
                    style="background-image: radial-gradient(#64748b 1px, transparent 1px); background-size: 40px 40px;">
                </div>

                @forelse($tables as $table)
                    <div wire:key="table-desktop-{{ $table->id }}" data-id="{{ $table->id }}" data-x="{{ $table->x_pos }}"
                        data-y="{{ $table->y_pos }}" class="draggable-table absolute group active:z-50"
                        style="transform: translate({{ $table->x_pos }}px, {{ $table->y_pos }}px);">

                        <div class="relative w-48 h-fit flex flex-col items-center">
                            <div class="relative w-40 h-40 flex items-center justify-center">
                                <div class="absolute inset-6 rounded-full border-4 transition-all
                                    {{ $table->status === 'ocupada' ? 'border-red-300' : ($table->status === 'reservada' ? 'border-amber-300' : 'border-emerald-200') }}">
                                </div>

                                <img src="{{ asset('images/table.jpg') }}" draggable="false"
                                    class="w-36 h-36 object-contain transition-all duration-200 cursor-grab active:cursor-grabbing select-none drop-shadow-[0_20px_20px_rgba(0,0,0,0.2)] group-hover:scale-105"
                                    style="mix-blend-mode: multiply;" alt="Mesa">

                                <div class="absolute top-2 right-2 z-10">
                                    <span class="relative flex h-5 w-5">
                                        @if ($table->status === 'ocupada')
                                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                                            <span class="relative inline-flex rounded-full h-5 w-5 bg-red-500 border-2 border-white shadow-md"></span>
                                        @elseif ($table->status === 'reservada')
                                            <span class="animate-pulse absolute inline-flex h-full w-full rounded-full bg-amber-400 opacity-75"></span>
                                            <span class="relative inline-flex rounded-full h-5 w-5 bg-amber-500 border-2 border-white shadow-md"></span>
                                        @else
                                            <span class="relative inline-flex rounded-full h-5 w-5 bg-emerald-500 border-2 border-white shadow-md"></span>
                                        @endif
                                    </span>
                                </div>
                            </div>

                            @include('livewire.partials.mesa-card', ['table' => $table])
                        </div>
                    </div>
                @empty
                    <div class="absolute inset-0 flex flex-col items-center justify-center opacity-40 pointer-events-none gap-3">
                        <i class="fa-solid fa-pizza-slice text-5xl text-slate-300"></i>
                        <span class="text-2xl font-black uppercase tracking-[0.3em] text-slate-400 text-center">No hay mesas</span>
                        <span class="text-xs font-semibold text-slate-400">Prueba cambiando el filtro o la búsqueda</span>
                    </div>
                @endforelse
            </div>
        </div>

        {{-- Controles de zoom manual (opcional, por si el usuario quiere ajustar fino) --}}
        <div class="hidden md:flex items-center gap-2 -mt-2" style="justify-content: flex-end;">
            <button type="button" onclick="window.__floorZoom(-0.1)"
                class="w-8 h-8 flex items-center justify-center bg-white border border-slate-200 rounded-lg text-slate-500 hover:text-orange-600 hover:border-orange-400 text-sm font-black">−</button>
            <button type="button" onclick="window.__floorZoom('fit')"
                class="px-3 h-8 flex items-center justify-center bg-white border border-slate-200 rounded-lg text-slate-500 hover:text-orange-600 hover:border-orange-400 text-[10px] font-black uppercase tracking-widest">Ajustar</button>
            <button type="button" onclick="window.__floorZoom(0.1)"
                class="w-8 h-8 flex items-center justify-center bg-white border border-slate-200 rounded-lg text-slate-500 hover:text-orange-600 hover:border-orange-400 text-sm font-black">+</button>
        </div>

        {{-- ============================================================ --}}
        {{-- VERSIÓN MÓVIL: lista en cuadrícula, scroll vertical normal --}}
        {{-- Pensada para gestionar pedidos rápido, sin arrastrar nada    --}}
        {{-- ============================================================ --}}
        <div class="block md:hidden">
            @if($tables->count() > 0)
                <div class="grid grid-cols-2 gap-3">
                    @foreach($tables as $table)
                        <div wire:key="table-mobile-{{ $table->id }}"
                            class="bg-slate-50 rounded-xl border border-slate-200 p-2 flex flex-col items-center">
                            <div class="relative w-24 h-24 flex items-center justify-center mb-1">
                                <div class="absolute inset-3 rounded-full border-4
                                    {{ $table->status === 'ocupada' ? 'border-red-300' : ($table->status === 'reservada' ? 'border-amber-300' : 'border-emerald-200') }}">
                                </div>
                                <img src="{{ asset('images/table.jpg') }}" draggable="false"
                                    class="w-20 h-20 object-contain select-none" style="mix-blend-mode: multiply;" alt="Mesa">
                                <div class="absolute top-0 right-0 z-10">
                                    <span class="relative flex h-4 w-4">
                                        @if ($table->status === 'ocupada')
                                            <span class="relative inline-flex rounded-full h-4 w-4 bg-red-500 border-2 border-white shadow-md"></span>
                                        @elseif ($table->status === 'reservada')
                                            <span class="relative inline-flex rounded-full h-4 w-4 bg-amber-500 border-2 border-white shadow-md"></span>
                                        @else
                                            <span class="relative inline-flex rounded-full h-4 w-4 bg-emerald-500 border-2 border-white shadow-md"></span>
                                        @endif
                                    </span>
                                </div>
                            </div>

                            @include('livewire.partials.mesa-card', ['table' => $table])
                        </div>
                    @endforeach
                </div>
            @else
                <div class="bg-slate-50 rounded-xl border border-slate-200 py-16 flex flex-col items-center gap-3">
                    <i class="fa-solid fa-pizza-slice text-4xl text-slate-300"></i>
                    <span class="text-lg font-black uppercase tracking-widest text-slate-400">No hay mesas</span>
                    <span class="text-xs font-semibold text-slate-400">Prueba cambiando el filtro o la búsqueda</span>
                </div>
            @endif
        </div>
    </div>

    {{-- MODAL --}}
    @if ($isOpen)
        <div class="fixed inset-0 z-[100] flex items-center justify-center p-4">
            <div class="absolute inset-0 bg-slate-900/40 backdrop-blur-sm" wire:click="closeModal"></div>
            <div class="relative bg-white border border-slate-200 rounded-2xl w-full max-w-md shadow-2xl overflow-hidden animate-in fade-in zoom-in duration-150">
                <div class="p-8">
                    <div class="flex items-center justify-between mb-8">
                        <div>
                            <h2 class="text-xl font-black text-slate-900 tracking-tight">Propiedades</h2>
                            <p class="text-[10px] font-bold text-orange-600 uppercase tracking-widest">Configuración de Mesa</p>
                        </div>
                        <button wire:click="closeModal" class="text-slate-400 hover:text-slate-900 uppercase text-[10px] font-black tracking-widest">Cerrar</button>
                    </div>

                    <form wire:submit.prevent="store" class="space-y-6">
                        <div class="space-y-1">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Etiqueta de Mesa</label>
                            <input wire:model="name" type="text" placeholder="ID-001"
                                class="w-full bg-slate-50 border border-slate-200 focus:border-orange-500 rounded-xl px-4 py-3 text-sm font-bold outline-none transition-all">
                            @error('name')
                                <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div class="space-y-1">
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Capacidad</label>
                                <input wire:model="capacity" type="number"
                                    class="w-full bg-slate-50 border border-slate-200 focus:border-orange-500 rounded-xl px-4 py-3 text-sm font-bold outline-none">
                                @error('capacity')
                                    <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="space-y-1">
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Estado</label>
                                <select wire:model="status"
                                    class="w-full bg-slate-50 border border-slate-200 focus:border-orange-500 rounded-xl px-4 py-3 text-sm font-bold outline-none appearance-none">
                                    <option value="libre">Disponible</option>
                                    <option value="ocupada">Ocupada</option>
                                    <option value="reservada">Reservada</option>
                                </select>
                                @error('status')
                                    <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <button type="submit"
                            class="w-full py-4 bg-slate-900 hover:bg-orange-600 text-white text-[11px] font-black rounded-xl transition-all uppercase tracking-[0.2em] shadow-lg shadow-slate-200">
                            Actualizar Nodo
                        </button>
                    </form>
                </div>
            </div>
        </div>
    @endif

    {{-- ============================================================ --}}
    {{-- ESTILOS Y SCRIPT DE ARRASTRE + AUTO-ESCALADO (solo desktop)   --}}
    {{-- ============================================================ --}}
    <style>
        .draggable-table {
            touch-action: none;
            -webkit-user-select: none;
            user-select: none;
        }
        .draggable-table img {
            -webkit-user-drag: none;
            pointer-events: none;
        }
        #floor-canvas::-webkit-scrollbar { height: 10px; width: 10px; }
        #floor-canvas::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 999px; }
        #floor-canvas::-webkit-scrollbar-track { background: transparent; }
        #floor-content { transition: transform 0.15s ease-out; }
    </style>

    <script src="https://cdn.jsdelivr.net/npm/interactjs/dist/interact.min.js"></script>
    <script>
        (function () {
            // Escala actual del mapa. Se usa tanto para dibujar el zoom
            // como para corregir el arrastre (interact.js mide el mouse
            // en píxeles de pantalla, no en píxeles "del mapa").
            window.__floorScale = 1;
            let manualZoom = null; // null = modo automático ("ajustar a pantalla")

            function computeFitScale() {
                const canvas = document.getElementById('floor-canvas');
                const content = document.getElementById('floor-content');
                if (!canvas || !content) return 1;

                const baseW = parseFloat(content.dataset.baseWidth) || content.offsetWidth;
                const baseH = parseFloat(content.dataset.baseHeight) || content.offsetHeight;

                const availW = canvas.clientWidth - 24;
                const availH = canvas.clientHeight - 24;

                if (baseW <= 0 || baseH <= 0 || availW <= 0 || availH <= 0) return 1;

                let scale = Math.min(availW / baseW, availH / baseH);

                // No dejar que se achique demasiado (ilegible) ni que se
                // agrande de más cuando hay pocas mesas.
                scale = Math.max(0.35, Math.min(scale, 1.25));

                return scale;
            }

            function applyFloorScale() {
                const content = document.getElementById('floor-content');
                if (!content) return;

                const scale = manualZoom !== null ? manualZoom : computeFitScale();
                window.__floorScale = scale;
                content.style.transform = 'scale(' + scale + ')';
            }

            window.__floorZoom = function (delta) {
                if (delta === 'fit') {
                    manualZoom = null;
                } else {
                    const current = manualZoom !== null ? manualZoom : computeFitScale();
                    manualZoom = Math.max(0.3, Math.min(current + delta, 2));
                }
                applyFloorScale();
            };

            function refit() {
                requestAnimationFrame(applyFloorScale);
            }

            window.addEventListener('resize', refit);
            document.addEventListener('DOMContentLoaded', refit);

            document.addEventListener('livewire:init', function () {
                refit();

                // Reajustar el zoom después de cualquier acción que pueda
                // cambiar la cantidad de mesas o el tamaño del lienzo
                // (buscar, filtrar, crear, eliminar, organizar...).
                Livewire.hook('commit', ({ succeed }) => {
                    succeed(() => setTimeout(refit, 30));
                });

                const GRID_SIZE = 20;

                interact('.draggable-table').draggable({
                    inertia: false,
                    modifiers: [
                        interact.modifiers.snap({
                            targets: [interact.snappers.grid({ x: GRID_SIZE, y: GRID_SIZE })],
                            range: Infinity,
                            relativePoints: [{ x: 0, y: 0 }],
                            endOnly: true
                        }),
                        interact.modifiers.restrictRect({
                            restriction: '#floor-content',
                            endOnly: true
                        })
                    ],
                    listeners: {
                        move(event) {
                            // Dividimos por la escala actual: si el mapa está
                            // reducido al 60%, cada píxel de mouse debe mover
                            // la mesa 1/0.6 px en el sistema de coordenadas
                            // real del mapa, o si no, el arrastre se sentiría
                            // "pegado" o iría más rápido/lento de lo esperado.
                            const scale = window.__floorScale || 1;
                            var target = event.target;
                            var x = (parseFloat(target.getAttribute('data-x')) || 0) + event.dx / scale;
                            var y = (parseFloat(target.getAttribute('data-y')) || 0) + event.dy / scale;
                            target.style.transform = 'translate(' + x + 'px, ' + y + 'px)';
                            target.setAttribute('data-x', x);
                            target.setAttribute('data-y', y);
                        },
                        end(event) {
                            const id = event.target.getAttribute('data-id');
                            const x = event.target.getAttribute('data-x');
                            const y = event.target.getAttribute('data-y');
                            @this.updatePosition(id, x, y);
                        }
                    }
                });
            });
        })();
    </script>
</div>