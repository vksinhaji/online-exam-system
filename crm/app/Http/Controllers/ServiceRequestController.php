<?php

namespace App\Http\Controllers;

use App\Models\ServiceRequest;
use App\Models\Customer;
use App\Models\Service;
use App\Services\WhatsAppService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ServiceRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = ServiceRequest::with(['customer','service','assignee']);
        if (Auth::user()->hasRole('staff')) {
            $query->where('assigned_to', Auth::id());
        }
        $serviceRequests = $query->latest()->paginate(10);
        return view('service_requests.index', compact('serviceRequests'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $customers = Customer::orderBy('name')->pluck('name','id');
        $services = Service::orderBy('name')->pluck('name','id');
        return view('service_requests.create', compact('customers','services'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'service_id' => 'required|exists:services,id',
            'assigned_to' => 'nullable|exists:users,id',
            'status' => 'required|in:pending,in_progress,completed,cancelled',
            'due_date' => 'nullable|date',
            'remarks' => 'nullable|string',
        ]);
        $sr = ServiceRequest::create($validated);

        // Optionally notify customer via WhatsApp if phone exists
        try {
            $customerPhone = optional($sr->customer)->phone;
            if ($customerPhone) {
                app(WhatsAppService::class)->send($customerPhone, sprintf(
                    'New service request #%d created for %s. Status: %s.',
                    $sr->id,
                    optional($sr->service)->name ?? 'service',
                    str_replace('_', ' ', $sr->status)
                ));
            }
        } catch (\Throwable $e) {
            // Silent fail to keep UX smooth
        }

        return redirect()->route('service-requests.show', $sr)->with('status', 'Service request created');
    }

    /**
     * Display the specified resource.
     */
    public function show(ServiceRequest $serviceRequest)
    {
        $serviceRequest->load(['customer','service','assignee','progressUpdates.user']);
        return view('service_requests.show', compact('serviceRequest'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ServiceRequest $serviceRequest)
    {
        $customers = Customer::orderBy('name')->pluck('name','id');
        $services = Service::orderBy('name')->pluck('name','id');
        return view('service_requests.edit', compact('serviceRequest','customers','services'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ServiceRequest $serviceRequest)
    {
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'service_id' => 'required|exists:services,id',
            'assigned_to' => 'nullable|exists:users,id',
            'status' => 'required|in:pending,in_progress,completed,cancelled',
            'due_date' => 'nullable|date',
            'remarks' => 'nullable|string',
        ]);
        $serviceRequest->update($validated);
        return redirect()->route('service-requests.show', $serviceRequest)->with('status', 'Service request updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ServiceRequest $serviceRequest)
    {
        $serviceRequest->delete();
        return redirect()->route('service-requests.index')->with('status', 'Service request deleted');
    }
}
