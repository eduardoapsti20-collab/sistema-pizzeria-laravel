<x-admin-layout>
    <style>
        .ultra-card {
            background: #ffffff;
            position: relative;
            overflow: hidden;
            transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 10px 30px -5px rgba(15, 23, 42, 0.04), 0 4px 12px -2px rgba(15, 23, 42, 0.02);
        }

        .ultra-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: transparent;
            transition: all 0.35s ease;
        }

        .card-ventas::before {
            background: linear-gradient(90deg, #f97316, #ea580c);
        }

        .card-gastos::before {
            background: linear-gradient(90deg, #f43f5e, #e11d48);
        }

        .card-balance-positivo::before {
            background: linear-gradient(90deg, #10b981, #059669);
        }

        .card-balance-negativo::before {
            background: linear-gradient(90deg, #f43f5e, #dc2626);
        }

        .card-mesas::before {
            background: linear-gradient(90deg, #f59e0b, #d97706);
        }

        .card-cocina::before {
            background: linear-gradient(90deg, #6366f1, #4f46e5);
        }

        .card-ticket::before {
            background: linear-gradient(90deg, #10b981, #059669);
        }

        .ultra-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px -5px rgba(15, 23, 42, 0.08), 0 8px 20px -4px rgba(15, 23, 42, 0.04);
        }

        .ultra-card:hover .icon-container {
            transform: scale(1.1) rotate(4deg);
        }

        .pulse-orange {
            box-shadow: 0 0 0 0 rgba(249, 115, 22, 0.4);
            animation: pulse-orange 2s infinite;
        }

        @keyframes pulse-orange {
            70% {
                box-shadow: 0 0 0 10px rgba(249, 115, 22, 0);
            }

            100% {
                box-shadow: 0 0 0 0 rgba(249, 115, 22, 0);
            }
        }

        /* Evita que las tarjetas de métricas se vean demasiado
           apretadas en pantallas muy angostas (celulares pequeños). */
        @media (max-width: 380px) {
            .ultra-card h3 {
                font-size: 0.85rem;
            }
        }
    </style>

    <div class="min-h-screen antialiased font-sans px-3 sm:px-4 md:px-0">

        <div class="flex flex-col md:flex-row md:items-center justify-between pb-6 border-b border-slate-200/70 gap-4">
            <div>
                <h1
                    class="text-2xl sm:text-3xl font-black tracking-tight text-slate-900 bg-clip-text text-transparent bg-gradient-to-r from-slate-900 via-orange-950 to-slate-900">
                    Resumen Diario
                </h1>
                <p class="text-[11px] sm:text-xs text-slate-500 font-semibold mt-1.5 flex flex-wrap items-center gap-2">
                    <span class="relative flex h-2.5 w-2.5 shrink-0">
                        <span
                            class="animate-ping absolute inline-flex h-full w-full rounded-full bg-orange-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-orange-500"></span>
                    </span>
                    <span class="font-bold text-slate-700 tracking-wide">{{ config('app.name', 'CevicheFlow') }}</span>
                    <span class="text-slate-300 hidden sm:inline">|</span>
                    <span class="text-slate-400 font-medium bg-slate-100 px-2 py-0.5 rounded-md">Terminal de Control
                        Activa</span>
                </p>
            </div>
            <div>
                <a href="{{ route('tables.index') }}"
                    class="pulse-orange flex items-center justify-center px-5 sm:px-6 py-2.5 sm:py-3 bg-gradient-to-r from-orange-600 via-orange-500 to-amber-500 hover:from-orange-700 hover:to-amber-600 rounded-2xl text-xs font-bold text-white shadow-lg shadow-orange-500/20 transition-all active:scale-95 tracking-wider uppercase w-full md:w-auto">
                    <i class="fa-solid fa-plus mr-2.5 text-xs animate-bounce"></i> Nueva Orden
                </a>
            </div>
        </div>

        {{-- FILTRO DE FECHA: Hoy / Ayer / Antier / fecha personalizada.
             Afecta todas las tarjetas de métricas y las tablas de abajo
             (comandas, gastos, ranking de productos). --}}
        <div class="flex flex-wrap items-center gap-2 mt-5 mb-2">
            <a href="{{ route('dashboard') }}"
                class="px-3 py-1.5 rounded-lg text-[11px] font-black uppercase tracking-tight transition-all border {{ $fecha->isToday() ? 'bg-orange-600 border-orange-600 text-white shadow-sm' : 'bg-white border-slate-200 text-slate-500 hover:border-slate-300' }}">
                Hoy
            </a>
            <a href="{{ route('dashboard', ['fecha' => now()->subDay()->format('Y-m-d')]) }}"
                class="px-3 py-1.5 rounded-lg text-[11px] font-black uppercase tracking-tight transition-all border {{ $fecha->isYesterday() ? 'bg-orange-600 border-orange-600 text-white shadow-sm' : 'bg-white border-slate-200 text-slate-500 hover:border-slate-300' }}">
                Ayer
            </a>
            <a href="{{ route('dashboard', ['fecha' => now()->subDays(2)->format('Y-m-d')]) }}"
                class="px-3 py-1.5 rounded-lg text-[11px] font-black uppercase tracking-tight transition-all border {{ $fecha->isSameDay(now()->subDays(2)) ? 'bg-orange-600 border-orange-600 text-white shadow-sm' : 'bg-white border-slate-200 text-slate-500 hover:border-slate-300' }}">
                Antier
            </a>

            <form method="GET" action="{{ route('dashboard') }}" class="flex items-center gap-2">
                <input type="date" name="fecha" value="{{ $fecha->format('Y-m-d') }}" max="{{ now()->format('Y-m-d') }}"
                    onchange="this.form.submit()"
                    class="bg-white border border-slate-200 py-1.5 px-3 rounded-lg text-[11px] font-bold text-slate-600 outline-none focus:ring-2 focus:ring-orange-500/20 transition-all">
            </form>

            @unless ($fecha->isToday())
                <span class="text-[10px] text-slate-400 font-bold uppercase ml-1">
                    Viendo: {{ $fecha->translatedFormat('d \d\e F, Y') }}
                </span>
            @endunless
        </div>

        {{-- FILA ÚNICA: TODAS LAS MÉTRICAS (Ventas / Gastos / Balance / Mesas / Cocina / Propinas)
             AGREGADO: se reemplazó el grid fijo de 6 columnas (inline style, no
             responsive) por clases de Tailwind que se adaptan a cada tamaño de
             pantalla: 2 columnas en celular, 3 en tablet, 6 en laptop/desktop. --}}
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3 sm:gap-4 mb-8">

            {{-- VENTAS DEL DÍA — clicable, lleva al cobro/mesas --}}
            <a href="{{ route('orders.cashier') }}" class="block">
                <div class="ultra-card card-ventas p-3.5 sm:p-4 rounded-xl cursor-pointer h-full">
                    <div class="flex items-center justify-between mb-2.5 sm:mb-3">
                        <div
                            class="icon-container w-8 h-8 sm:w-9 sm:h-9 bg-gradient-to-br from-orange-500 to-red-500 rounded-lg flex items-center justify-center text-white shadow-md shadow-orange-500/20 transition-all duration-300">
                            <i class="fa-solid fa-dollar-sign text-xs sm:text-sm"></i>
                        </div>
                        <span
                            class="text-[9px] font-black {{ $variacionVentas >= 0 ? 'text-emerald-700 bg-emerald-50 border-emerald-200' : 'text-rose-700 bg-rose-50 border-rose-200' }} px-1.5 py-0.5 rounded-md border shadow-sm">
                            {{ $variacionVentas >= 0 ? '▲' : '▼' }} {{ number_format(abs($variacionVentas), 0) }}%
                        </span>
                    </div>
                    <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest">Ventas del Día</p>
                    <h3 class="text-sm sm:text-base font-black text-slate-800 tracking-tight mt-0.5 truncate">
                        <span
                            class="text-orange-600 font-bold mr-0.5">{{ $empresa->currency_simbol }}</span>{{ number_format($ventasHoy, 2) }}
                    </h3>
                    <p class="text-[9px] text-slate-400 font-semibold mt-1.5 hidden sm:flex items-center gap-1 truncate">
                        <i class="fa-solid fa-arrow-right"></i> Ver cobros
                    </p>
                </div>
            </a>

            {{-- GASTOS DEL DÍA — clicable, lleva a expenses.index --}}
            <a href="{{ route('expenses.index') }}" class="block">
                <div class="ultra-card card-gastos p-3.5 sm:p-4 rounded-xl cursor-pointer h-full">
                    <div class="flex items-center justify-between mb-2.5 sm:mb-3">
                        <div
                            class="icon-container w-8 h-8 sm:w-9 sm:h-9 bg-gradient-to-br from-rose-500 to-red-600 rounded-lg flex items-center justify-center text-white shadow-md shadow-rose-500/20 transition-all duration-300">
                            <i class="fa-solid fa-money-bill-transfer text-xs sm:text-sm"></i>
                        </div>
                        <span
                            class="text-[9px] font-black {{ $variacionGastos <= 0 ? 'text-emerald-700 bg-emerald-50 border-emerald-200' : 'text-rose-700 bg-rose-50 border-rose-200' }} px-1.5 py-0.5 rounded-md border shadow-sm">
                            {{ $variacionGastos >= 0 ? '▲' : '▼' }} {{ number_format(abs($variacionGastos), 0) }}%
                        </span>
                    </div>
                    <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest">Gastos del Día</p>
                    <h3 class="text-sm sm:text-base font-black text-slate-800 tracking-tight mt-0.5 truncate">
                        <span
                            class="text-rose-600 font-bold mr-0.5">{{ $empresa->currency_simbol }}</span>{{ number_format($gastosHoy, 2) }}
                    </h3>
                    <p class="text-[9px] text-slate-400 font-semibold mt-1.5 hidden sm:flex items-center gap-1 truncate">
                        <i class="fa-solid fa-arrow-right"></i> Ver egresos
                    </p>
                </div>
            </a>

            {{-- BALANCE NETO DEL DÍA = Ventas - Gastos --}}
            <div
                class="ultra-card {{ $balanceHoy >= 0 ? 'card-balance-positivo' : 'card-balance-negativo' }} p-3.5 sm:p-4 rounded-xl h-full">
                <div class="flex items-center justify-between mb-2.5 sm:mb-3">
                    <div
                        class="icon-container w-8 h-8 sm:w-9 sm:h-9 bg-gradient-to-br {{ $balanceHoy >= 0 ? 'from-emerald-500 to-teal-600' : 'from-rose-500 to-red-600' }} rounded-lg flex items-center justify-center text-white shadow-md transition-all duration-300">
                        <i class="fa-solid fa-scale-balanced text-xs sm:text-sm"></i>
                    </div>
                    <span
                        class="text-[9px] font-black {{ $variacionBalance >= 0 ? 'text-emerald-700 bg-emerald-50 border-emerald-200' : 'text-rose-700 bg-rose-50 border-rose-200' }} px-1.5 py-0.5 rounded-md border shadow-sm">
                        {{ $variacionBalance >= 0 ? '▲' : '▼' }} {{ number_format(abs($variacionBalance), 0) }}%
                    </span>
                </div>
                <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest">Balance del Día</p>
                <h3
                    class="text-sm sm:text-base font-black tracking-tight mt-0.5 truncate {{ $balanceHoy >= 0 ? 'text-emerald-700' : 'text-rose-700' }}">
                    <span
                        class="font-bold mr-0.5">{{ $empresa->currency_simbol }}</span>{{ number_format($balanceHoy, 2) }}
                </h3>
                <p class="text-[9px] text-slate-400 font-semibold mt-1.5 truncate">
                    Neto del día
                </p>
            </div>

            {{-- MESAS ACTIVAS --}}
            <div class="ultra-card card-mesas p-3.5 sm:p-4 rounded-xl h-full">
                <div class="flex items-center justify-between mb-2.5 sm:mb-3">
                    <div
                        class="icon-container w-8 h-8 sm:w-9 sm:h-9 bg-gradient-to-br from-amber-400 to-orange-500 rounded-lg flex items-center justify-center text-white shadow-md shadow-amber-500/20 transition-all duration-300">
                        <i class="fa-solid fa-utensils text-xs sm:text-sm"></i>
                    </div>
                    <span
                        class="text-[9px] font-black text-amber-600 bg-amber-50 px-1.5 py-0.5 rounded-md border border-amber-100">{{ number_format($porcentajeOcupacion, 0) }}%</span>
                </div>
                <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest">Mesas Activas</p>
                <h3 class="text-sm sm:text-base font-black text-slate-800 tracking-tight mt-0.5">
                    {{ $mesasOcupadas }} <span class="text-slate-300 font-normal text-sm">/ {{ $mesasTotales }}</span>
                </h3>
            </div>

            {{-- PENDIENTE COCINA --}}
            <div class="ultra-card card-cocina p-3.5 sm:p-4 rounded-xl h-full">
                <div class="flex items-center justify-between mb-2.5 sm:mb-3">
                    <div
                        class="icon-container w-8 h-8 sm:w-9 sm:h-9 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-lg flex items-center justify-center text-white shadow-md shadow-indigo-500/20 transition-all duration-300">
                        <i class="fa-solid fa-fire-burner text-xs sm:text-sm"></i>
                    </div>
                    @if ($comandasEnCocina > 0)
                        <span
                            class="animate-pulse inline-flex items-center px-1.5 py-0.5 rounded-md text-[9px] font-black bg-gradient-to-r from-indigo-500 to-purple-500 text-white shadow-sm border border-indigo-400 uppercase">
                            Prod.
                        </span>
                    @endif
                </div>
                <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest">Pend. Cocina</p>
                <h3 class="text-sm sm:text-base font-black text-slate-800 tracking-tight mt-0.5">
                    {{ str_pad($comandasEnCocina, 2, '0', STR_PAD_LEFT) }} <span
                        class="text-[10px] font-bold text-indigo-500 uppercase ml-1">Comandas</span>
                </h3>
            </div>

            {{-- TOTAL PROPINAS --}}
            <div class="ultra-card card-ticket p-3.5 sm:p-4 rounded-xl h-full">
                <div class="flex items-center justify-between mb-2.5 sm:mb-3">
                    <div
                        class="icon-container w-8 h-8 sm:w-9 sm:h-9 bg-gradient-to-br from-emerald-400 to-teal-600 rounded-lg flex items-center justify-center text-white shadow-md shadow-emerald-500/20 transition-all duration-300">
                        <i class="fa-solid fa-receipt text-xs sm:text-sm"></i>
                    </div>
                </div>
                <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest">Total Propinas</p>
                <h3 class="text-sm sm:text-base font-black text-slate-800 tracking-tight mt-0.5 truncate">
                    <span
                        class="text-emerald-600 font-bold mr-0.5">{{ $empresa->currency_simbol }}</span>{{ number_format($propinasHoy, 2) }}
                </h3>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-5 sm:gap-8 mb-8">

            <div class="lg:col-span-2 ultra-card card-ventas rounded-2xl p-4 sm:p-6">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-2">
                    <div>
                        <h3 class="font-black text-slate-800 text-sm uppercase tracking-wider flex items-center gap-2">
                            <i class="fa-solid fa-chart-bar text-orange-500"></i>
                            Tendencia de Ventas vs Gastos
                        </h3>
                        <p class="text-[11px] text-slate-400 font-medium mt-0.5">Historial analítico: últimos 30 días o
                            últimos 6 meses</p>
                    </div>
                    <div class="flex items-center justify-between sm:justify-end gap-3">
                        <span class="flex items-center gap-1.5 text-[10px] font-bold text-slate-500">
                            <span class="w-2.5 h-2.5 rounded-sm bg-orange-500"></span> Ventas
                        </span>
                        <span class="flex items-center gap-1.5 text-[10px] font-bold text-slate-500">
                            <span class="w-2.5 h-2.5 rounded-sm bg-rose-500"></span> Gastos
                        </span>
                        <div class="flex bg-slate-100 rounded-lg p-0.5">
                            <button type="button" id="btnVistaDia" onclick="cambiarVistaTendencia('dia')"
                                class="text-[10px] font-bold px-2.5 py-1 rounded-md uppercase tracking-wide transition-all text-slate-500">
                                Día
                            </button>
                            <button type="button" id="btnVistaMes" onclick="cambiarVistaTendencia('mes')"
                                class="text-[10px] font-bold px-2.5 py-1 rounded-md uppercase tracking-wide transition-all bg-white text-orange-600 shadow-sm">
                                Mes
                            </button>
                        </div>
                    </div>
                </div>
                <div class="w-full h-56 sm:h-64 md:h-72">
                    <canvas id="chartVentasMensuales"></canvas>
                </div>
            </div>

            <div class="ultra-card card-ticket rounded-2xl p-4 sm:p-6 flex flex-col justify-between">
                <div>
                    <h3 class="font-black text-slate-800 text-sm uppercase tracking-wider flex items-center gap-2">
                        <i class="fa-solid fa-pie-chart text-indigo-500"></i>
                        Distribución de Ingresos
                    </h3>
                    <p class="text-[11px] text-slate-400 font-medium mt-0.5">Flujo por método de pago
                        ({{ $fecha->isToday() ? 'hoy' : $fecha->translatedFormat('d M') }})</p>
                </div>
                <div class="w-full h-52 sm:h-60 md:h-64 flex items-center justify-center mt-4">
                    <div class="w-full h-full relative flex items-center justify-center">
                        <canvas id="chartMetodosPago"></canvas>
                    </div>
                </div>
            </div>

        </div>

        {{-- GRÁFICO DE LA FECHA FILTRADA — desglose por hora --}}
        <div class="ultra-card card-ventas rounded-2xl p-4 sm:p-6 mb-8">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-2">
                <div>
                    <h3 class="font-black text-slate-800 text-sm uppercase tracking-wider flex items-center gap-2">
                        <i class="fa-solid fa-clock text-orange-500"></i>
                        Ventas y Gastos por Hora
                    </h3>
                    <p class="text-[11px] text-slate-400 font-medium mt-0.5">
                        Desglose hora a hora de
                        {{ $fecha->isToday() ? 'hoy' : $fecha->translatedFormat('d \d\e F, Y') }}
                    </p>
                </div>
                <div class="flex items-center gap-3">
                    <span class="flex items-center gap-1.5 text-[10px] font-bold text-slate-500">
                        <span class="w-2.5 h-2.5 rounded-sm bg-orange-500"></span> Ventas
                    </span>
                    <span class="flex items-center gap-1.5 text-[10px] font-bold text-slate-500">
                        <span class="w-2.5 h-2.5 rounded-sm bg-rose-500"></span> Gastos
                    </span>
                </div>
            </div>
            <div class="w-full h-52 sm:h-60 md:h-64 overflow-x-auto">
                <canvas id="chartPorHora" class="min-w-[600px] md:min-w-0"></canvas>
            </div>
        </div>

        @push('js')
            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

            <script>
                document.addEventListener("DOMContentLoaded", function() {
                    const currencySimbol = "{{ $empresa->currency_simbol }}";
                    const ctxVentas = document.getElementById('chartVentasMensuales').getContext('2d');

                    const gradientVentas = ctxVentas.createLinearGradient(0, 0, 0, 300);
                    gradientVentas.addColorStop(0, '#f97316');
                    gradientVentas.addColorStop(1, '#ea580c');

                    const gradientGastos = ctxVentas.createLinearGradient(0, 0, 0, 300);
                    gradientGastos.addColorStop(0, '#f43f5e');
                    gradientGastos.addColorStop(1, '#e11d48');

                    // ====================================================
                    // DATOS PARA AMBAS VISTAS DEL GRÁFICO (día / mes)
                    // ====================================================
                    const datosVista = {
                        mes: {
                            labels: {!! json_encode($chartVentasMesLabels) !!},
                            ventas: {!! json_encode($chartVentasMesData) !!},
                            gastos: {!! json_encode($chartGastosMesData) !!}
                        },
                        dia: {
                            labels: {!! json_encode($chartVentasDiaLabels) !!},
                            ventas: {!! json_encode($chartVentasDiaData) !!},
                            gastos: {!! json_encode($chartGastosDiaData) !!}
                        }
                    };

                    const chartVentas = new Chart(ctxVentas, {
                        type: 'bar',
                        data: {
                            labels: datosVista.mes.labels,
                            datasets: [{
                                label: 'Ventas',
                                data: datosVista.mes.ventas,
                                backgroundColor: gradientVentas,
                                borderRadius: 6,
                                borderSkipped: false
                            }, {
                                label: 'Gastos',
                                data: datosVista.mes.gastos,
                                backgroundColor: gradientGastos,
                                borderRadius: 6,
                                borderSkipped: false
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    display: false
                                },
                                tooltip: {
                                    callbacks: {
                                        label: function(context) {
                                            return ' ' + context.dataset.label + ': ' + currencySimbol + context
                                                .raw.toLocaleString('es-PE', {
                                                    minimumFractionDigits: 2
                                                });
                                        }
                                    }
                                }
                            },
                            scales: {
                                x: {
                                    grid: {
                                        display: false
                                    },
                                    ticks: {
                                        color: '#94a3b8',
                                        font: {
                                            family: 'Quicksand, sans-serif',
                                            size: 11,
                                            weight: 600
                                        }
                                    }
                                },
                                y: {
                                    grid: {
                                        color: '#f1f5f9'
                                    },
                                    border: {
                                        dash: [4, 4]
                                    },
                                    ticks: {
                                        color: '#94a3b8',
                                        font: {
                                            family: 'Quicksand, sans-serif',
                                            size: 11,
                                            weight: 600
                                        },
                                        callback: function(value) {
                                            return currencySimbol + value;
                                        }
                                    }
                                }
                            }
                        }
                    });

                    // ====================================================
                    // TOGGLE DÍA / MES — cambia los datos del gráfico sin recargar
                    // ====================================================
                    window.cambiarVistaTendencia = function(vista) {
                        chartVentas.data.labels = datosVista[vista].labels;
                        chartVentas.data.datasets[0].data = datosVista[vista].ventas;
                        chartVentas.data.datasets[1].data = datosVista[vista].gastos;
                        chartVentas.update();

                        const btnDia = document.getElementById('btnVistaDia');
                        const btnMes = document.getElementById('btnVistaMes');

                        if (vista === 'dia') {
                            btnDia.classList.add('bg-white', 'text-orange-600', 'shadow-sm');
                            btnDia.classList.remove('text-slate-500');
                            btnMes.classList.remove('bg-white', 'text-orange-600', 'shadow-sm');
                            btnMes.classList.add('text-slate-500');
                        } else {
                            btnMes.classList.add('bg-white', 'text-orange-600', 'shadow-sm');
                            btnMes.classList.remove('text-slate-500');
                            btnDia.classList.remove('bg-white', 'text-orange-600', 'shadow-sm');
                            btnDia.classList.add('text-slate-500');
                        }
                    };

                    // ====================================================
                    // GRÁFICO POR HORA — de la fecha filtrada (Hoy/Ayer/Antier/personalizada)
                    // ====================================================
                    const ctxHora = document.getElementById('chartPorHora').getContext('2d');

                    const gradientVentasHora = ctxHora.createLinearGradient(0, 0, 0, 250);
                    gradientVentasHora.addColorStop(0, '#f97316');
                    gradientVentasHora.addColorStop(1, '#ea580c');

                    const gradientGastosHora = ctxHora.createLinearGradient(0, 0, 0, 250);
                    gradientGastosHora.addColorStop(0, '#f43f5e');
                    gradientGastosHora.addColorStop(1, '#e11d48');

                    new Chart(ctxHora, {
                        type: 'bar',
                        data: {
                            labels: {!! json_encode($chartHoraLabels) !!},
                            datasets: [{
                                label: 'Ventas',
                                data: {!! json_encode($chartVentasHoraData) !!},
                                backgroundColor: gradientVentasHora,
                                borderRadius: 4,
                                borderSkipped: false
                            }, {
                                label: 'Gastos',
                                data: {!! json_encode($chartGastosHoraData) !!},
                                backgroundColor: gradientGastosHora,
                                borderRadius: 4,
                                borderSkipped: false
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    display: false
                                },
                                tooltip: {
                                    callbacks: {
                                        label: function(context) {
                                            return ' ' + context.dataset.label + ': ' + currencySimbol + context
                                                .raw.toLocaleString('es-PE', {
                                                    minimumFractionDigits: 2
                                                });
                                        }
                                    }
                                }
                            },
                            scales: {
                                x: {
                                    grid: {
                                        display: false
                                    },
                                    ticks: {
                                        color: '#94a3b8',
                                        font: {
                                            family: 'Quicksand, sans-serif',
                                            size: 10,
                                            weight: 600
                                        },
                                        maxRotation: 0,
                                        autoSkip: true,
                                        maxTicksLimit: 12
                                    }
                                },
                                y: {
                                    grid: {
                                        color: '#f1f5f9'
                                    },
                                    border: {
                                        dash: [4, 4]
                                    },
                                    ticks: {
                                        color: '#94a3b8',
                                        font: {
                                            family: 'Quicksand, sans-serif',
                                            size: 11,
                                            weight: 600
                                        },
                                        callback: function(value) {
                                            return currencySimbol + value;
                                        }
                                    }
                                }
                            }
                        }
                    });

                    // ====================================================
                    // GRÁFICO DE DONA (MÉTODOS DE PAGO)
                    // ====================================================
                    const dataMetodos = {!! json_encode($chartMetodosData) !!};
                    const labelsMetodos = {!! json_encode($chartMetodosLabels) !!};

                    if (dataMetodos.length === 0) {
                        document.getElementById("chartMetodosPago").parentElement.innerHTML = `
                        <div class="text-center text-xs font-semibold text-slate-400 py-8">
                            No hay transacciones registradas en esta fecha
                        </div>`;
                    } else {
                        const ctxMetodos = document.getElementById('chartMetodosPago').getContext('2d');

                        const coloresCards = ['#10b981', '#6366f1', '#f59e0b', '#f97316'];

                        const chartMetodos = new Chart(ctxMetodos, {
                            type: 'doughnut',
                            data: {
                                labels: labelsMetodos,
                                datasets: [{
                                    data: dataMetodos,
                                    backgroundColor: coloresCards,
                                    borderWidth: 3,
                                    borderColor: '#ffffff'
                                }]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                cutout: '75%',
                                plugins: {
                                    legend: {
                                        position: 'bottom',
                                        labels: {
                                            color: '#475569',
                                            font: {
                                                family: 'Quicksand, sans-serif',
                                                size: 11,
                                                weight: 700
                                            },
                                            boxWidth: 12,
                                            padding: 15
                                        }
                                    },
                                    tooltip: {
                                        callbacks: {
                                            label: function(context) {
                                                return ' ' + context.label + ': ' + currencySimbol + context.raw
                                                    .toFixed(2);
                                            }
                                        }
                                    }
                                }
                            }
                        });
                    }
                });
            </script>
        @endpush

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-5 sm:gap-8">

            {{-- ÚLTIMAS COMANDAS / VENTAS EN MESAS --}}
            <div
                class="lg:col-span-2 bg-white rounded-2xl border border-slate-200 shadow-xl shadow-slate-100 overflow-hidden">
                <div
                    class="px-4 sm:px-6 py-4 sm:py-5 border-b border-slate-100 bg-gradient-to-r from-slate-50 to-white flex justify-between items-center gap-2">
                    <h3
                        class="font-black text-slate-800 tracking-tight flex items-center gap-2.5 text-xs sm:text-sm uppercase tracking-wider">
                        <span class="w-2 h-2 rounded-full bg-orange-500 shrink-0"></span>
                        <span class="truncate">Monitor de Comandas Recientes</span>
                    </h3>
                    <a href="{{ route('orders.cashier') }}"
                        class="text-[11px] bg-slate-100 hover:bg-orange-100 hover:text-orange-700 text-slate-600 font-bold px-2.5 py-1 rounded-full border border-slate-200 transition-all shrink-0">
                        Ver todas
                    </a>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse min-w-[560px]">
                        <thead>
                            <tr
                                class="text-slate-400 font-bold uppercase text-[10px] tracking-widest border-b border-slate-100 bg-slate-50/70">
                                <th class="px-4 sm:px-6 py-4">Pedido</th>
                                <th class="px-4 sm:px-6 py-4">Ubicación / Cliente</th>
                                <th class="px-4 sm:px-6 py-4 text-center">Estado</th>
                                <th class="px-4 sm:px-6 py-4 text-right">Total</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($ultimasComandas as $order)
                                <tr class="group hover:bg-orange-50/30 transition-all duration-200">
                                    <td class="px-4 sm:px-6 py-4.5 font-black text-orange-600 text-sm">{{ $order->order_code }}
</td>
                                    <td class="px-4 sm:px-6 py-4.5">
                                        <div class="font-bold text-slate-800 text-sm flex items-center gap-1.5">
                                            <i class="fa-solid fa-chair text-slate-400 text-xs"></i>
                                            {{ $order->table->name ?? 'Para llevar' }}
                                        </div>
                                        <div
                                            class="text-[11px] text-slate-400 font-medium uppercase tracking-wide mt-0.5 pl-5">
                                            {{ $order->customer_name }}
                                        </div>
                                    </td>
                                    <td class="px-4 sm:px-6 py-4.5 text-center">
                                        @php
                                            $statusClasses = match ($order->status) {
                                                'pendiente'
                                                    => 'bg-gradient-to-r from-amber-500 to-orange-500 text-white shadow-md shadow-orange-500/10 border-transparent',
                                                'pagado', 'cerrado'
                                                    => 'bg-gradient-to-r from-emerald-500 to-teal-500 text-white shadow-md shadow-emerald-500/10 border-transparent',
                                                'cancelado'
                                                    => 'bg-gradient-to-r from-rose-500 to-red-600 text-white shadow-md shadow-red-500/10 border-transparent',
                                                default => 'bg-slate-100 text-slate-700 border-slate-200',
                                            };
                                        @endphp
                                        <span
                                            class="inline-flex items-center px-3 py-1 rounded-xl text-[10px] font-black border {{ $statusClasses }} uppercase tracking-wider">
                                            {{ $order->status }}
                                        </span>
                                    </td>
                                    <td class="px-4 sm:px-6 py-4.5 text-right font-black text-slate-900 text-sm">
                                        <span
                                            class="text-slate-400 font-bold text-xs mr-0.5">{{ $empresa->currency_simbol }}</span>{{ number_format($order->total, 2) }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4"
                                        class="px-4 sm:px-6 py-12 text-center text-slate-400 font-medium italic bg-slate-50/50">
                                        <i class="fa-solid fa-receipt text-2xl text-slate-300 block mb-2"></i>
                                        No hay órdenes registradas en esta fecha
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- COLUMNA DERECHA: TOP PRODUCTOS + ÚLTIMOS GASTOS --}}
            <div class="flex flex-col gap-5 sm:gap-8">

                <div class="bg-white rounded-2xl border border-slate-200 shadow-xl shadow-slate-100 p-4 sm:p-6">
                    <h3
                        class="font-black text-slate-800 text-xs tracking-widest uppercase border-b border-slate-100 pb-4 mb-5 flex items-center justify-between gap-2">
                        <span>🔥 Top 5 Productos</span>
                        <span
                            class="text-[10px] text-orange-600 bg-orange-50 px-2 py-0.5 rounded font-bold uppercase tracking-normal shrink-0">Más
                            vendidos</span>
                    </h3>

                    <div class="space-y-4">
                        @forelse ($rankingProductos as $item)
                            <div
                                class="flex items-center justify-between group p-2.5 rounded-xl hover:bg-slate-50 transition-all duration-200 border border-transparent hover:border-slate-100">
                                <div class="flex items-center gap-3.5 min-w-0">
                                    <div
                                        class="w-10 h-10 rounded-xl bg-gradient-to-br from-slate-100 to-slate-200 border border-slate-300/50 flex items-center justify-center text-xs font-black text-slate-600 group-hover:from-orange-500 group-hover:to-orange-600 group-hover:text-white group-hover:shadow-md group-hover:shadow-orange-500/20 group-hover:border-transparent transition-all duration-300 uppercase tracking-tighter shrink-0">
                                        {{ mb_substr($item->product->name, 0, 2) }}
                                    </div>
                                    <div class="min-w-0">
                                        <p
                                            class="text-xs font-bold text-slate-800 group-hover:text-orange-600 transition-colors truncate">
                                            {{ $item->product->name }}</p>
                                        <p class="text-[11px] font-semibold text-slate-400 mt-0.5">
                                            Contador: <span
                                                class="text-slate-700 font-bold bg-slate-100 px-1.5 py-0.5 rounded text-[10px] ml-0.5 group-hover:bg-orange-50 group-hover:text-orange-700">{{ (int) $item->total_qty }}
                                                u.</span>
                                        </p>
                                    </div>
                                </div>
                                <span
                                    class="text-xs font-black text-slate-800 bg-slate-100 px-2.5 py-1.5 rounded-xl border border-slate-200/60 group-hover:bg-white group-hover:border-orange-200 transition-all shrink-0 ml-2">
                                    <span
                                        class="text-[10px] text-slate-400 font-bold mr-0.5">{{ $empresa->currency_simbol }}</span>{{ number_format($item->total_money, 2) }}
                                </span>
                            </div>
                        @empty
                            <div class="flex flex-col items-center justify-center py-12 text-center">
                                <div
                                    class="w-12 h-12 rounded-full bg-slate-50 flex items-center justify-center text-slate-300 border border-slate-100 mb-3">
                                    <i class="fa-solid fa-utensils text-lg"></i>
                                </div>
                                <p class="text-xs font-medium text-slate-400 italic">Sin datos de venta</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                {{-- ÚLTIMOS GASTOS --}}
                <div class="bg-white rounded-2xl border border-slate-200 shadow-xl shadow-slate-100 p-4 sm:p-6">
                    <h3
                        class="font-black text-slate-800 text-xs tracking-widest uppercase border-b border-slate-100 pb-4 mb-5 flex items-center justify-between gap-2">
                        <span>💸 Últimos Gastos</span>
                        <a href="{{ route('expenses.index') }}"
                            class="text-[10px] text-rose-600 bg-rose-50 hover:bg-rose-100 px-2 py-0.5 rounded font-bold uppercase tracking-normal transition-all shrink-0">
                            Ver todos
                        </a>
                    </h3>

                    <div class="space-y-4">
                        @forelse ($ultimosGastos as $gasto)
                            <div
                                class="flex items-center justify-between group p-2.5 rounded-xl hover:bg-slate-50 transition-all duration-200 border border-transparent hover:border-slate-100">
                                <div class="flex items-center gap-3.5 min-w-0">
                                    <div
                                        class="w-10 h-10 rounded-xl bg-gradient-to-br from-rose-50 to-rose-100 border border-rose-200/50 flex items-center justify-center text-rose-600 shrink-0">
                                        <i class="fa-solid fa-money-bill-transfer text-sm"></i>
                                    </div>
                                    <div class="min-w-0">
                                        <p class="text-xs font-bold text-slate-800 truncate">
                                            {{ $gasto->concept }}
                                        </p>
                                        <p class="text-[11px] font-semibold text-slate-400 mt-0.5">
                                            {{ $gasto->cashRegister?->name ?? 'Caja eliminada' }} ·
                                            {{ $gasto->expense_date->format('H:i A') }}
                                        </p>
                                    </div>
                                </div>
                                <span class="text-xs font-black text-rose-600 shrink-0 ml-2">
                                    -{{ $empresa->currency_simbol }}{{ number_format($gasto->amount, 2) }}
                                </span>
                            </div>
                        @empty
                            <div class="flex flex-col items-center justify-center py-8 text-center">
                                <div
                                    class="w-12 h-12 rounded-full bg-slate-50 flex items-center justify-center text-slate-300 border border-slate-100 mb-3">
                                    <i class="fa-solid fa-receipt text-lg"></i>
                                </div>
                                <p class="text-xs font-medium text-slate-400 italic">Sin gastos registrados en esta
                                    fecha</p>
                            </div>
                        @endforelse
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-admin-layout>