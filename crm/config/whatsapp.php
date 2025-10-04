<?php

return [
    'enabled' => env('WHATSAPP_ENABLED', false),

    'provider' => env('WHATSAPP_PROVIDER', 'twilio'),

    'twilio' => [
        'sid' => env('TWILIO_ACCOUNT_SID'),
        'token' => env('TWILIO_AUTH_TOKEN'),
        // Must include the whatsapp: prefix, e.g., whatsapp:+14155238886
        'from' => env('TWILIO_WHATSAPP_FROM', 'whatsapp:+14155238886'),
    ],

    // If true, sending a progress update can auto-notify the customer via WhatsApp
    'auto_notify_progress' => env('WHATSAPP_AUTO_NOTIFY_PROGRESS', false),
];
