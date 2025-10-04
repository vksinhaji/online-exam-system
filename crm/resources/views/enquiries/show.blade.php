@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto p-6 space-y-4">
  <div class="flex justify-between items-center">
    <div>
      <h1 class="text-2xl font-semibold">Enquiry #{{ $enquiry->id }}</h1>
      <div class="text-sm text-gray-500">{{ $enquiry->customer_name }} • {{ $enquiry->mobile_number }}</div>
    </div>
    <div class="space-x-2">
      <a href="{{ route('enquiries.edit', $enquiry) }}" class="px-3 py-1 bg-yellow-600 text-white rounded">Edit</a>
      <a href="{{ route('enquiries.print', $enquiry) }}" target="_blank" class="px-3 py-1 bg-green-700 text-white rounded">Print</a>
      <a href="{{ route('enquiries.pdf', $enquiry) }}" class="px-3 py-1 bg-indigo-700 text-white rounded">PDF</a>
      @if(config('whatsapp.enabled'))
      <button onclick="document.getElementById('wa-manual-modal').showModal()" class="px-3 py-1 bg-green-700 text-white rounded">Send WhatsApp</button>
      @endif
      <a href="{{ route('enquiries.index') }}" class="px-3 py-1 bg-gray-600 text-white rounded">Back</a>
    </div>
  </div>

  <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <div class="bg-white dark:bg-gray-800 shadow rounded p-4 space-y-2">
      <div><strong>Service:</strong> {{ $enquiry->service->name ?? '-' }}</div>
      <div><strong>Created:</strong> {{ optional($enquiry->created_at)->format('Y-m-d H:i') }}</div>
      <div><strong>Expected Time (days):</strong> {{ $enquiry->service->expected_completion_days ?? '-' }}</div>
      <div><strong>Estimated Completion Date:</strong> {{ optional($enquiry->estimated_completion_date)->format('Y-m-d') ?? '-' }}</div>
      <div>
        <strong>Notes:</strong>
        <div class="whitespace-pre-wrap">{{ $enquiry->notes }}</div>
      </div>
    </div>

    <div class="bg-white dark:bg-gray-800 shadow rounded p-4">
      <h2 class="font-semibold mb-2">Required Documents</h2>
      <ul class="list-disc pl-6 space-y-1">
        @forelse(($enquiry->service->documentRequirements ?? []) as $doc)
          <li>
            {{ $doc->name }}
            @if($doc->is_mandatory)
              <span class="text-red-600 text-xs font-semibold">(Mandatory)</span>
            @endif
          </li>
        @empty
          <li class="text-gray-500">No documents configured for this service.</li>
        @endforelse
      </ul>
    </div>
  </div>

  @if(config('whatsapp.enabled'))
  <dialog id="wa-manual-modal" class="rounded shadow-lg p-0">
    <form method="POST" action="{{ route('enquiries.whatsapp', $enquiry) }}" class="p-4 space-y-3">
      @csrf
      <div class="text-lg font-semibold">Send WhatsApp Message</div>
      <div class="text-sm text-gray-500">To: {{ $enquiry->mobile_number ?? 'N/A' }}</div>
      <textarea name="message" class="w-96 max-w-full border rounded p-2" rows="5" placeholder="Type your message"></textarea>
      <div class="flex gap-2 justify-end">
        <button type="button" onclick="document.getElementById('wa-manual-modal').close()" class="px-3 py-1 bg-gray-600 text-white rounded">Cancel</button>
        <button class="px-3 py-1 bg-green-700 text-white rounded">Send</button>
      </div>
    </form>
  </dialog>
  @endif
</div>
@endsection
