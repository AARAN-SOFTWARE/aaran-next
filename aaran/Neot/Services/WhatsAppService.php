<?php

namespace Aaran\Neot\Services;

use Illuminate\Support\Facades\Http;
class WhatsAppService
{
    protected mixed $token;
    protected mixed $phoneNumberId;

    public function __construct()
    {
        $this->token = env('WHATSAPP_API_TOKEN');
        $this->phoneNumberId = env('WHATSAPP_PHONE_NUMBER_ID');
    }

    public function sendMessage($to, $message)
    {
        return Http::withToken($this->token)
            ->post("https://graph.facebook.com/v18.0/{$this->phoneNumberId}/messages", [
                'messaging_product' => 'whatsapp',
                'to' => $to,
                'type' => 'text',
                'text' => ['body' => $message],
            ]);
    }
}
