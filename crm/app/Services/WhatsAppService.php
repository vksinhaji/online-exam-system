<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class WhatsAppService
{
    private string $phoneId;
    private string $accessToken;
    private ?string $businessNumber;

    public function __construct()
    {
        $this->phoneId = config('services.whatsapp.phone_id');
        $this->accessToken = config('services.whatsapp.token');
        $this->businessNumber = config('services.whatsapp.from');
    }

    public function isConfigured(): bool
    {
        return !empty($this->phoneId) && !empty($this->accessToken);
    }

    public function sendText(string $toE164, string $message): array
    {
        if (!$this->isConfigured()) {
            return ['ok' => false, 'error' => 'WhatsApp not configured'];
        }

        $endpoint = "https://graph.facebook.com/v21.0/{$this->phoneId}/messages";

        $payload = [
            'messaging_product' => 'whatsapp',
            'to' => $toE164,
            'type' => 'text',
            'text' => [ 'body' => $message ],
        ];

        $response = Http::withToken($this->accessToken)
            ->acceptJson()
            ->post($endpoint, $payload);

        if ($response->successful()) {
            return ['ok' => true, 'data' => $response->json()];
        }

        return [
            'ok' => false,
            'status' => $response->status(),
            'error' => $response->json('error.message') ?? $response->body(),
        ];
    }
}
