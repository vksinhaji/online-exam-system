@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto p-6 space-y-4">
  <div class="flex justify-between items-center">
    <div>
      <h1 class="text-2xl font-semibold">Request #{{ $serviceRequest->id }}</h1>
      <div class="text-sm text-gray-500">{{ $serviceRequest->customer->name }} • {{ $serviceRequest->service->name }}</div>
    </div>
    <div class="space-x-2">
      <a href="{{ route('service-requests.edit', $serviceRequest) }}" class="px-3 py-1 bg-yellow-600 text-white rounded">Edit</a>
      @if(config('whatsapp.enabled'))
      <button onclick="document.getElementById('wa-manual-modal').showModal()" class="px-3 py-1 bg-green-700 text-white rounded">Send WhatsApp</button>
      @endif
      <a href="{{ route('service-requests.index') }}" class="px-3 py-1 bg-gray-600 text-white rounded">Back</a>
    </div>
  </div>

  <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <div class="bg-white dark:bg-gray-800 shadow rounded p-4 space-y-2">
      <div><strong>Status:</strong> {{ ucfirst(str_replace('_',' ', $serviceRequest->status)) }}</div>
      <div><strong>Assigned:</strong> {{ optional($serviceRequest->assignee)->name ?? 'Unassigned' }}</div>
      <div><strong>Due Date:</strong> {{ optional($serviceRequest->due_date)->format('Y-m-d') }}</div>
      <div><strong>Remarks:</strong>
        <div class="whitespace-pre-wrap">{{ $serviceRequest->remarks }}</div>
      </div>
    </div>

    <div class="bg-white dark:bg-gray-800 shadow rounded p-4">
      <h2 class="font-semibold mb-2">Progress Updates</h2>
      <div class="space-y-3">
        @forelse($serviceRequest->progressUpdates as $update)
          <div class="border-b border-gray-200 dark:border-gray-700 pb-2">
            <div class="text-sm text-gray-500">{{ $update->created_at->format('Y-m-d H:i') }} — {{ $update->user->name }}</div>
            <div class="whitespace-pre-wrap">{{ $update->remark }}</div>
          </div>
        @empty
          <div class="text-gray-500">No updates yet.</div>
        @endforelse
      </div>

      <form method="POST" action="{{ route('service-requests.progress.store', $serviceRequest) }}" class="mt-4 space-y-2">
        @csrf
        <input type="hidden" name="service_request_id" value="{{ $serviceRequest->id }}">
        <x-input-label for="remark" value="Add Remark" />
        <textarea id="remark" name="remark" class="w-full border rounded p-2" placeholder="What changed?"></textarea>
        <x-primary-button>Add</x-primary-button>
      </form>
    </div>
  </div>

  @if(config('whatsapp.enabled'))
  <dialog id="wa-manual-modal" class="rounded shadow-lg p-0">
    <form method="POST" action="{{ route('service-requests.whatsapp', $serviceRequest) }}" class="p-4 space-y-3">
      @csrf
      <div class="text-lg font-semibold">Send WhatsApp Message</div>
      <div class="text-sm text-gray-500">To: {{ optional($serviceRequest->customer)->phone ?? 'N/A' }}</div>
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
