<?php

namespace Aaran\Neot\Http\Controllers;

use Aaran\Neot\Models\WhatsappMessage;
use Illuminate\Http\Request;

class WhatsAppWebhookController
{
    public function receive(Request $request)
    {
        $data = $request->all();

        if (isset($data['entry'][0]['changes'][0]['value']['messages'])) {
            $messages = $data['entry'][0]['changes'][0]['value']['messages'];

            foreach ($messages as $msg) {
                WhatsappMessage::create([
                    'sender' => $msg['from'],
                    'message' => $msg['text']['body'] ?? '',
                    'direction' => 'inbound',
                ]);
            }
        }

        return response('OK', 200);
    }
}
