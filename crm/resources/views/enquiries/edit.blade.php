@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto p-6">
  <h1 class="text-2xl font-semibold mb-4">Edit Enquiry #{{ $enquiry->id }}</h1>
  <form method="POST" action="{{ route('enquiries.update', $enquiry) }}" class="space-y-4">
    @csrf
    @method('PUT')

    <div>
      <x-input-label for="customer_name" value="Customer Name" />
      <x-text-input id="customer_name" name="customer_name" type="text" class="w-full" value="{{ old('customer_name', $enquiry->customer_name) }}" />
      <x-input-error :messages="$errors->get('customer_name')" class="mt-2" />
    </div>

    <div>
      <x-input-label for="mobile_number" value="Mobile Number" />
      <x-text-input id="mobile_number" name="mobile_number" type="text" class="w-full" value="{{ old('mobile_number', $enquiry->mobile_number) }}" />
      <x-input-error :messages="$errors->get('mobile_number')" class="mt-2" />
    </div>

    <div>
      <x-input-label for="service_id" value="Service" />
      <select id="service_id" name="service_id" class="w-full border rounded p-2">
        @foreach($services as $id => $name)
          <option value="{{ $id }}" @selected(old('service_id', $enquiry->service_id)==$id)>{{ $name }}</option>
        @endforeach
      </select>
      <x-input-error :messages="$errors->get('service_id')" class="mt-2" />
    </div>

    <div>
      <x-input-label for="notes" value="Notes" />
      <textarea id="notes" name="notes" class="w-full border rounded p-2" rows="4">{{ old('notes', $enquiry->notes) }}</textarea>
      <x-input-error :messages="$errors->get('notes')" class="mt-2" />
    </div>

    <div class="flex gap-2">
      <x-primary-button>Update</x-primary-button>
      <a href="{{ route('enquiries.show', $enquiry) }}" class="px-3 py-2 bg-gray-600 text-white rounded">Cancel</a>
    </div>
  </form>
</div>
@endsection
