@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto p-6">
  <h1 class="text-2xl font-semibold mb-4">Edit Service</h1>
  <form method="POST" action="{{ route('services.update', $service) }}" class="space-y-4">
    @csrf @method('PUT')
    <x-input-label for="name" value="Name" />
    <x-text-input id="name" name="name" value="{{ old('name', $service->name) }}" class="w-full" required />

    <x-input-label for="description" value="Description" />
    <textarea id="description" name="description" class="w-full border rounded p-2">{{ old('description', $service->description) }}</textarea>

    <x-input-label for="expected_completion_days" value="Expected Completion Days" />
    <x-text-input id="expected_completion_days" name="expected_completion_days" type="number" min="1" value="{{ old('expected_completion_days', $service->expected_completion_days) }}" class="w-full" />

    <x-primary-button>Update</x-primary-button>
  </form>
</div>
@endsection
