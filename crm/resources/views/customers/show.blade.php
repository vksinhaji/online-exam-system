@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto p-6 space-y-4">
  <div class="flex justify-between items-center">
    <h1 class="text-2xl font-semibold">{{ $customer->name }}</h1>
    <div class="space-x-2">
      <a href="{{ route('customers.edit', $customer) }}" class="px-3 py-1 bg-yellow-600 text-white rounded">Edit</a>
      <a href="{{ route('customers.index') }}" class="px-3 py-1 bg-gray-600 text-white rounded">Back</a>
    </div>
  </div>
  <div class="bg-white dark:bg-gray-800 shadow rounded p-4">
    <div><strong>Phone:</strong> {{ $customer->phone }}</div>
    <div><strong>Email:</strong> {{ $customer->email }}</div>
    <div><strong>Address:</strong> {{ $customer->address }}</div>
    <div class="grid grid-cols-2 gap-4 mt-2">
      <div><strong>Aadhar:</strong> {{ $customer->aadhar_no }}</div>
      <div><strong>PAN:</strong> {{ $customer->pan_no }}</div>
    </div>
  </div>
</div>
@endsection
