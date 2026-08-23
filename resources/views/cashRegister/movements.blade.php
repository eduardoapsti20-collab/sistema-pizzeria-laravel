<x-admin-layout>
    <div class="mx-auto animate-fade-in text-slate-700 relative overflow-hidden">

        {{-- MARCA DE AGUA (Solo visible si la caja está cerrada) --}}
        @if ($caja->status == 'closed' || $caja->status == 'cerrado')
            <div
                class="absolute inset-0 flex items-center justify-center pointer-events-none z-0 opacity-[0.03] rotate-[-12deg]">
                <h2 class="text-[12rem] font-black uppercase tracking-tighter">Cerrada</h2>
            </div>
        @endif

        <div class="relative z-10 space-y-6">

            {{-- HEADER --}}
            <div
                class="flex flex-col sm:flex-row justify-between items-center gap-4 bg-white/80 backdrop-blur-md p-5 rounded-2xl border border-slate-200 shadow-sm">
                <div class="flex items-center gap-4">
                    <div
                        class="w-12 h-12 {{ $caja->status == 'open' || $caja->status == 'abierto' ? 'bg-indigo-600' : 'bg-slate-400' }} rounded-xl flex items-center justify-center shadow-md">
                        <i class="fa-solid fa-vault text-xl text-white"></i>
                    </div>
                    <div>
                        <a href="{{ route('boxes.index') }}"
                            class="text-indigo-600 text-[10px] font-bold uppercase tracking-wider hover:underline flex items-center gap-1">
                            <i class="fa-solid fa-chevron-left text-[8px]"></i> Volver
                        </a>
                        <h1 class="text-xl font-bold text-slate-900 tracking-tight flex items-center gap-2">
                            {{ $caja->name }}
                            @if ($caja->status == 'closed' || $caja->status == 'cerrado')
                                <span
                                    class="bg-slate-100 text-slate-500 text-[10px] px-2 py-0.5 rounded-full uppercase italic">Cerrada</span>
                            @endif
                        </h1>
                        <p class="text-slate-500 text-xs">Usuario: <span
                                class="font-semibold">{{ $caja->opener->name }}</span></p>
                    </div>
                </div>

                <div class="flex items-center gap-2">
                    <a href="{{ route('boxes.movements', [$id, 'action' => 'pdf']) }}" target="_blank"
                        class="bg-slate-900 hover:bg-slate-800 text-white px-4 py-2 rounded-lg text-xs font-bold transition-all flex items-center gap-2 shadow-sm">
                        <i class="fa-solid fa-file-pdf"></i> REPORTE
                    </a>
                </div>
            </div>

            {{-- RESUMEN GENERAL (NUEVO: Apertura / Ventas / Gastos / Actual, separado de un vistazo) --}}
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">

                <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm">
                    <div class="flex items-center gap-2 mb-2">
                        <div class="w-8 h-8 bg-slate-100 rounded-lg flex items-center justify-center">
                            <i class="fa-solid fa-door-open text-slate-500 text-xs"></i>
                        </div>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Apertura</p>
                    </div>
                    <p class="text-xl font-bold text-slate-900">
                        <span
                            class="text-slate-400 text-sm font-medium mr-0.5">{{ $caja->opener->business->currency_simbol ?? 'S/' }}</span>{{ number_format($caja->opening_amount, 2) }}
                    </p>
                    <p class="text-[10px] text-slate-400 mt-1">
                        {{ ($caja->opened_at ?? $caja->created_at)->format('d/m/Y h:i A') }}
                    </p>
                </div>

                <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm">
                    <div class="flex items-center gap-2 mb-2">
                        <div class="w-8 h-8 bg-emerald-50 rounded-lg flex items-center justify-center">
                            <i class="fa-solid fa-arrow-trend-up text-emerald-600 text-xs"></i>
                        </div>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Ventas</p>
                    </div>
                    <p class="text-xl font-bold text-emerald-600">
                        +{{ $caja->opener->business->currency_simbol ?? 'S/' }}{{ number_format($caja->sales->sum('total'), 2) }}
                    </p>
                    <p class="text-[10px] text-slate-400 mt-1">{{ $caja->sales->count() }} venta(s)</p>
                </div>

                <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm">
                    <div class="flex items-center gap-2 mb-2">
                        <div class="w-8 h-8 bg-rose-50 rounded-lg flex items-center justify-center">
                            <i class="fa-solid fa-arrow-trend-down text-rose-600 text-xs"></i>
                        </div>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Gastos</p>
                    </div>
                    <p class="text-xl font-bold text-rose-600">
                        -{{ $caja->opener->business->currency_simbol ?? 'S/' }}{{ number_format($gastos->sum('amount'), 2) }}
                    </p>
                    <p class="text-[10px] text-slate-400 mt-1">{{ $gastos->count() }} gasto(s)</p>
                </div>

                <div class="bg-indigo-600 p-5 rounded-xl border border-indigo-600 shadow-sm shadow-indigo-200">
                    <div class="flex items-center gap-2 mb-2">
                        <div class="w-8 h-8 bg-white/15 rounded-lg flex items-center justify-center">
                            <i class="fa-solid fa-wallet text-white text-xs"></i>
                        </div>
                        <p class="text-[10px] font-bold text-indigo-100 uppercase tracking-wider">Efectivo Actual</p>
                    </div>
                    <p class="text-xl font-bold text-white">
                        <span
                            class="text-indigo-200 text-sm font-medium mr-0.5">{{ $caja->opener->business->currency_simbol ?? 'S/' }}</span>{{ number_format($caja->current_amount, 2) }}
                    </p>
                    <p class="text-[10px] text-indigo-200 mt-1">Apertura + Ventas − Gastos</p>
                </div>

            </div>

            {{-- GRID DE MÉTODOS DE PAGO --}}
            <div>
                <h3 class="text-slate-800 font-bold text-xs uppercase mb-3 flex items-center gap-2">
                    <i class="fa-solid fa-layer-group text-slate-400"></i> Desglose por Método de Pago
                </h3>
                <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
                    @foreach ($pagosPorMetodo as $metodo => $total)
                        <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm">
                            <div class="flex items-center gap-3 mb-2">
                                <div class="w-8 h-8 bg-indigo-50 rounded-lg flex items-center justify-center">
                                    <i class="fa-solid fa-wallet text-indigo-500 text-xs"></i>
                                </div>
                                <p class="text-[11px] font-bold text-slate-500 uppercase tracking-tight">{{ $metodo }}
                                </p>
                            </div>
                            <p class="text-xl font-bold text-slate-900">
                                <span
                                    class="text-slate-400 text-sm font-medium mr-0.5">{{ $caja->opener->business->currency_simbol ?? 'S/' }}</span>{{ number_format($total, 2) }}
                            </p>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                {{-- COLUMNA IZQUIERDA: VENTAS Y GASTOS SEPARADOS (NUEVO) --}}
                <div class="lg:col-span-2 space-y-6">

                    {{-- TABLA DE VENTAS --}}
                    <div class="bg-white border border-slate-200 rounded-xl overflow-hidden shadow-sm">
                        <div
                            class="px-5 py-4 flex justify-between items-center border-b border-slate-100 bg-emerald-50/50">
                            <h3 class="text-slate-800 font-bold text-xs uppercase flex items-center gap-2">
                                <i class="fa-solid fa-arrow-trend-up text-emerald-600"></i> Ventas
                            </h3>
                            <span
                                class="bg-emerald-100 text-emerald-700 text-[10px] font-bold px-2 py-0.5 rounded-md">
                                {{ $caja->sales->count() }} venta(s) · +{{ $caja->opener->business->currency_simbol ?? 'S/' }}{{ number_format($caja->sales->sum('total'), 2) }}
                            </span>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="w-full text-left">
                                <thead>
                                    <tr
                                        class="text-[10px] text-slate-400 uppercase font-bold border-b border-slate-100 italic">
                                        <th class="px-5 py-3">Fecha</th>
                                        <th class="px-5 py-3">Método(s) de Pago</th>
                                        <th class="px-5 py-3 text-right">Monto</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-50">
                                    @forelse ($caja->sales->sortByDesc('created_at') as $sale)
                                        <tr class="hover:bg-slate-50/50 transition-colors">
                                            <td class="px-5 py-3 text-xs text-slate-500 font-medium">
                                                {{ $sale->created_at->format('d/m/Y h:i A') }}
                                            </td>
                                            <td class="px-5 py-3 text-xs">
                                                <div class="font-semibold text-slate-800">Venta #{{ $sale->id }}</div>
                                                <div
                                                    class="text-[10px] text-indigo-500 font-medium uppercase tracking-tighter">
                                                    {{ $sale->payments->map(fn($p) => $p->method->name)->implode(', ') }}
                                                </div>
                                            </td>
                                            <td class="px-5 py-3 text-right">
                                                <span class="text-sm font-bold text-emerald-600">
                                                    +{{ number_format($sale->total, 2) }}
                                                </span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="px-5 py-10 text-center text-xs text-slate-400 italic">
                                                No hay ventas registradas en esta caja.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    {{-- TABLA DE GASTOS --}}
                    <div class="bg-white border border-slate-200 rounded-xl overflow-hidden shadow-sm">
                        <div
                            class="px-5 py-4 flex justify-between items-center border-b border-slate-100 bg-rose-50/50">
                            <h3 class="text-slate-800 font-bold text-xs uppercase flex items-center gap-2">
                                <i class="fa-solid fa-arrow-trend-down text-rose-600"></i> Gastos
                            </h3>
                            <span class="bg-rose-100 text-rose-700 text-[10px] font-bold px-2 py-0.5 rounded-md">
                                {{ $gastos->count() }} gasto(s) · -{{ $caja->opener->business->currency_simbol ?? 'S/' }}{{ number_format($gastos->sum('amount'), 2) }}
                            </span>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="w-full text-left">
                                <thead>
                                    <tr
                                        class="text-[10px] text-slate-400 uppercase font-bold border-b border-slate-100 italic">
                                        <th class="px-5 py-3">Fecha</th>
                                        <th class="px-5 py-3">Concepto</th>
                                        <th class="px-5 py-3 text-right">Monto</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-50">
                                    @forelse ($gastos->sortByDesc('expense_date') as $g)
                                        <tr class="hover:bg-slate-50/50 transition-colors">
                                            <td class="px-5 py-3 text-xs text-slate-500 font-medium">
                                                {{ $g->expense_date->format('d/m/Y h:i A') }}
                                            </td>
                                            <td class="px-5 py-3 text-xs">
                                                <div class="font-semibold text-slate-800">
                                                    {{ $g->concept }}{{ $g->description ? ' - ' . $g->description : '' }}
                                                </div>
                                                <div
                                                    class="text-[10px] text-indigo-500 font-medium uppercase tracking-tighter">
                                                    {{ $g->paymentMethod->name ?? 'N/A' }}
                                                </div>
                                            </td>
                                            <td class="px-5 py-3 text-right">
                                                <span class="text-sm font-bold text-rose-600">
                                                    -{{ number_format($g->amount, 2) }}
                                                </span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="px-5 py-10 text-center text-xs text-slate-400 italic">
                                                No hay gastos registrados en esta caja.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>

                {{-- PANEL DE ESTADO / LIQUIDACIÓN --}}
                <div class="lg:col-span-1 space-y-4">
                    <div class="bg-white border border-slate-200 rounded-xl p-6 shadow-sm">
                        <h4
                            class="text-slate-900 text-xs font-bold uppercase tracking-wider mb-6 border-b border-slate-100 pb-3">
                            Resumen de Liquidación
                        </h4>

                        <div class="space-y-4">
                            <div class="flex justify-between items-center text-sm">
                                <span class="text-slate-500">Monto Inicial</span>
                                <span
                                    class="font-semibold text-slate-700">{{ $caja->opener->business->currency_simbol ?? 'S/' }}{{ number_format($caja->opening_amount, 2) }}</span>
                            </div>

                            <div class="flex justify-between items-center text-sm text-emerald-600">
                                <span>Total Ventas</span>
                                <span class="font-semibold">+{{ $caja->opener->business->currency_simbol ?? 'S/' }}{{ number_format($caja->sales->sum('total'), 2) }}</span>
                            </div>

                            <div class="flex justify-between items-center text-sm text-rose-600">
                                <span>Total Egresos (Gastos)</span>
                                <span
                                    class="font-semibold">-{{ $caja->opener->business->currency_simbol ?? 'S/' }}{{ number_format($gastos->sum('amount'), 2) }}</span>
                            </div>

                            <div class="mt-6 pt-6 border-t border-slate-100">
                                <p class="text-indigo-600 text-[10px] font-bold uppercase mb-1">Efectivo Total en Caja
                                </p>
                                <p class="text-4xl font-bold text-slate-900 tracking-tight">
                                    <span
                                        class="text-lg font-medium text-slate-400 mr-1">{{ $caja->opener->business->currency_simbol ?? 'S/' }}</span>{{ number_format($caja->current_amount, 2) }}
                                </p>
                            </div>
                        </div>

                        @if ($caja->status == 'open' || $caja->status == 'abierto')
                            @can('cajas.cerrar')
                                <button onclick="confirmarCierreCaja('{{ $caja->id }}')"
                                    class="w-full mt-6 bg-indigo-50 text-indigo-600 hover:bg-indigo-600 hover:text-white transition-all py-3 rounded-lg font-bold text-xs flex items-center justify-center gap-2">
                                    <i class="fa-solid fa-lock"></i>
                                    CERRAR CAJA
                                </button>
                            @endcan
                        @else
                            <div
                                class="w-full mt-6 bg-slate-50 text-slate-400 py-3 rounded-lg font-bold text-xs flex items-center justify-center gap-2 border border-dashed border-slate-200">
                                <i class="fa-solid fa-check-double"></i>
                                CAJA FINALIZADA
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function confirmarCierreCaja(cajaId) {
            Swal.fire({
                title: '¿Cerrar caja?',
                text: "Se finalizarán las operaciones del día.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#4f46e5',
                cancelButtonColor: '#f43f5e',
                confirmButtonText: 'Sí, cerrar',
                cancelButtonText: 'Cancelar',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    cerrarCajaFetch(cajaId);
                }
            });
        }

        function cerrarCajaFetch(cajaId) {
            Swal.fire({
                title: 'Procesando...',
                didOpen: () => Swal.showLoading(),
                allowOutsideClick: false
            });
            fetch(`/cash-registers/${cajaId}/close`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        closed_at: new Date().toISOString()
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                                title: '¡Cerrada!',
                                icon: 'success',
                                timer: 1500,
                                showConfirmButton: false
                            })
                            .then(() => window.location
                        .reload());
                    } else {
                        throw new Error(data.message);
                    }
                })
                .catch(error => Swal.fire('Error', error.message, 'error'));
        }
    </script>
</x-admin-layout>