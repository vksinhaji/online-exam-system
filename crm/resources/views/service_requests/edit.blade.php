@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto p-6">
  <h1 class="text-2xl font-semibold mb-4">Edit Service Request</h1>
  <form method="POST" action="{{ route('service-requests.update', $serviceRequest) }}" class="space-y-4" x-data='{"services": @json($services), days: {{ $serviceRequest->service->expected_completion_days }} }'>
    @csrf @method('PUT')
    <x-input-label for="customer_id" value="Customer" />
    <select id="customer_id" name="customer_id" class="w-full border rounded p-2">
      @foreach($customers as $id => $name)
        <option value="{{ $id }}" @selected($serviceRequest->customer_id==$id)>{{ $name }}</option>
      @endforeach
    </select>

    <x-input-label for="service_id" value="Service" />
    <select id="service_id" name="service_id" class="w-full border rounded p-2" @change="days = services.find(s => s.id == $event.target.value)?.expected_completion_days || days">
      @foreach($services as $service)
        <option value="{{ $service->id }}" @selected($serviceRequest->service_id==$service->id)>{{ $service->name }}</option>
      @endforeach
    </select>

    <x-input-label for="due_date" value="Due Date" />
    <x-text-input id="due_date" name="due_date" type="date" value="{{ old('due_date', optional($serviceRequest->due_date)->format('Y-m-d')) }}" class="w-full" />
    <div class="text-sm text-gray-500">Estimated completion: <span x-text="days ? `${days} day(s)` : '-' "></span></div>

    <x-input-label for="status" value="Status" />
    <select id="status" name="status" class="w-full border rounded p-2">
      @foreach(['pending','in_progress','completed','cancelled'] as $st)
        <option value="{{ $st }}" @selected($serviceRequest->status===$st)>{{ ucfirst(str_replace('_',' ', $st)) }}</option>
      @endforeach
    </select>

    <x-input-label for="remarks" value="Remarks" />
    <textarea id="remarks" name="remarks" class="w-full border rounded p-2">{{ old('remarks', $serviceRequest->remarks) }}</textarea>

    <x-primary-button>Update</x-primary-button>
  </form>
</div>
@endsection
