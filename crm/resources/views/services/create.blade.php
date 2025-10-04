@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto p-6">
  <h1 class="text-2xl font-semibold mb-4">New Service</h1>
  <form method="POST" action="{{ route('services.store') }}" class="space-y-4">
    @csrf
    <x-input-label for="name" value="Name" />
    <x-text-input id="name" name="name" value="{{ old('name') }}" class="w-full" required />

    <x-input-label for="description" value="Description" />
    <textarea id="description" name="description" class="w-full border rounded p-2">{{ old('description') }}</textarea>

    <x-input-label for="expected_completion_days" value="Expected Completion Days" />
    <x-text-input id="expected_completion_days" name="expected_completion_days" type="number" min="1" value="{{ old('expected_completion_days', 3) }}" class="w-full" />

    <div class="space-y-2" x-data="{ rows: 3 }">
      <div class="font-semibold">Document Requirements</div>
      <template x-for="i in rows" :key="i">
        <div class="flex items-center space-x-3">
          <input type="text" :name="`documents[${i}][name]`" class="w-full border rounded p-2" placeholder="Document name">
          <label class="inline-flex items-center space-x-2">
            <input type="checkbox" :name="`documents[${i}][is_mandatory]`" value="1" checked>
            <span>Mandatory</span>
          </label>
        </div>
      </template>
      <button type="button" class="px-3 py-1 bg-gray-600 text-white rounded" @click="rows++">Add another</button>
    </div>

    <x-primary-button>Save</x-primary-button>
  </form>
</div>
@endsection
