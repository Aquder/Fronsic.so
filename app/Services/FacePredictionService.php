<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Client\ConnectionException;

class FacePredictionService
{
    protected string $baseUrl = 'https://anastamer-deepface-project.hf.space';

    public function analyzeDistortedFace($file): ?array
    {
        ini_set('memory_limit', '512M');

        try {
            $response = Http::timeout(300)
                ->retry(3, 10000, function ($exception, $request) {
                 
                    Log::warning('Retrying AI API connection due to sleep mode or timeout...');
                    return $exception instanceof ConnectionException ||
                           ($exception->response && $exception->response->serverError());
                })
                ->attach('file', fopen($file->getRealPath(), 'r'), $file->getClientOriginalName())
                ->post("{$this->baseUrl}/forensicAnalysis");

            if ($response->successful()) {
                return $response->json();
            }

            Log::error('AI API Error Response:', [
                'status' => $response->status(),
                'body'   => $response->body()
            ]);
            return null;

        } catch (\Exception $e) {
            Log::error('AI API Exception:', ['message' => $e->getMessage()]);
            return null;
        }
    }
}
