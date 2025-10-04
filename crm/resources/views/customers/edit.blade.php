@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto p-6">
  <h1 class="text-2xl font-semibold mb-4">Edit Customer</h1>
  <form method="POST" action="{{ route('customers.update', $customer) }}" class="space-y-4">
    @csrf @method('PUT')
    <x-input-label for="name" value="Name" />
    <x-text-input id="name" name="name" value="{{ old('name', $customer->name) }}" class="w-full" required />

    <x-input-label for="phone" value="Phone" />
    <x-text-input id="phone" name="phone" value="{{ old('phone', $customer->phone) }}" class="w-full" />

    <x-input-label for="email" value="Email" />
    <x-text-input id="email" name="email" type="email" value="{{ old('email', $customer->email) }}" class="w-full" />

    <x-input-label for="address" value="Address" />
    <textarea id="address" name="address" class="w-full border rounded p-2">{{ old('address', $customer->address) }}</textarea>

    <div class="grid grid-cols-2 gap-4">
      <div>
        <x-input-label for="aadhar_no" value="Aadhar No" />
        <x-text-input id="aadhar_no" name="aadhar_no" value="{{ old('aadhar_no', $customer->aadhar_no) }}" class="w-full" />
      </div>
      <div>
        <x-input-label for="pan_no" value="PAN No" />
        <x-text-input id="pan_no" name="pan_no" value="{{ old('pan_no', $customer->pan_no) }}" class="w-full" />
      </div>
    </div>

    <x-primary-button>Update</x-primary-button>
  </form>
</div>
@endsection
