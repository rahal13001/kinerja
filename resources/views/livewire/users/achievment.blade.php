<?php

use Livewire\Volt\Component;
use App\Models\Indicator;
use Mary\Traits\Toast;

new class extends Component {
    use Toast;

    public array $charts = [];

    
    public function Indicators()
    {
        return 
        Indicator::where('status_iku', 'aktif')
        ->with(['achievements.team', 'achievements' => function($query) {
            $query->orderBy('tahun_achievment');
        }])->get();
    }
  
    public function loadChartData()
    {
        // Fetch indicators with status_iku = 'aktif'
        $indicators = $this->Indicators();

       

        foreach ($indicators as $indicator) {
            $achievements = $indicator->achievements;
           

            if ($achievements instanceof \Illuminate\Support\Collection && $achievements->isNotEmpty()) {
                $labels = [];
                $targetData = [];
                $realisasiData = [];
                $nama_iku = $indicator->nama_iku;

                foreach ($achievements->groupBy('tahun_achievment') as $year => $yearAchievements) {
                    $labels[] = $year;
                    $targetData[] = $yearAchievements->sum('target_achievment');
                    $realisasiData[] = $yearAchievements->sum('realisasi_achievment');
                }
                
                $this->charts[] = [
                    'nama_iku' => $nama_iku,
                    'nama_tim' => $achievements->first()->team->nama_tim,
                    'type' => 'bar',
                    'data' => [
                        'labels' => $labels,
                        'datasets' => [
                            [
                                'label' => 'Target Achievements',
                                'backgroundColor' => 'rgba(54, 162, 235, 0.2)',
                                'borderColor' => 'rgba(54, 162, 235, 1)',
                                'borderWidth' => 1,
                                'data' => $targetData,
                            ],
                            [
                                'label' => 'Realization Achievements',
                                'backgroundColor' => 'rgba(75, 192, 192, 0.2)',
                                'borderColor' => 'rgba(75, 192, 192, 1)',
                                'borderWidth' => 1,
                                'data' => $realisasiData,
                            ],
                        ]
                    ],
                    'options' => [
                        'scales' => [
                            'y' => [
                                'beginAtZero' => true,
                            ],
                        ],
                    ],
                ];
            }
        }

        // Debug the $charts array after processing
       // Check if $charts is populated
    }

    public function with(): array
    {
        $this->loadChartData(); // Load the chart data

        return [
            'charts' => $this->charts,  // Pass charts to the view
        ];
    }
};
?>

    <div>
        <!-- Debugging the charts array -->
        @dump($charts)

        <x-card>
            @foreach($charts as $chart)
            <div class="mb-4">
                <h3>{{ $chart['nama_iku'] }} - {{ $chart['nama_tim'] }}</h3>
                <x-chart :wire:key="$loop->index" :chart="$chart" />
            </div>
            @endforeach
        </x-card>
    </div>