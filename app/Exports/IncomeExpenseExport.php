<?php

namespace App\Exports;

use App\Models\Expense;
use App\Models\Sale;
use App\Models\Setting;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;

/**
 * Reporte pensado para el contador: resume, mes a mes, cuanto entro (ventas),
 * cuanto salio (gastos) y la utilidad neta, dentro de un rango de fechas.
 */
class IncomeExpenseExport implements FromCollection, WithHeadings, WithStyles, WithCustomStartCell, ShouldAutoSize, WithEvents
{
    protected Setting $config;
    protected ?string $from;
    protected ?string $to;
    protected Collection $filas;

    public function __construct(?string $from = null, ?string $to = null)
    {
        $this->from = $from;
        $this->to = $to;
        $this->config = Setting::first() ?? new Setting(['company_name' => 'Sistema', 'currency_simbol' => 'S/']);
    }

    public function collection()
    {
        $ventasPorMes = Sale::query()
            ->when($this->from, fn($q) => $q->whereDate('paid_at', '>=', $this->from))
            ->when($this->to, fn($q) => $q->whereDate('paid_at', '<=', $this->to))
            ->selectRaw("DATE_FORMAT(paid_at, '%Y-%m') as periodo, SUM(total) as total")
            ->groupBy('periodo')
            ->pluck('total', 'periodo');

        $gastosPorMes = Expense::query()
            ->when($this->from, fn($q) => $q->whereDate('expense_date', '>=', $this->from))
            ->when($this->to, fn($q) => $q->whereDate('expense_date', '<=', $this->to))
            ->selectRaw("DATE_FORMAT(expense_date, '%Y-%m') as periodo, SUM(amount) as total")
            ->groupBy('periodo')
            ->pluck('total', 'periodo');

        $periodos = $ventasPorMes->keys()
            ->merge($gastosPorMes->keys())
            ->unique()
            ->sort()
            ->values();

        $this->filas = $periodos->map(function ($periodo) use ($ventasPorMes, $gastosPorMes) {
            $ingresos = (float) ($ventasPorMes[$periodo] ?? 0);
            $egresos = (float) ($gastosPorMes[$periodo] ?? 0);

            return [
                'periodo' => $periodo,
                'ingresos' => $ingresos,
                'egresos' => $egresos,
                'utilidad' => $ingresos - $egresos,
            ];
        });

        return $this->filas;
    }

    public function startCell(): string
    {
        return 'A7';
    }

    public function headings(): array
    {
        $simbol = $this->config->currency_simbol ?? 'S/';

        return [
            'Mes',
            'Ingresos (' . $simbol . ')',
            'Egresos (' . $simbol . ')',
            'Utilidad Neta (' . $simbol . ')',
        ];
    }

    public function map($fila): array
    {
        return [
            Carbon::createFromFormat('Y-m', $fila['periodo'])->translatedFormat('F Y'),
            $fila['ingresos'],
            -1 * abs($fila['egresos']),
            $fila['utilidad'],
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            7 => [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF'], 'size' => 11],
                'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '166534']],
                'alignment' => ['vertical' => Alignment::VERTICAL_CENTER],
            ],
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                $companyName = $this->config->company_name ?? 'Sistema';
                $companyTaxId = $this->config->tax_id ? 'RUC: ' . $this->config->tax_id : '';
                $companyPhone = $this->config->company_phone ? 'Tel: ' . $this->config->company_phone : '';
                $reportTitle = 'ESTADO DE INGRESOS Y EGRESOS';
                $rango = 'Periodo: ' . ($this->from ?: 'inicio') . ' al ' . ($this->to ?: now()->format('Y-m-d'));
                $generatedAt = 'Generado el: ' . now()->format('d/m/Y h:i A');

                $sheet->setCellValue('A2', mb_strtoupper($companyName, 'UTF-8'));
                $sheet->setCellValue('A3', trim($companyTaxId . ' ' . $companyPhone));
                $sheet->setCellValue('B2', $reportTitle);
                $sheet->setCellValue('B3', $rango);
                $sheet->setCellValue('C3', $generatedAt);

                $sheet->mergeCells('A2:A3');
                $sheet->getStyle('A2')->applyFromArray([
                    'font' => ['bold' => true, 'size' => 14, 'color' => ['rgb' => '166534']],
                ]);
                $sheet->getStyle('B2')->applyFromArray([
                    'font' => ['bold' => true, 'size' => 12],
                ]);
                $sheet->getStyle('B3:C3')->applyFromArray([
                    'font' => ['italic' => true, 'size' => 9, 'color' => ['rgb' => '64748B']],
                ]);

                $highestRow = $sheet->getHighestRow();

                if ($highestRow >= 7) {
                    // Fila de totales al final
                    $totalRow = $highestRow + 1;
                    $ingresosTotal = $this->filas->sum('ingresos');
                    $egresosTotal = $this->filas->sum('egresos');
                    $utilidadTotal = $this->filas->sum('utilidad');

                    $sheet->setCellValue('A' . $totalRow, 'TOTAL');
                    $sheet->setCellValue('B' . $totalRow, $ingresosTotal);
                    $sheet->setCellValue('C' . $totalRow, -1 * abs($egresosTotal));
                    $sheet->setCellValue('D' . $totalRow, $utilidadTotal);

                    $sheet->getStyle('A' . $totalRow . ':D' . $totalRow)->applyFromArray([
                        'font' => ['bold' => true],
                        'borders' => [
                            'top' => ['borderStyle' => Border::BORDER_MEDIUM, 'color' => ['rgb' => '166534']],
                        ],
                    ]);

                    $sheet->getStyle('B8:D' . $totalRow)->getNumberFormat()
                        ->setFormatCode('#,##0.00;[Red]-#,##0.00;"-"');

                    $sheet->getStyle('A7:D' . $totalRow)->applyFromArray([
                        'borders' => [
                            'inside' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => 'E2E8F0']],
                            'outline' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => 'CBD5E1']],
                        ],
                    ]);
                }
            },
        ];
    }
}
