@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto p-6 space-y-4">
  <div class="flex justify-between items-center">
    <h1 class="text-2xl font-semibold">{{ $document->name }}</h1>
    <div class="space-x-2">
      <a href="{{ route('document-requirements.edit', $document) }}" class="px-3 py-1 bg-yellow-600 text-white rounded">Edit</a>
      <a href="{{ route('document-requirements.index') }}" class="px-3 py-1 bg-gray-600 text-white rounded">Back</a>
    </div>
  </div>
  <div class="bg-white dark:bg-gray-800 shadow rounded p-4">
    <div><strong>Service:</strong> {{ $document->service->name }}</div>
    <div><strong>Mandatory:</strong> {{ $document->is_mandatory ? 'Yes' : 'No' }}</div>
  </div>
</div>
@endsection
