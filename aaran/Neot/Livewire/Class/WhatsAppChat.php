<?php

namespace Aaran\Neot\Livewire\Class;

use Aaran\Neot\Models\WhatsappMessage;
use Aaran\Neot\Services\WhatsAppService;
use Livewire\Component;

class WhatsAppChat extends Component
{
    public $messages;
    public $text = '';
    public $receiver = ''; // Set default receiver if you know it

    protected $rules = [
        'text' => 'required|string|max:1000',
    ];

    public function mount()
    {
        $this->messages = WhatsappMessage::orderBy('created_at')->get();
    }

    public function send()
    {
        $this->validate();

        $whatsapp = new WhatsAppService();
        $whatsapp->sendMessage($this->receiver, $this->text);

        WhatsappMessage::create([
            'sender' => auth()->user()->name ?? 'admin',
            'receiver' => $this->receiver,
            'message' => $this->text,
            'direction' => 'outbound',
        ]);

        $this->text = '';
        $this->messages = WhatsappMessage::orderBy('created_at')->get();
    }

    public function render()
    {
        return view('neot::whatsapp-chat');
    }
}
