<?php

namespace App\Http\Controllers;

use App\Models\DocumentRequirement;
use App\Models\Service;
use Illuminate\Http\Request;

class DocumentRequirementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $documents = DocumentRequirement::with('service')->latest()->paginate(10);
        return view('documents.index', compact('documents'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $services = Service::orderBy('name')->pluck('name','id');
        return view('documents.create', compact('services'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'service_id' => 'required|exists:services,id',
            'name' => 'required|string|max:255',
            'is_mandatory' => 'nullable|boolean',
        ]);
        $validated['is_mandatory'] = (bool) ($validated['is_mandatory'] ?? false);
        $doc = DocumentRequirement::create($validated);
        return redirect()->route('document-requirements.show', $doc)->with('status', 'Document requirement created');
    }

    /**
     * Display the specified resource.
     */
    public function show(DocumentRequirement $documentRequirement)
    {
        $documentRequirement->load('service');
        return view('documents.show', ['document' => $documentRequirement]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DocumentRequirement $documentRequirement)
    {
        $services = Service::orderBy('name')->pluck('name','id');
        return view('documents.edit', ['document' => $documentRequirement, 'services' => $services]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DocumentRequirement $documentRequirement)
    {
        $validated = $request->validate([
            'service_id' => 'required|exists:services,id',
            'name' => 'required|string|max:255',
            'is_mandatory' => 'nullable|boolean',
        ]);
        $validated['is_mandatory'] = (bool) ($validated['is_mandatory'] ?? false);
        $documentRequirement->update($validated);
        return redirect()->route('document-requirements.show', $documentRequirement)->with('status', 'Document requirement updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DocumentRequirement $documentRequirement)
    {
        $documentRequirement->delete();
        return redirect()->route('document-requirements.index')->with('status', 'Document requirement deleted');
    }
}
