@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto p-6">
  <h1 class="text-2xl font-semibold mb-4">Edit Service</h1>
  <form method="POST" action="{{ route('services.update', $service) }}" class="space-y-4" x-data="{ rows: {{ max(3, $service->documentRequirements->count()) }}, docs: {{ $service->documentRequirements->map(fn($d)=>['name'=>$d->name,'is_mandatory'=>$d->is_mandatory])->values()->toJson() }} }">
    @csrf @method('PUT')
    <x-input-label for="name" value="Name" />
    <x-text-input id="name" name="name" value="{{ old('name', $service->name) }}" class="w-full" required />

    <x-input-label for="description" value="Description" />
    <textarea id="description" name="description" class="w-full border rounded p-2">{{ old('description', $service->description) }}</textarea>

    <x-input-label for="expected_completion_days" value="Expected Completion Days" />
    <x-text-input id="expected_completion_days" name="expected_completion_days" type="number" min="1" value="{{ old('expected_completion_days', $service->expected_completion_days) }}" class="w-full" />

    <div class="space-y-2">
      <div class="flex items-center justify-between">
        <div class="font-semibold">Document Requirements</div>
        <button type="button" class="px-3 py-1 bg-gray-600 text-white rounded" @click="rows++">Add another</button>
      </div>
      <template x-for="i in rows" :key="i">
        <div class="flex items-center space-x-3">
          <input type="text" :name="`documents[${i}][name]`" class="w-full border rounded p-2" :value="docs[i-1]?.name || ''" placeholder="Document name">
          <label class="inline-flex items-center space-x-2">
            <input type="checkbox" :name="`documents[${i}][is_mandatory]`" value="1" :checked="docs[i-1]?.is_mandatory ?? true">
            <span>Mandatory</span>
          </label>
        </div>
      </template>
    </div>

    <x-primary-button>Update</x-primary-button>
  </form>
</div>
@endsection
