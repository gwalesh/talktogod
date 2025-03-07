<?php

namespace App\Livewire;

use App\Models\ChatHistory;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\Attributes\Rule;

class ChatComponent extends Component
{
    #[Rule('required|string|max:1000')]
    public $message = '';
    
    public $messages = [];
    public $religion = 'default';
    public $error = null;
    public $isLoading = false;

    public function mount()
    {
        $this->messages = session()->get('messages', []);
        $this->religion = session()->get('religion', 'default');
    }

    public function sendMessage()
    {
        try {
            $this->validate();

            $user = auth()->user();

            // Check message limit for free tier
            if (!$user->isPremium()) {
                $messageCount = $user->chatHistory()
                    ->whereDate('created_at', today())
                    ->count();

                if ($messageCount >= 10) {
                    $this->error = 'You have reached your daily message limit. Please upgrade to premium for unlimited messages.';
                    return;
                }
            }

            // Store the message before setting loading state
            $userMessage = $this->message;
            $this->message = ''; // Clear input early for better UX

            // Add user message
            $this->messages[] = [
                'role' => 'user',
                'content' => $userMessage
            ];

            $this->isLoading = true;

            // Prepare system message for spiritual context
            $systemMessage = [
                'role' => 'system',
                'content' => "You are a spiritual guide providing thoughtful, respectful answers to questions about faith, spirituality, and life's deeper meaning. Maintain a compassionate and non-judgmental tone."
            ];

            // Prepare messages array with system message
            $messages = [$systemMessage, ...$this->messages];

            // Call Deepseek API
            Log::info('Sending request to Deepseek API', [
                'messages' => $messages,
                'model' => 'deepseek-chat'
            ]);

            $response = Http::timeout(60)
                ->retry(3, 100)
                ->withHeaders([
                    'Authorization' => 'Bearer ' . config('services.deepseek.api_key'),
                    'Content-Type' => 'application/json',
                ])->post('https://api.deepseek.com/chat/completions', [
                    'model' => 'deepseek-chat',
                    'messages' => $messages,
                    'temperature' => 0.7,
                    'max_tokens' => 1000,
                    'stream' => false
                ]);

            Log::info('Deepseek API response', [
                'status' => $response->status(),
                'body' => $response->body(),
                'headers' => $response->headers()
            ]);

            if ($response->failed()) {
                Log::error('Deepseek API error', [
                    'status' => $response->status(),
                    'body' => $response->body(),
                    'headers' => $response->headers(),
                    'request' => [
                        'messages' => $messages,
                        'model' => 'deepseek-chat'
                    ]
                ]);

                $errorMessage = 'An error occurred while processing your request.';
                
                if ($response->status() === 401) {
                    $errorMessage = 'Authentication error. Please check your API key.';
                } elseif ($response->status() === 429) {
                    $errorMessage = 'Rate limit exceeded. Please try again later.';
                } elseif ($response->status() === 500) {
                    $errorMessage = 'Service is temporarily unavailable. Please try again later.';
                } elseif ($response->status() === 404) {
                    $errorMessage = 'API endpoint not found. Please check the API configuration.';
                }

                $this->error = $errorMessage;
                return;
            }

            $responseData = $response->json();

            if (!isset($responseData['choices'][0]['message']['content'])) {
                Log::error('Unexpected Deepseek API response format', ['response' => $responseData]);
                throw new \Exception('Unexpected response format from Deepseek API');
            }

            // Add AI response
            $this->messages[] = [
                'role' => 'assistant',
                'content' => $responseData['choices'][0]['message']['content']
            ];

            // Store in chat history
            ChatHistory::create([
                'user_id' => $user->id,
                'message' => $userMessage,
                'response' => $responseData['choices'][0]['message']['content']
            ]);

            // Save to session
            session(['messages' => $this->messages]);
            $this->error = null;

            // Dispatch event for scrolling
            $this->dispatch('messageAdded');
            
        } catch (\Exception $e) {
            Log::error('Chat error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            $this->error = 'An error occurred: ' . $e->getMessage();
        } finally {
            $this->isLoading = false;
        }
    }

    public function clearChat()
    {
        $this->messages = [];
        session()->forget('messages');
        $this->dispatch('messageAdded');
    }

    public function render()
    {
        return view('livewire.chat-component');
    }

    protected function parseMarkdown($content)
    {
        $config = [
            'html_input' => 'strip',
            'allow_unsafe_links' => false,
        ];
        
        $environment = new \League\CommonMark\Environment\Environment($config);
        $environment->addExtension(new \League\CommonMark\Extension\CommonMark\CommonMarkCoreExtension());
        $environment->addExtension(new \League\CommonMark\Extension\GithubFlavoredMarkdownExtension());
        
        $converter = new \League\CommonMark\MarkdownConverter($environment);
        
        return $converter->convert($content)->getContent();
    }
} 