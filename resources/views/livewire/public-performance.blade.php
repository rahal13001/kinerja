<div>
    <!-- Filters -->
    <div class="mb-8 flex flex-col sm:flex-row justify-between items-center gap-4">
        <!-- Search -->
        <div class="w-full sm:w-1/2">
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
                <input wire:model.live.debounce.300ms="search" type="text" class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-1 focus:ring-amber-500 focus:border-amber-500 sm:text-sm" placeholder="Cari Indikator atau Sasaran Kinerja...">
            </div>
        </div>

        <!-- Year Filter -->
        <div class="flex items-center gap-3 bg-white p-3 rounded-lg shadow-sm border border-gray-100">
            <label for="year" class="text-sm font-medium text-gray-700">Tahun Anggaran:</label>
            <select wire:model.live="selectedYear" id="year" class="border-gray-300 rounded-md shadow-sm focus:border-amber-500 focus:ring-amber-500 text-sm">
                @foreach($years as $year)
                    <option value="{{ $year }}">{{ $year }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <!-- ApexCharts -->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    <!-- Content -->
    <div class="space-y-8">
        @forelse($performanceGoals as $goal)
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <!-- Goal Header -->
                <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-bold text-gray-900">
                        {{ $goal->display_name }}
                    </h2>
                </div>

                <!-- Indicators Table -->
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-1/2">
                                    Indikator Kinerja
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Satuan
                                </th>
                                <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Target
                                </th>
                                <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Realisasi
                                </th>
                                <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Capaian (%)
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($goal->indicators as $indicator)
                                @php
                                    $ach = $indicator->achievement;
                                    $target = 0;
                                    $realization = 0;

                                    if ($ach) {
                                        if ($ach->achievement_q4 !== null) {
                                            $target = $ach->target_q4;
                                            $realization = $ach->achievement_q4;
                                        } elseif ($ach->achievement_q3 !== null) {
                                            $target = $ach->target_q3;
                                            $realization = $ach->achievement_q3;
                                        } elseif ($ach->achievement_q2 !== null) {
                                            $target = $ach->target_q2;
                                            $realization = $ach->achievement_q2;
                                        } elseif ($ach->achievement_q1 !== null) {
                                            $target = $ach->target_q1;
                                            $realization = $ach->achievement_q1;
                                        }
                                    }
                                    
                                    $rawPercentage = $target > 0 ? ($realization / $target) * 100 : 0;
                                    $percentage = min($rawPercentage, 120);
                                @endphp
                                <tr wire:click="showDetail({{ $indicator->id }})" class="hover:bg-gray-50 transition cursor-pointer">
                                    <td class="px-6 py-4">
                                        <div class="text-sm font-medium text-gray-900">
                                            {{ $indicator->display_name }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $indicator->unit }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-right font-mono">
                                        {{ number_format($target, 0, ',', '.') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-right font-mono">
                                        {{ number_format($realization, 0, ',', '.') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right">
                                        @if($target > 0)
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $percentage > 110 ? 'bg-blue-100 text-blue-800' : ($percentage >= 100 ? 'bg-green-100 text-green-800' : ($percentage >= 80 ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800')) }}">
                                                {{ number_format($percentage, 2, ',', '.') }}%
                                            </span>
                                        @else
                                            <span class="text-xs text-gray-400">-</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500 italic">
                                        Belum ada indikator untuk tujuan ini.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        @empty
            <div class="text-center py-12 bg-white rounded-xl border border-gray-200 border-dashed">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak ada data</h3>
                <p class="mt-1 text-sm text-gray-500">Belum ada Sasaran Kinerja yang dipublikasikan.</p>
            </div>
        @endforelse
    </div>

    <!-- Detail Modal -->
    @if($selectedIndicator)
        <div class="fixed inset-0 z-[100] overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <!-- Overlay -->
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" wire:click="closeDetail"></div>

            <!-- Modal Panel -->
            <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
                <div class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-4xl">
                    <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left w-full">
                                <h3 class="text-lg font-semibold leading-6 text-gray-900" id="modal-title">
                                    Detail Indikator Kinerja
                                </h3>
                                
                                <!-- Indicator Context -->
                                <div class="mt-4 bg-gray-50 p-4 rounded-lg border border-gray-100">
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <p class="text-xs text-gray-500 uppercase tracking-wider font-semibold">Indikator</p>
                                            <p class="text-sm font-medium text-gray-900 mt-1">{{ $selectedIndicator->display_name }}</p>
                                        </div>
                                        <div>
                                            <p class="text-xs text-gray-500 uppercase tracking-wider font-semibold">Satuan</p>
                                            <p class="text-sm font-medium text-gray-900 mt-1">{{ $selectedIndicator->unit }}</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-6">
                                    <!-- Quarterly Breakdown -->
                                    <h4 class="font-semibold text-gray-700 mb-3 flex items-center gap-2">
                                        <svg class="w-5 h-5 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                        </svg>
                                        Capaian Triwulan ({{ $selectedYear }})
                                    </h4>
                                    <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 rounded-lg mb-8">
                                        <table class="min-w-full divide-y divide-gray-300">
                                            <thead class="bg-gray-50">
                                                <tr>
                                                    <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">Periode</th>
                                                    <th scope="col" class="px-3 py-3.5 text-right text-sm font-semibold text-gray-900">Target</th>
                                                    <th scope="col" class="px-3 py-3.5 text-right text-sm font-semibold text-gray-900">Realisasi</th>
                                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Keterangan</th>
                                                </tr>
                                            </thead>
                                            <tbody class="divide-y divide-gray-200 bg-white">
                                                @php $ach = $selectedIndicator->current_achievement; @endphp
                                                @foreach(['q1' => 'Triwulan I', 'q2' => 'Triwulan II', 'q3' => 'Triwulan III', 'q4' => 'Triwulan IV'] as $key => $label)
                                                    <tr>
                                                        <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">{{ $label }}</td>
                                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500 text-right font-mono">{{ number_format($ach->{'target_'.$key} ?? 0, 0, ',', '.') }}</td>
                                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500 text-right font-mono">{{ number_format($ach->{'achievement_'.$key} ?? 0, 0, ',', '.') }}</td>
                                                        <td class="px-3 py-4 text-sm text-gray-500 text-left">{{ $ach->{'description_'.$key} ?? '-' }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>

                                    <!-- Trend Chart -->
                                    <h4 class="font-semibold text-gray-700 mb-3 flex items-center gap-2">
                                        <svg class="w-5 h-5 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z" />
                                        </svg>
                                        Tren Capaian 5 Tahun Terakhir
                                    </h4>
                                    <div class="bg-white p-4 rounded-lg border border-gray-100 shadow-sm">
                                        <div id="trendChart" class="w-full h-64"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                        <button type="button" wire:click="closeDetail" class="inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:ml-3 sm:w-auto">
                            Tutup
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <script>
        document.addEventListener('livewire:initialized', () => {
            let chart = null;

            Livewire.on('render-chart', (event) => {
                // Wait for modal to render
                setTimeout(() => {
                    const chartEl = document.querySelector("#trendChart");
                    if (chartEl) {
                        const data = event.data;
                        
                        if (chart) {
                            chart.destroy();
                        }

                        const options = {
                            series: [{
                                name: "Realisasi",
                                data: data.map(item => item.realization)
                            }],
                            chart: {
                                height: 350,
                                type: 'bar',
                                zoom: { enabled: false },
                                toolbar: { show: false }
                            },
                            dataLabels: { enabled: false },
                            stroke: { curve: 'straight', colors: ['#f59e0b'] },
                            title: { text: undefined, align: 'left' },
                            grid: { row: { colors: ['#f3f3f3', 'transparent'], opacity: 0.5 } },
                            xaxis: {
                                categories: data.map(item => item.year),
                            },
                            yaxis: {
                                // max removed to allow dynamic values
                                tickAmount: 6
                            },
                            colors: ['#f59e0b']
                        };

                        chart = new ApexCharts(chartEl, options);
                        chart.render();
                    }
                }, 100); // Small delay to ensure DOM is ready
            });
        });
    </script>
</div>
