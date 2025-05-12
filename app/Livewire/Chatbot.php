<?php

namespace App\Livewire;

use Prism\Prism\Prism;
use Livewire\Component;
use App\Models\ChatInteraction;
use Illuminate\Support\Facades\Auth;
use Prism\Prism\Enums\Provider;
use Prism\Prism\ValueObjects\Messages\UserMessage;
use Prism\Prism\ValueObjects\Messages\AssistantMessage;

class Chatbot extends Component
{
    public $messages = [];
    public $question;
    public $answer;

    public function mount()
    {
        $this->messages = ChatInteraction::all();
    }

    public function askQuestion()
    {
        $conversation = [];

        if (empty($this->question)) {
            return;
        }

        foreach ($this->messages as $message) {
            $conversation[] = new UserMessage($message->question);
            $conversation[] = new AssistantMessage($message->answer);
        }

        $conversation[] = new UserMessage($this->question);

        $response = Prism::text()
            ->using(Provider::OpenAI, 'gpt-4')
            ->withSystemPrompt('You are a helpful FAQ assistant.')
            ->withMessages($conversation)
            ->asText();

        $this->answer = $response->text;

        $interaction = ChatInteraction::create([
            'question' => $this->question,
            'answer' => $this->answer,
            'user_id' => Auth::user()->id,
        ]);

        $this->messages[] = $interaction;
        $this->question = '';
    }

    public function render()
    {
        return view('livewire.chatbot');
    }
}
