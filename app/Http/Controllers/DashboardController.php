<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Payment;
use App\Models\Sale;
use App\Models\Table;
use App\Models\SaleDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // FECHA SELECCIONADA (filtro): viene por ?fecha=YYYY-MM-DD, si no hay, es hoy.
        // Todas las métricas de "hoy" pasan a calcularse sobre esta fecha.
        $fecha = $request->filled('fecha')
            ? Carbon::parse($request->query('fecha'))->startOfDay()
            : Carbon::today();

        $fechaAnterior = $fecha->copy()->subDay();

        $hoy = $fecha;
        $ayer = $fechaAnterior;

        // VENTAS
        $ventasHoy = Sale::whereDate('paid_at', $hoy)->sum('total');
        $ventasAyer = Sale::whereDate('paid_at', $ayer)->sum('total');
        $variacionVentas = $ventasAyer > 0 ? (($ventasHoy - $ventasAyer) / $ventasAyer) * 100 : 100;

        // PROPINAS
        $propinasHoy = Sale::whereDate('paid_at', $hoy)->sum('tip');
        $propinasAyer = Sale::whereDate('paid_at', $ayer)->sum('tip');
        $variacionPropinas = $propinasAyer > 0 ? (($propinasHoy - $propinasAyer) / $propinasAyer) * 100 : 100;

        // GASTOS
        $gastosHoy = Expense::whereDate('expense_date', $hoy)->sum('amount');
        $gastosAyer = Expense::whereDate('expense_date', $ayer)->sum('amount');
        $variacionGastos = $gastosAyer > 0
            ? (($gastosHoy - $gastosAyer) / $gastosAyer) * 100
            : ($gastosHoy > 0 ? 100 : 0);

        // BALANCE NETO = VENTAS - GASTOS
        $balanceHoy = $ventasHoy - $gastosHoy;
        $balanceAyer = $ventasAyer - $gastosAyer;
        $variacionBalance = $balanceAyer != 0
            ? (($balanceHoy - $balanceAyer) / abs($balanceAyer)) * 100
            : ($balanceHoy != 0 ? 100 : 0);

        // MESAS (siempre es el estado actual, no depende de la fecha filtrada)
        $mesasTotales = Table::count();
        $mesasOcupadas = Table::where('status', 'ocupada')->count();
        $porcentajeOcupacion = $mesasTotales > 0 ? ($mesasOcupadas / $mesasTotales) * 100 : 0;

        // COCINA (siempre es el estado actual)
        $comandasEnCocina = OrderDetail::where('requires_kitchen', true)
            ->whereIn('cooking_status', ['pending', 'in_progress'])
            ->count();

        // ÚLTIMAS COMANDAS DE LA FECHA SELECCIONADA
        // AGREGADO: se excluyen órdenes "fantasma" -- órdenes que nunca
        // tuvieron ningún detalle asociado (ni siquiera cancelado) y que
        // tampoco tienen una venta registrada. Antes estas aparecían en el
        // Monitor de Comandas Recientes como filas vacías/mesas inexistentes.
        $ultimasComandas = Order::with(['table', 'details', 'sale'])
            ->where(function ($q) use ($hoy) {
                $q->whereDate('created_at', $hoy)
                    ->orWhereHas('sale', function ($q2) use ($hoy) {
                        $q2->whereDate('paid_at', $hoy);
                    });
            })
            ->where(function ($q) {
                $q->whereHas('details', function ($q2) {
                    $q2->where('cooking_status', '!=', 'cancelled');
                })
                    ->orWhereHas('sale');
            })
            ->orderBy('updated_at', 'desc')
            ->take(5)
            ->get();

        // ÚLTIMOS GASTOS DE LA FECHA SELECCIONADA
        $ultimosGastos = Expense::with(['cashRegister', 'paymentMethod', 'user'])
            ->whereDate('expense_date', $hoy)
            ->orderBy('expense_date', 'desc')
            ->take(5)
            ->get();

        // RANKING PRODUCTOS DE LA FECHA SELECCIONADA
        $rankingProductos = SaleDetail::select('product_id', DB::raw('SUM(quantity) as total_qty'), DB::raw('SUM(subtotal) as total_money'))
            ->whereHas('sale', function ($q) use ($hoy) {
                $q->whereDate('paid_at', $hoy);
            })
            ->with('product')
            ->groupBy('product_id')
            ->orderByDesc('total_qty')
            ->take(5)
            ->get();

        // ============================================
        // GRÁFICO DE TENDENCIA — VERSIÓN MENSUAL (últimos 6 meses)
        // ============================================
        $seisMesesAtras = Carbon::now()->subMonths(5)->startOfMonth();

        $ventasMensualesRaw = Sale::select(
            DB::raw("YEAR(paid_at) as anio"),
            DB::raw("MONTH(paid_at) as mes"),
            DB::raw("SUM(total) as total")
        )
            ->where('paid_at', '>=', $seisMesesAtras)
            ->groupBy('anio', 'mes')
            ->orderBy('anio', 'asc')
            ->orderBy('mes', 'asc')
            ->get();

        $chartVentasMesLabels = [];
        $chartVentasMesData = [];
        $mesesEspaniol = ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'];

        for ($i = 5; $i >= 0; $i--) {
            $mesObjeto = Carbon::now()->subMonths($i);
            $anioActual = $mesObjeto->year;
            $mesActual = $mesObjeto->month;

            $ventaDelMes = $ventasMensualesRaw->first(function ($item) use ($anioActual, $mesActual) {
                return (int) $item->anio === $anioActual && (int) $item->mes === $mesActual;
            });

            $chartVentasMesData[] = $ventaDelMes ? (float) $ventaDelMes->total : 0.0;
            $chartVentasMesLabels[] = $mesesEspaniol[$mesActual - 1] . ' ' . $mesObjeto->format('y');
        }

        $gastosMensualesRaw = Expense::select(
            DB::raw("YEAR(expense_date) as anio"),
            DB::raw("MONTH(expense_date) as mes"),
            DB::raw("SUM(amount) as total")
        )
            ->where('expense_date', '>=', $seisMesesAtras)
            ->groupBy('anio', 'mes')
            ->orderBy('anio', 'asc')
            ->orderBy('mes', 'asc')
            ->get();

        $chartGastosMesData = [];

        for ($i = 5; $i >= 0; $i--) {
            $mesObjeto = Carbon::now()->subMonths($i);
            $anioActual = $mesObjeto->year;
            $mesActual = $mesObjeto->month;

            $gastoDelMes = $gastosMensualesRaw->first(function ($item) use ($anioActual, $mesActual) {
                return (int) $item->anio === $anioActual && (int) $item->mes === $mesActual;
            });

            $chartGastosMesData[] = $gastoDelMes ? (float) $gastoDelMes->total : 0.0;
        }

        // ============================================
        // GRÁFICO DE TENDENCIA — VERSIÓN DIARIA (últimos 30 días)
        // ============================================
        $treintaDiasAtras = Carbon::now()->subDays(29)->startOfDay();

        $ventasDiariasRaw = Sale::select(
            DB::raw("DATE(paid_at) as dia"),
            DB::raw("SUM(total) as total")
        )
            ->where('paid_at', '>=', $treintaDiasAtras)
            ->groupBy('dia')
            ->orderBy('dia', 'asc')
            ->get();

        $gastosDiariosRaw = Expense::select(
            DB::raw("DATE(expense_date) as dia"),
            DB::raw("SUM(amount) as total")
        )
            ->where('expense_date', '>=', $treintaDiasAtras)
            ->groupBy('dia')
            ->orderBy('dia', 'asc')
            ->get();

        $chartVentasDiaLabels = [];
        $chartVentasDiaData = [];
        $chartGastosDiaData = [];

        for ($i = 29; $i >= 0; $i--) {
            $diaObjeto = Carbon::now()->subDays($i);
            $diaKey = $diaObjeto->format('Y-m-d');

            $ventaDelDia = $ventasDiariasRaw->firstWhere('dia', $diaKey);
            $gastoDelDia = $gastosDiariosRaw->firstWhere('dia', $diaKey);

            $chartVentasDiaData[] = $ventaDelDia ? (float) $ventaDelDia->total : 0.0;
            $chartGastosDiaData[] = $gastoDelDia ? (float) $gastoDelDia->total : 0.0;
            $chartVentasDiaLabels[] = $diaObjeto->format('d M');
        }

        // ============================================
        // GRÁFICO DE LA FECHA SELECCIONADA — VENTAS Y GASTOS POR HORA (0h a 23h)
        // ============================================
        $ventasPorHoraRaw = Sale::select(
            DB::raw("HOUR(paid_at) as hora"),
            DB::raw("SUM(total) as total")
        )
            ->whereDate('paid_at', $hoy)
            ->groupBy('hora')
            ->get();

        $gastosPorHoraRaw = Expense::select(
            DB::raw("HOUR(expense_date) as hora"),
            DB::raw("SUM(amount) as total")
        )
            ->whereDate('expense_date', $hoy)
            ->groupBy('hora')
            ->get();

        $chartHoraLabels = [];
        $chartVentasHoraData = [];
        $chartGastosHoraData = [];

        for ($h = 0; $h <= 23; $h++) {
            $ventaDeLaHora = $ventasPorHoraRaw->firstWhere('hora', $h);
            $gastoDeLaHora = $gastosPorHoraRaw->firstWhere('hora', $h);

            $chartVentasHoraData[] = $ventaDeLaHora ? (float) $ventaDeLaHora->total : 0.0;
            $chartGastosHoraData[] = $gastoDeLaHora ? (float) $gastoDeLaHora->total : 0.0;
            $chartHoraLabels[] = str_pad($h, 2, '0', STR_PAD_LEFT) . ':00';
        }

        // MÉTODOS DE PAGO DE LA FECHA SELECCIONADA
        $metodosPagoData = Payment::select('payment_methods.name', DB::raw('SUM(payments.amount) as total'))
            ->join('payment_methods', 'payments.payment_method_id', '=', 'payment_methods.id')
            ->whereDate('payments.created_at', $hoy)
            ->groupBy('payment_methods.name')
            ->get();

        $chartMetodosLabels = $metodosPagoData->pluck('name')->toArray();
        $chartMetodosData = $metodosPagoData->pluck('total')->map(fn($val) => (float) $val)->toArray();

        // RETORNO A LA VISTA
        return view('dashboard', compact(
            'fecha',
            'ventasHoy',
            'variacionVentas',
            'propinasHoy',
            'variacionPropinas',
            'gastosHoy',
            'variacionGastos',
            'balanceHoy',
            'variacionBalance',
            'mesasOcupadas',
            'mesasTotales',
            'porcentajeOcupacion',
            'comandasEnCocina',
            'ultimasComandas',
            'ultimosGastos',
            'rankingProductos',
            'chartVentasMesLabels',
            'chartVentasMesData',
            'chartGastosMesData',
            'chartVentasDiaLabels',
            'chartVentasDiaData',
            'chartGastosDiaData',
            'chartHoraLabels',
            'chartVentasHoraData',
            'chartGastosHoraData',
            'chartMetodosLabels',
            'chartMetodosData'
        ));
    }
}