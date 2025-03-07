<?php

namespace Tests\Feature;

use App\Livewire\ChatComponent;
use App\Models\User;
use App\Models\ChatHistory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Livewire\Livewire;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class ChatComponentTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Http::preventStrayRequests();
    }

    #[Test]
    public function it_shows_empty_state_when_no_messages()
    {
        $user = User::factory()->create(['is_premium' => false]);
        
        Livewire::actingAs($user)
            ->test(ChatComponent::class)
            ->assertSee('Start your spiritual conversation...');
    }

    #[Test]
    public function it_requires_message_input()
    {
        $user = User::factory()->create(['is_premium' => false]);
        
        Livewire::actingAs($user)
            ->test(ChatComponent::class)
            ->set('message', '')
            ->call('sendMessage')
            ->assertHasErrors('message');
    }

    #[Test]
    public function it_enforces_message_length_limit()
    {
        $user = User::factory()->create(['is_premium' => false]);
        
        Livewire::actingAs($user)
            ->test(ChatComponent::class)
            ->set('message', str_repeat('a', 1001))
            ->call('sendMessage')
            ->assertHasErrors('message');
    }

    #[Test]
    public function it_enforces_free_tier_message_limit()
    {
        $user = User::factory()->create(['is_premium' => false]);
        
        // Create 10 chat history entries for today
        ChatHistory::factory()->count(10)->create([
            'user_id' => $user->id,
            'created_at' => now()
        ]);

        Livewire::actingAs($user)
            ->test(ChatComponent::class)
            ->set('message', 'Hello')
            ->call('sendMessage')
            ->assertSee('You have reached your daily message limit');
    }

    #[Test]
    public function it_allows_premium_users_unlimited_messages()
    {
        $user = User::factory()->create(['is_premium' => true]);
        
        // Create more than 10 chat history entries
        ChatHistory::factory()->count(11)->create([
            'user_id' => $user->id,
            'created_at' => now()
        ]);

        // Mock Deepseek API response
        Http::fake([
            'api.deepseek.com/v1/chat/completions' => Http::response([
                'choices' => [
                    [
                        'message' => [
                            'content' => 'Test response'
                        ]
                    ]
                ]
            ], 200)
        ]);

        Livewire::actingAs($user)
            ->test(ChatComponent::class)
            ->set('message', 'Hello')
            ->call('sendMessage')
            ->assertDontSee('You have reached your daily message limit')
            ->assertSee('Test response');
    }

    #[Test]
    public function it_handles_api_errors_gracefully()
    {
        $user = User::factory()->create(['is_premium' => false]);

        Http::fake([
            'api.deepseek.com/v1/chat/completions' => Http::response([
                'error' => 'API Error'
            ], 500)
        ]);

        Livewire::actingAs($user)
            ->test(ChatComponent::class)
            ->set('message', 'Hello')
            ->call('sendMessage')
            ->assertSee('An error occurred');
    }

    #[Test]
    public function it_clears_chat_history()
    {
        $user = User::factory()->create(['is_premium' => false]);
        $messages = [
            ['role' => 'user', 'content' => 'Hello'],
            ['role' => 'assistant', 'content' => 'Hi']
        ];

        $component = Livewire::actingAs($user)
            ->test(ChatComponent::class)
            ->set('messages', $messages)
            ->call('clearChat')
            ->assertSet('messages', [])
            ->assertDispatched('messageAdded');

        $this->assertEmpty(session('messages'));
    }

    #[Test]
    public function it_stores_chat_in_session_and_database()
    {
        $user = User::factory()->create(['is_premium' => false]);

        Http::fake([
            'api.deepseek.com/v1/chat/completions' => Http::response([
                'choices' => [
                    [
                        'message' => [
                            'content' => 'Test response'
                        ]
                    ]
                ]
            ], 200)
        ]);

        Livewire::actingAs($user)
            ->test(ChatComponent::class)
            ->set('message', 'Hello')
            ->call('sendMessage');

        // Check session
        $messages = session('messages');
        $this->assertIsArray($messages);
        $this->assertNotEmpty($messages);
        $this->assertEquals('Hello', $messages[0]['content']);

        // Check database
        $this->assertDatabaseHas('chat_histories', [
            'user_id' => $user->id,
            'message' => 'Hello',
            'response' => 'Test response'
        ]);
    }
} 