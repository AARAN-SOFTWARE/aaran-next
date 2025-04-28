<?php

namespace Aaran\Neot\Livewire\Class;

use Aaran\Neot\Services\IntentResolver;
use Livewire\Component;

class Chatbot extends Component
{
    public $message;
    public $chatHistory = [];

    public function sendMessage()
    {
        $this->validate([
            'message' => 'required|string',
        ]);

        $this->chatHistory[] = ['sender' => 'user', 'message' => $this->message];

        $intentData = IntentResolver::resolve($this->message);

        if ($intentData['handler']) {
            $response = $intentData['handler']->handle(auth()->user());
            $this->chatHistory[] = ['sender' => 'bot', 'message' => $response];
        } else {
            $suggestions = $intentData['suggestions'];

            $suggestionText = '';
            if (!empty($suggestions)) {
                $suggestionText = '<br>Did you mean:<ul>';
                foreach ($suggestions as $suggestion) {
                    $suggestionText .= "<li>{$suggestion}</li>";
                }
                $suggestionText .= '</ul>';
            }

            $this->chatHistory[] = [
                'sender' => 'bot',
                'message' => "Sorry, I did not understand your request. {$suggestionText}"
            ];
        }

        $this->message = '';
    }


    public function render()
    {
        return view('neot::chatbot');
    }
}
