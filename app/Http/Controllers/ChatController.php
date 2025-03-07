<?php

namespace App\Http\Controllers;

use App\Models\ChatHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class ChatController extends Controller
{
    public function index(): View
    {
        return view('chat.index', [
            'messages' => session()->get('messages', []),
            'religion' => session()->get('religion', 'default'),
            'isPremium' => auth()->user()->isPremium()
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        // Get existing messages from session or initialize empty array
        $messages = session()->get('messages', []);

        // Add user message
        $messages[] = [
            'role' => 'user',
            'content' => $request->message,
        ];

        // Get Deepseek response
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . config('services.deepseek.api_key'),
                'Content-Type' => 'application/json',
            ])->post('https://api.deepseek.com/chat/completions', [
                'model' => 'deepseek-chat',
                'messages' => array_map(function($message) {
                    return [
                        'role' => $message['role'],
                        'content' => $message['content']
                    ];
                }, $messages),
                'temperature' => 0.7,
                'max_tokens' => 1000,
                'stream' => false
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
                    $errorMessage = 'Authentication error. Please contact support.';
                } elseif ($response->status() === 429) {
                    $errorMessage = 'Rate limit exceeded. Please try again later.';
                } elseif ($response->status() === 500) {
                    $errorMessage = 'Service is temporarily unavailable. Please try again later.';
                }

                return back()->with('error', $errorMessage);
            }

            $responseData = $response->json();

            // Add AI response to messages
            $messages[] = [
                'role' => 'assistant',
                'content' => $responseData['choices'][0]['message']['content'],
            ];

            // Store in chat history if user is authenticated
            if (Auth::check()) {
                ChatHistory::create([
                    'user_id' => Auth::id(),
                    'message' => $request->message,
                    'response' => $responseData['choices'][0]['message']['content'],
                ]);
            }

            // Store updated messages in session
            session(['messages' => $messages]);

            return back()->with('success', 'Message sent successfully');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to get response. Please try again.');
        }
    }

    public function clear()
    {
        session()->forget('messages');
        return back()->with('success', 'Chat history cleared');
    }
} 