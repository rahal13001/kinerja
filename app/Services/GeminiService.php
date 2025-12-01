<?php

namespace App\Services;

use App\Models\PerformanceGoal;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GeminiService
{
    protected $apiKey;
    protected $baseUrl = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent';

    public function __construct()
    {
        $this->apiKey = config('services.gemini.api_key');
    }



    public function generateResponse(string $userMessage)
    {
        $context = $this->getPerformanceContext();
        
        $prompt = "You are a helpful assistant for the Government Performance Publication System (Kinerja LPSPL Sorong). 
        Use the following performance data to answer the user's question. 
        If the answer is not in the data, politely say you don't have that information.
        Do not make up facts. Keep answers concise and friendly.
        Format your response using Markdown. Use bold for key terms and bullet points for lists to make it easy to read.
        
        Performance Data (Years " . (date('Y') - 4) . " - " . date('Y') . "):
        " . json_encode($context) . "
        
        User Question: " . $userMessage;

        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
            ])->post($this->baseUrl . '?key=' . $this->apiKey, [
                'contents' => [
                    [
                        'parts' => [
                            ['text' => $prompt]
                        ]
                    ]
                ]
            ]);

            if ($response->successful()) {
                return $response->json()['candidates'][0]['content']['parts'][0]['text'] ?? 'Maaf, saya tidak dapat memproses permintaan Anda saat ini.';
            }

            Log::error('Gemini API Error: ' . $response->body());
            return 'Error: ' . $response->body();
        } catch (\Exception $e) {
            Log::error('Gemini Service Exception: ' . $e->getMessage());
            return 'System Error: ' . $e->getMessage();
        }
    }

    protected function getPerformanceContext()
    {
        $years = range(date('Y') - 4, date('Y'));
        
        return PerformanceGoal::with(['indicators.achievements' => function($q) use ($years) {
            $q->whereIn('year', $years);
        }])->get()->map(function($goal) {
            return [
                'goal' => $goal->goal,
                'indicators' => $goal->indicators->map(function($indicator) {
                    return [
                        'name' => $indicator->name,
                        'unit' => $indicator->unit,
                        'achievements' => $indicator->achievements->map(function($ach) {
                            // Determine latest realization for this specific year
                            $realization = 0;
                            $target = 0;
                            $quarter = '';
                            
                            if ($ach->achievement_q4 !== null) {
                                $realization = $ach->achievement_q4;
                                $target = $ach->target_q4;
                                $quarter = 'Q4';
                            } elseif ($ach->achievement_q3 !== null) {
                                $realization = $ach->achievement_q3;
                                $target = $ach->target_q3;
                                $quarter = 'Q3';
                            } elseif ($ach->achievement_q2 !== null) {
                                $realization = $ach->achievement_q2;
                                $target = $ach->target_q2;
                                $quarter = 'Q2';
                            } elseif ($ach->achievement_q1 !== null) {
                                $realization = $ach->achievement_q1;
                                $target = $ach->target_q1;
                                $quarter = 'Q1';
                            }

                            return [
                                'year' => $ach->year,
                                'target' => $target,
                                'realization' => $realization,
                                'latest_quarter' => $quarter
                            ];
                        })->values()
                    ];
                })
            ];
        });
    }
}
