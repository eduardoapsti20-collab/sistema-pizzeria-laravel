<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Ingresos y Egresos') }}
        </h2>
    </x-slot>

    <div class="py-6 max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 mb-6">
            <form method="GET" class="flex flex-wrap items-end gap-3">
                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase mb-1.5">Desde</label>
                    <input type="date" name="from" value="{{ $from }}"
                        class="bg-slate-50 border-slate-200 rounded-lg py-1.5 px-3 text-sm">
                </div>
                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase mb-1.5">Hasta</label>
                    <input type="date" name="to" value="{{ $to }}"
                        class="bg-slate-50 border-slate-200 rounded-lg py-1.5 px-3 text-sm">
                </div>
                <button type="submit"
                    class="bg-slate-800 hover:bg-slate-900 text-white px-4 py-2 rounded-lg text-xs font-black uppercase tracking-widest transition-all">
                    Filtrar
                </button>
                <a href="{{ route('reports.financial.excel', ['from' => $from, 'to' => $to]) }}"
                    class="bg-green-700 hover:bg-green-800 text-white px-4 py-2 rounded-lg text-xs font-black uppercase tracking-widest transition-all">
                    Descargar Excel
                </a>
            </form>
        </div>

        <div class="grid grid-cols-3 gap-4 mb-6">
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5">
                <span class="block text-[10px] font-black text-slate-400 uppercase mb-1">Ingresos</span>
                <span class="text-2xl font-black text-slate-800">
                    {{ $empresa->currency_simbol ?? 'S/' }}{{ number_format($totales['ingresos'], 2) }}
                </span>
            </div>
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5">
                <span class="block text-[10px] font-black text-slate-400 uppercase mb-1">Egresos</span>
                <span class="text-2xl font-black text-rose-600">
                    {{ $empresa->currency_simbol ?? 'S/' }}{{ number_format($totales['egresos'], 2) }}
                </span>
            </div>
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5">
                <span class="block text-[10px] font-black text-slate-400 uppercase mb-1">Utilidad Neta</span>
                <span class="text-2xl font-black {{ $totales['utilidad'] >= 0 ? 'text-green-700' : 'text-rose-600' }}">
                    {{ $empresa->currency_simbol ?? 'S/' }}{{ number_format($totales['utilidad'], 2) }}
                </span>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <table class="w-full text-sm">
                <thead class="bg-slate-50 text-[10px] font-black text-slate-400 uppercase">
                    <tr>
                        <th class="text-left px-5 py-3">Mes</th>
                        <th class="text-right px-5 py-3">Ingresos</th>
                        <th class="text-right px-5 py-3">Egresos</th>
                        <th class="text-right px-5 py-3">Utilidad</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($filas as $fila)
                        <tr>
                            <td class="px-5 py-3 font-medium text-slate-700 capitalize">{{ $fila['etiqueta'] }}</td>
                            <td class="px-5 py-3 text-right text-slate-700">
                                {{ number_format($fila['ingresos'], 2) }}
                            </td>
                            <td class="px-5 py-3 text-right text-rose-600">
                                {{ number_format($fila['egresos'], 2) }}
                            </td>
                            <td class="px-5 py-3 text-right font-bold {{ $fila['utilidad'] >= 0 ? 'text-green-700' : 'text-rose-600' }}">
                                {{ number_format($fila['utilidad'], 2) }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-5 py-8 text-center text-slate-400">
                                No hay movimientos en el rango de fechas seleccionado.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
</x-admin-layout>
