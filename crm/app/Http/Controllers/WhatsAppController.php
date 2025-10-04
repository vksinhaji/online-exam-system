<?php

namespace App\Http\Controllers;

use App\Models\ServiceRequest;
use App\Models\Enquiry;
use App\Services\WhatsAppService;
use Illuminate\Http\Request;

class WhatsAppController extends Controller
{
    public function sendForServiceRequest(Request $request, ServiceRequest $service_request)
    {
        $data = $request->validate([
            'message' => ['required','string'],
        ]);

        $phone = optional($service_request->customer)->phone;
        if (!$phone) {
            return back()->with('status', 'Customer phone not set');
        }

        $resp = app(WhatsAppService::class)->send($phone, $data['message']);

        if (($resp['ok'] ?? false) === true) {
            return back()->with('status', 'WhatsApp message sent');
        }

        return back()->with('status', 'Failed to send WhatsApp message');
    }

    public function sendForEnquiry(Request $request, Enquiry $enquiry)
    {
        $data = $request->validate([
            'message' => ['required','string'],
        ]);

        $phone = $enquiry->mobile_number;
        if (!$phone) {
            return back()->with('status', 'Mobile number not set');
        }

        $resp = app(WhatsAppService::class)->send($phone, $data['message']);

        if (($resp['ok'] ?? false) === true) {
            return back()->with('status', 'WhatsApp message sent');
        }

        return back()->with('status', 'Failed to send WhatsApp message');
    }
}
