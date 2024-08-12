<?php

use App\Models\Workvalue;
use Illuminate\Support\Collection;
use Livewire\Volt\Component;
use Mary\Traits\Toast;

new class extends Component {
    use Toast;

    public string $search = '';
    // public array $tahun_kinerja = [];

    public bool $drawer = false;

    public array $sortBy = ['column' => 'name', 'direction' => 'asc'];

    public array $myChart = [];

    // Clear filters
    public function clear(): void
    {
        $this->reset();
        $this->success('Filters cleared.', position: 'toast-bottom');
    }

    // Delete action
    public function delete($id): void
    {
        $this->warning("Will delete #$id", 'It is fake.', position: 'toast-bottom');
    }

    public function loadChartData()
    {
        // Fetch the data from the database
        $data = Workvalue::with('period')
            ->get()
            ->groupBy('period_id');

        $labels = [];
        $datasets = [];
        
        foreach ($data as $triwulan => $values) {
            $dataset = [
                'label' => "Triwulan $triwulan",
                'data' => [],
            ];

            foreach ($values as $value) {
                $labels[$value->tahun_kinerja] = $value->tahun_kinerja;
                $dataset['data'][] = $value->nilai_kinerja;
            }

            $datasets[] = $dataset;
        }

        $this->myChart = [
            'type' => 'bar', // Set the chart type to bar
            'data' => [
                'labels' => array_values($labels),
                'datasets' => $datasets,
            ],
        ];
    }

    public function with(): array
    {
        return [
            'loadChartData' => $this->loadChartData(),
            // 'headers' => $this->headers()
        ];
    }
}; ?>

<div>

    <x-header title="Grafik Nilai Kinerja Organisasi" separator progress-indicator>
        {{-- <x-slot:actions>
            <x-button label="Filters" @click="$wire.drawer = true" responsive icon="o-funnel" />
        </x-slot:actions> --}}
    </x-header>

    <!-- Chart  -->
    <x-card>         
        <x-chart wire:model="myChart" class="w-3/4 mx-auto"/>
    </x-card>

    <!-- FILTER DRAWER -->
    {{-- <x-drawer wire:model="drawer" title="Filters" right separator with-close-button class="lg:w-1/3">
        <x-input placeholder="Search..." wire:model.live.debounce="search" icon="o-magnifying-glass" @keydown.enter="$wire.drawer = false" />
        <div class="mt-3">
            <x-choices
                label="Pilih Tahun Kinerja"
                wire:model.live="tahun_kinerja"
                :options="$loadChartData"
                option-label="Tahun Kinerja"
                icon="o-map-pin"
                height="max-h-96"
                searchable
            />
        </div>

        <x-slot:actions>
            <x-button label="Reset" icon="o-x-mark" wire:click="clear" spinner />
            <x-button label="Done" icon="o-check" class="btn-primary" @click="$wire.drawer = false" />
        </x-slot:actions>
    </x-drawer> --}}

   
</div>
