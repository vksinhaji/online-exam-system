<?php

namespace App\Http\Controllers;

use App\Models\Enquiry;
use App\Models\Service;
use App\Http\Requests\EnquiryStoreRequest;
use App\Http\Requests\EnquiryUpdateRequest;
use App\Services\WhatsAppService;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class EnquiryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $enquiries = Enquiry::with(['service'])
            ->latest()
            ->paginate(10);
        return view('enquiries.index', compact('enquiries'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $services = Service::orderBy('name')->pluck('name', 'id');
        return view('enquiries.create', compact('services'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(EnquiryStoreRequest $request)
    {
        $validated = $request->validated();
        $validated['created_by'] = Auth::id();
        $enquiry = Enquiry::create($validated);

        // Optionally send an acknowledgement via WhatsApp
        try {
            if (!empty($enquiry->mobile_number)) {
                $msg = sprintf(
                    'Hi %s, thanks for your enquiry (ID #%d) for %s. We will get back to you shortly.',
                    $enquiry->customer_name,
                    $enquiry->id,
                    optional($enquiry->service)->name ?? 'our services'
                );
                app(WhatsAppService::class)->send($enquiry->mobile_number, $msg);
            }
        } catch (\Throwable $e) {
            // Silent fail
        }
        return redirect()->route('enquiries.show', $enquiry)->with('status', 'Enquiry created');
    }

    /**
     * Display the specified resource.
     */
    public function show(Enquiry $enquiry)
    {
        $enquiry->load(['service.documentRequirements']);
        return view('enquiries.show', compact('enquiry'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Enquiry $enquiry)
    {
        $services = Service::orderBy('name')->pluck('name', 'id');
        return view('enquiries.edit', compact('enquiry','services'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EnquiryUpdateRequest $request, Enquiry $enquiry)
    {
        $validated = $request->validated();
        $enquiry->update($validated);
        return redirect()->route('enquiries.show', $enquiry)->with('status', 'Enquiry updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Enquiry $enquiry)
    {
        $enquiry->delete();
        return redirect()->route('enquiries.index')->with('status', 'Enquiry deleted');
    }

    /**
     * Show printer-friendly page for an enquiry.
     */
    public function print(Enquiry $enquiry)
    {
        $enquiry->load(['service.documentRequirements']);
        return view('enquiries.print', compact('enquiry'));
    }

    /**
     * Download PDF for an enquiry.
     */
    public function pdf(Enquiry $enquiry)
    {
        $enquiry->load(['service.documentRequirements']);
        try {
            $pdf = Pdf::loadView('enquiries.pdf', compact('enquiry'));
            return $pdf->download('enquiry-' . $enquiry->id . '.pdf');
        } catch (\Throwable $e) {
            // Fallback when PDF library is not installed in the runtime environment
            return redirect()
                ->route('enquiries.print', $enquiry)
                ->with('status', 'PDF generator unavailable. Please install barryvdh/laravel-dompdf.');
        }
    }
}
