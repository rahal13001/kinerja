<?php

namespace App\Livewire;

use App\Models\PerformanceGoal;
use Livewire\Component;

class PublicPerformance extends Component
{
    public $selectedYear;
    public $search = '';
    public $selectedIndicator = null;
    public $trendData = [];

    public function mount()
    {
        $this->selectedYear = date('Y');
    }

    public function showDetail($indicatorId)
    {
        $this->selectedIndicator = \App\Models\Indicator::with([
            'changes' => function ($query) {
                $query->where('status', true)->latest('revision_date');
            },
            'achievements' => function ($query) {
                $query->whereIn('year', range($this->selectedYear - 4, $this->selectedYear + 1));
            }
        ])->find($indicatorId);

        if ($this->selectedIndicator) {
            // Mask Name
            $latestChange = $this->selectedIndicator->changes->first();
            $this->selectedIndicator->display_name = $latestChange ? $latestChange->revision_name : $this->selectedIndicator->name;
            
            // Current Year Achievement
            $this->selectedIndicator->current_achievement = $this->selectedIndicator->achievements->where('year', $this->selectedYear)->first();

            // Trend Data (Last 5 Years)
            $this->trendData = [];
            for ($i = 4; $i >= 0; $i--) {
                $year = $this->selectedYear - $i;
                $achievement = $this->selectedIndicator->achievements->where('year', $year)->first();
                
                if ($achievement) {
                    if ($achievement->achievement_q4 !== null) {
                        $realization = $achievement->achievement_q4;
                    } elseif ($achievement->achievement_q3 !== null) {
                        $realization = $achievement->achievement_q3;
                    } elseif ($achievement->achievement_q2 !== null) {
                        $realization = $achievement->achievement_q2;
                    } elseif ($achievement->achievement_q1 !== null) {
                        $realization = $achievement->achievement_q1;
                    } else {
                        $realization = 0;
                    }
                } else {
                    $realization = 0;
                }
                
                $this->trendData[] = [
                    'year' => $year,
                    'realization' => $realization
                ];
            }
            
            $this->dispatch('render-chart', data: $this->trendData);
        }
    }

    public function closeDetail()
    {
        $this->selectedIndicator = null;
        $this->trendData = [];
    }

    public function render()
    {
        $performanceGoals = PerformanceGoal::with([
            'changes' => function ($query) {
                $query->where('status', true)->latest('revision_date');
            },
            'indicators' => function ($query) {
                $query->where('status', true)
                      ->whereHas('achievements', function ($q) {
                          $q->where('year', $this->selectedYear);
                      });
            },
            'indicators.changes' => function ($query) {
                $query->where('status', true)->latest('revision_date');
            },
            'indicators.achievements' => function ($query) {
                $query->where('year', $this->selectedYear);
            }
        ])
        ->where('status', true)
        ->whereHas('indicators', function ($query) {
            $query->where('status', true)
                  ->whereHas('achievements', function ($q) {
                      $q->where('year', $this->selectedYear);
                  });
        })
        ->get()
        ->map(function ($goal) {
            // Mask Goal Name
            $latestGoalChange = $goal->changes->first();
            $goal->display_name = $latestGoalChange ? $latestGoalChange->revision_name : $goal->goal;
            $goal->original_name = $latestGoalChange ? $goal->goal : null;

            // Mask Indicator Names
            $goal->indicators->transform(function ($indicator) {
                $latestIndicatorChange = $indicator->changes->first();
                $indicator->display_name = $latestIndicatorChange ? $latestIndicatorChange->revision_name : $indicator->name;
                $indicator->original_name = $latestIndicatorChange ? $indicator->name : null;
                
                // Get Achievement for selected year
                $indicator->achievement = $indicator->achievements->first();
                
                return $indicator;
            });

            return $goal;
        })
        ->filter(function ($goal) {
            if (empty($this->search)) {
                return true;
            }

            $search = strtolower($this->search);
            
            // Check if Goal matches
            $goalMatches = str_contains(strtolower($goal->display_name), $search) || 
                           str_contains(strtolower($goal->original_name ?? ''), $search);

            // Filter indicators
            $goal->indicators = $goal->indicators->filter(function ($indicator) use ($search, $goalMatches) {
                if ($goalMatches) {
                    return true;
                }
                return str_contains(strtolower($indicator->display_name), $search) || 
                       str_contains(strtolower($indicator->original_name ?? ''), $search);
            });

            // Return true if goal matches OR has matching indicators
            return $goalMatches || $goal->indicators->isNotEmpty();
        });

        return view('livewire.public-performance', [
            'performanceGoals' => $performanceGoals,
            'years' => range(date('Y') - 4, date('Y')), // Last 5 years
        ])->layout('layouts.app');
    }
}
