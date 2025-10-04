<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\DocumentRequirement;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $services = Service::latest()->paginate(10);
        return view('services.index', compact('services'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('services.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'expected_completion_days' => 'required|integer|min:1',
            'documents' => 'array',
            'documents.*.name' => 'nullable|string|max:255',
            'documents.*.is_mandatory' => 'nullable|boolean',
        ]);
        $serviceData = collect($validated)->only(['name','description','expected_completion_days'])->all();
        $service = Service::create($serviceData);

        $documents = collect($request->input('documents', []))
            ->filter(fn ($d) => isset($d['name']) && trim($d['name']) !== '')
            ->map(fn ($d) => [
                'service_id' => $service->id,
                'name' => $d['name'],
                'is_mandatory' => isset($d['is_mandatory']) ? (bool)$d['is_mandatory'] : false,
            ])->all();
        if (!empty($documents)) {
            DocumentRequirement::insert($documents);
        }
        return redirect()->route('services.show', $service)->with('status', 'Service created');
    }

    /**
     * Display the specified resource.
     */
    public function show(Service $service)
    {
        return view('services.show', compact('service'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Service $service)
    {
        return view('services.edit', compact('service'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Service $service)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'expected_completion_days' => 'required|integer|min:1',
            'documents' => 'array',
            'documents.*.name' => 'nullable|string|max:255',
            'documents.*.is_mandatory' => 'nullable|boolean',
        ]);
        $service->update(collect($validated)->only(['name','description','expected_completion_days'])->all());

        // sync documents: simple approach - delete and recreate
        $service->documentRequirements()->delete();
        $documents = collect($request->input('documents', []))
            ->filter(fn ($d) => isset($d['name']) && trim($d['name']) !== '')
            ->map(fn ($d) => [
                'service_id' => $service->id,
                'name' => $d['name'],
                'is_mandatory' => isset($d['is_mandatory']) ? (bool)$d['is_mandatory'] : false,
            ])->all();
        if (!empty($documents)) {
            DocumentRequirement::insert($documents);
        }
        return redirect()->route('services.show', $service)->with('status', 'Service updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Service $service)
    {
        $service->delete();
        return redirect()->route('services.index')->with('status', 'Service deleted');
    }
}
