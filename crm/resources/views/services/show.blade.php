@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto p-6 space-y-4">
  <div class="flex justify-between items-center">
    <h1 class="text-2xl font-semibold">{{ $service->name }}</h1>
    <div class="space-x-2">
      <a href="{{ route('services.edit', $service) }}" class="px-3 py-1 bg-yellow-600 text-white rounded">Edit</a>
      <a href="{{ route('services.index') }}" class="px-3 py-1 bg-gray-600 text-white rounded">Back</a>
    </div>
  </div>
  <div class="bg-white dark:bg-gray-800 shadow rounded p-4">
    <div><strong>Expected Days:</strong> {{ $service->expected_completion_days }}</div>
    <div class="mt-2"><strong>Description:</strong>
      <div class="whitespace-pre-wrap">{{ $service->description }}</div>
    </div>
  </div>
</div>
@endsection
