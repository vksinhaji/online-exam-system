<?php

namespace App\Http\Controllers;

use App\Models\ProgressUpdate;
use App\Models\ServiceRequest;
use App\Services\WhatsAppService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProgressUpdateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, WhatsAppService $whatsApp)
    {
        $validated = $request->validate([
            'service_request_id' => 'required|exists:service_requests,id',
            'remark' => 'required|string',
            'notify_whatsapp' => 'nullable|boolean',
        ]);
        $validated['user_id'] = Auth::id();
        $update = ProgressUpdate::create($validated);

        // Optionally update parent remarks and status timestamps
        $serviceRequest = ServiceRequest::findOrFail($validated['service_request_id']);
        $serviceRequest->remarks = $serviceRequest->remarks
            ? ($serviceRequest->remarks."\n".$update->remark)
            : $update->remark;
        if ($serviceRequest->status === 'pending') {
            $serviceRequest->status = 'in_progress';
        }
        $serviceRequest->save();

        if ($request->boolean('notify_whatsapp')) {
            $serviceRequest->load(['customer','service']);
            $phone = $serviceRequest->customer->phone;
            $message = "Update on Service Request #{$serviceRequest->id}\n".
                "Service: {$serviceRequest->service->name}\n".
                "Status: ".ucfirst(str_replace('_',' ', $serviceRequest->status))."\n".
                "Remark: {$update->remark}";
            $whatsApp->sendText($phone, $message);
        }

        return back()->with('status', 'Progress remark added');
    }

    /**
     * Display the specified resource.
     */
    public function show(ProgressUpdate $progressUpdate)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProgressUpdate $progressUpdate)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ProgressUpdate $progressUpdate)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProgressUpdate $progressUpdate)
    {
        //
    }
}
