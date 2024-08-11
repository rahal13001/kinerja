<?php

namespace App\Filament\Guest\Resources\DashboardResource\Widgets;

use App\Models\Period;
use App\Models\WorkValue;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Leandrocfe\FilamentApexCharts\Widgets\ApexChartWidget;

class WorkValuesChart extends ApexChartWidget
{
    /**
     * Chart Id
     *
     * @var string
     */
    protected static ?string $chartId = 'workValuesChart';

    /**
     * Widget Title
     *
     * @var string|null
     */
    protected static ?string $heading = 'Grafik Penilaian Kinerja Organisasi';

    /**
     * Chart options (series, labels, types, size, animations...)
     * https://apexcharts.com/docs/options
     *
     * @return array
     */
    protected function getOptions(): array
    {
        // Fetch data from the database
        $workValues = WorkValue::with('period')
            ->orderBy('tahun_kinerja')
            ->orderBy('period_id')
            ->get();

        // Initialize arrays for categories and series
        $categories = [];
        $seriesData = [];
        $years = [];

        // Group data by tahun_kinerja
        foreach ($workValues as $value) {
            $year = $value->tahun_kinerja;
            $periodName = $value->period->periode;

            // Add period name to categories if not already added
            if (!in_array($periodName, $categories)) {
                $categories[] = $periodName;
            }

            // Prepare series data
            if (!isset($seriesData[$year])) {
                $seriesData[$year] = [
                    'name' => $year,
                    'data' => []
                ];
            }

            // Fill the data for each period, assuming periods are always in the same order
            $seriesData[$year]['data'][] = $value->nilai_kinerja;

            // Ensure we track the years used
            if (!in_array($year, $years)) {
                $years[] = $year;
            }
        }

        // Convert associative array to indexed array for the series
        $series = array_values($seriesData);

        return [
            'chart' => [
                'type' => 'bar',
                'height' => 350,
             ],
            'series' => $series,
            'xaxis' => [
                'categories' => $categories,
                'labels' => [
                    'style' => [
                        'fontFamily' => 'inherit',
                    ],
                ],
                'title' => [
                    'text' => 'Periode',
                ],
            ],
            'yaxis' => [
                'labels' => [
                    'style' => [
                        'fontFamily' => 'inherit',
                    ],
                ],
                'title' => [
                    'text' => 'Nilai Kinerja',
                ],
            ],
            'plotOptions' => [
                'bar' => [
                    'borderRadius' => 3,
                    'horizontal' => false,
                ],
            ],
            'legend' => [
                'position' => 'top',
                'horizontalAlign' => 'center',
            ],
            'colors' => ['#007bff', '#ffcc00', '#1cbc94' ], // Adjust colors to differentiate years
        ];
    }
}
