@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto p-6">
  <h1 class="text-2xl font-semibold mb-4">Edit Document Requirement</h1>
  <form method="POST" action="{{ route('document-requirements.update', $document) }}" class="space-y-4">
    @csrf @method('PUT')
    <x-input-label for="service_id" value="Service" />
    <select id="service_id" name="service_id" class="w-full border rounded p-2">
      @foreach($services as $id => $name)
        <option value="{{ $id }}" @selected($document->service_id == $id)>{{ $name }}</option>
      @endforeach
    </select>

    <x-input-label for="name" value="Document Name" />
    <x-text-input id="name" name="name" value="{{ old('name', $document->name) }}" class="w-full" required />

    <label class="inline-flex items-center space-x-2">
      <input type="checkbox" name="is_mandatory" value="1" @checked($document->is_mandatory)>
      <span>Mandatory</span>
    </label>

    <x-primary-button>Update</x-primary-button>
  </form>
</div>
@endsection
