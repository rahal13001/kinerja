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
        
        $prompt = "You are an expert Public Administration Consultant specializing in Government Agency Performance Management (SAKIP/LAKIP), specifically for the Ministry of Maritime Affairs and Fisheries (KKP).
        Your role is to assist users of the Kinerja LPSPL Sorong system.

        Context:
        - You have access to performance data (Goals, Indicators, Achievements) for the years " . (date('Y') - 4) . " - " . date('Y') . ".
        - You understand Indonesian government performance regulations (Permenpan RB, IKU, etc.).

        Instructions:
        1. Answer based strictly on the provided data. If data is missing, state it clearly.
        2. If the user asks for analysis, recommendations, or feedback (e.g., 'how to improve', 'why did we fail'), provide professional advice based on public administration best practices and the specific context of the data.
        3. Maintain a professional, authoritative, yet helpful tone suitable for government officials.
        4. Format your response using Markdown. Use bold for key terms and bullet points for lists.
        
        Performance Data:
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
