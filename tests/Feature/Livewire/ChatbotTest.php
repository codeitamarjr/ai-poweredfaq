<?php

namespace Tests\Feature\Livewire;

use Tests\TestCase;
use App\Models\User;
use Livewire\Livewire;
use App\Livewire\Auth\Register;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ChatbotTest extends TestCase
{
    use RefreshDatabase;
    
    public function setUp(): void
    {
        parent::setUp();
        $user = User::factory()->create();
        Auth::login($user);
    }

    /** @test */
    public function it_renders_the_chatbot_component()
    {
        Livewire::test('chatbot')
            ->assertSee('Type your question...');
    }

    /** @test */
    public function it_can_send_a_message()
    {
        Livewire::test('chatbot')
            ->set('question', 'Hello')
            ->call('askQuestion')
            ->assertSee('Hello');
    }

    /** @test */
    public function it_displays_a_response_from_the_bot()
    {
        Livewire::test('chatbot')
            ->set('question', 'What is the capital of France?')
            ->call('askQuestion')
            ->assertSee('The capital of France is Paris.');
    }
}
