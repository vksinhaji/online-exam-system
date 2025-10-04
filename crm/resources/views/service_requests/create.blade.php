@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto p-6">
  <h1 class="text-2xl font-semibold mb-4">New Service Request</h1>
  <form method="POST" action="{{ route('service-requests.store') }}" class="space-y-4">
    @csrf
    <x-input-label for="customer_id" value="Customer" />
    <select id="customer_id" name="customer_id" class="w-full border rounded p-2">
      @foreach($customers as $id => $name)
        <option value="{{ $id }}">{{ $name }}</option>
      @endforeach
    </select>

    <x-input-label for="service_id" value="Service" />
    <select id="service_id" name="service_id" class="w-full border rounded p-2">
      @foreach($services as $id => $name)
        <option value="{{ $id }}">{{ $name }}</option>
      @endforeach
    </select>

    <x-input-label for="due_date" value="Due Date" />
    <x-text-input id="due_date" name="due_date" type="date" value="{{ old('due_date') }}" class="w-full" />

    <x-input-label for="status" value="Status" />
    <select id="status" name="status" class="w-full border rounded p-2">
      @foreach(['pending','in_progress','completed','cancelled'] as $st)
        <option value="{{ $st }}" @selected(old('status')===$st)>{{ ucfirst(str_replace('_',' ', $st)) }}</option>
      @endforeach
    </select>

    <x-input-label for="remarks" value="Remarks" />
    <textarea id="remarks" name="remarks" class="w-full border rounded p-2">{{ old('remarks') }}</textarea>

    <x-primary-button>Save</x-primary-button>
  </form>
</div>
@endsection
