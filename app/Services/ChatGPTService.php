<?php

namespace App\Services;

use App\Models\ChatHistory;
use App\Models\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ChatGPTService
{
    private string $apiKey;
    private string $apiEndpoint = 'https://api.deepseek.com/v1/chat/completions';

    public function __construct()
    {
        $this->apiKey = config('services.deepseek.api_key');
    }

    public function generateResponse(User $user, string $message): string
    {
        try {
            $userProfile = $user->profile;
            $religion = $userProfile->religion;
            $denomination = $userProfile->denomination;

            $systemPrompt = $this->generateSystemPrompt($religion, $denomination);
            
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Content-Type' => 'application/json',
            ])->post($this->apiEndpoint, [
                'model' => 'deepseek-chat',
                'messages' => [
                    ['role' => 'system', 'content' => $systemPrompt],
                    ['role' => 'user', 'content' => $message],
                ],
                'temperature' => 0.7,
                'max_tokens' => 1000,
            ]);

            if (!$response->successful()) {
                Log::error('DeepSeek API Error', [
                    'status' => $response->status(),
                    'response' => $response->json(),
                ]);

                if ($response->status() === 429) {
                    return 'The service is temporarily unavailable due to API quota limits. Please try again later or contact support.';
                }

                throw new \Exception('Failed to generate response');
            }

            $aiResponse = $response->json()['choices'][0]['message']['content'];

            // Save chat history
            ChatHistory::create([
                'user_id' => $user->id,
                'user_message' => $message,
                'ai_response' => $aiResponse,
                'religion_context' => $religion,
                'topic' => $this->extractTopic($message),
                'metadata' => [
                    'model' => 'deepseek-chat',
                    'tokens' => $response->json()['usage']['total_tokens'] ?? null,
                ],
            ]);

            return $aiResponse;
        } catch (\Exception $e) {
            Log::error('DeepSeek Service Error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return 'An error occurred while processing your request. Please try again later.';
        }
    }

    private function generateSystemPrompt(string $religion, ?string $denomination): string
    {
        $basePrompt = "You are a spiritual guide with deep knowledge of {$religion}";
        
        if ($denomination) {
            $basePrompt .= ", specifically {$denomination}";
        }
        
        $basePrompt .= ". Your role is to provide guidance and answers based on religious texts and teachings. ";
        $basePrompt .= "Always maintain a respectful and compassionate tone. ";
        $basePrompt .= "When appropriate, reference specific religious texts or teachings. ";
        $basePrompt .= "If you're unsure about something, be honest about it. ";
        $basePrompt .= "Focus on providing spiritual guidance while respecting the user's beliefs.";
        
        return $basePrompt;
    }

    private function extractTopic(string $message): string
    {
        // Simple topic extraction - can be enhanced with more sophisticated NLP
        $words = str_word_count(strtolower($message), 1);
        $stopWords = ['the', 'be', 'to', 'of', 'and', 'a', 'in', 'that', 'have', 'i', 'it', 'for', 'not', 'on', 'with', 'he', 'as', 'you', 'do', 'at'];
        $words = array_diff($words, $stopWords);
        
        return implode(' ', array_slice($words, 0, 3));
    }
} 