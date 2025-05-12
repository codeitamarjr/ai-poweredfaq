<?php

namespace Tests\Feature\Livewire;

use Tests\TestCase;
use App\Models\User;
use Livewire\Livewire;
use Prism\Prism\Prism;
use App\Livewire\Chatbot;
use App\Models\ChatInteraction;
use Illuminate\Support\Facades\Auth;
use Prism\Prism\Testing\TextResponseFake;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Prism\Prism\ValueObjects\Messages\UserMessage;
use Prism\Prism\ValueObjects\Messages\AssistantMessage;

class ChatbotTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        Auth::login(User::factory()->create());
    }

    public function test_it_renders_the_chatbot_component()
    {
        Livewire::test('chatbot')
            ->assertSee('Type your question...');
    }

    public function test_it_can_send_a_message()
    {
        $fakeResponse = TextResponseFake::make()
            ->withText('Hello')
            ->withMessages(collect([
                new UserMessage('Hello'),
                new AssistantMessage('Hello'),
            ]));

        Prism::fake([$fakeResponse]);

        Livewire::test(Chatbot::class)
            ->set('question', 'Hello')
            ->call('askQuestion')
            ->assertSet('answer', 'Hello')
            ->assertSee('Hello');

        $this->assertDatabaseHas('chat_interactions', [
            'question' => 'Hello',
            'answer'   => 'Hello',
            'user_id'  => Auth::id(),
        ]);
    }

    public function test_it_displays_a_response_from_the_bot_with_history(): void
    {
        ChatInteraction::create([
            'question' => 'Foo?',
            'answer'   => 'Bar.',
            'user_id'  => Auth::id(),
        ]);

        $fakeResponse = TextResponseFake::make()
            ->withText('The capital of France is Paris.')
            ->withMessages(collect([
                new UserMessage('Foo?'),
                new AssistantMessage('Bar.'),
                new UserMessage('What is the capital of France?'),
                new AssistantMessage('The capital of France is Paris.'),
            ]));

        Prism::fake([$fakeResponse]);

        Livewire::test(Chatbot::class)
            ->set('question', 'What is the capital of France?')
            ->call('askQuestion')
            ->assertSee('Foo?')                                // history
            ->assertSee('Bar.')                              // history
            ->assertSee('What is the capital of France?')    // your new question
            ->assertSee('The capital of France is Paris.');  // the fake answer

        $this->assertDatabaseHas('chat_interactions', [
            'question' => 'What is the capital of France?',
            'answer'   => 'The capital of France is Paris.',
            'user_id'  => Auth::id(),
        ]);
    }
}
