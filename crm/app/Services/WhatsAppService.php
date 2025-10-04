<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsAppService
{
    public function isEnabled(): bool
    {
        return (bool) config('whatsapp.enabled', false);
    }

    public function send(string $to, string $message): array
    {
        if (!$this->isEnabled()) {
            return ['ok' => false, 'error' => 'whatsapp_disabled'];
        }

        $provider = config('whatsapp.provider', 'twilio');

        switch ($provider) {
            case 'twilio':
                return $this->sendViaTwilio($to, $message);
            default:
                return ['ok' => false, 'error' => 'unknown_provider'];
        }
    }

    private function sendViaTwilio(string $toRaw, string $body): array
    {
        $sid = (string) config('whatsapp.twilio.sid');
        $token = (string) config('whatsapp.twilio.token');
        $from = (string) config('whatsapp.twilio.from', 'whatsapp:+14155238886');

        if (empty($sid) || empty($token) || empty($from)) {
            return ['ok' => false, 'error' => 'twilio_config_missing'];
        }

        $to = $this->formatToForTwilio($toRaw);

        $url = "https://api.twilio.com/2010-04-01/Accounts/{$sid}/Messages.json";

        try {
            $response = Http::asForm()
                ->withBasicAuth($sid, $token)
                ->post($url, [
                    'From' => $from,
                    'To'   => $to,
                    'Body' => $body,
                ]);

            if ($response->successful()) {
                return ['ok' => true, 'sid' => $response->json('sid')];
            }

            Log::warning('Twilio WhatsApp send failed', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);
            return [
                'ok' => false,
                'status' => $response->status(),
                'body' => $response->body(),
            ];
        } catch (\Throwable $e) {
            Log::error('Twilio WhatsApp send exception', [
                'exception' => $e,
            ]);
            return ['ok' => false, 'error' => 'exception', 'message' => $e->getMessage()];
        }
    }

    private function formatToForTwilio(string $toRaw): string
    {
        $to = trim($toRaw);
        if (str_starts_with($to, 'whatsapp:')) {
            return $to;
        }
        if (!str_starts_with($to, '+')) {
            $to = '+' . preg_replace('/[^0-9]/', '', $to);
        }
        return 'whatsapp:' . $to;
    }
}
