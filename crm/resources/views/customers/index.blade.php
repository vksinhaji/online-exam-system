@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto p-6">
  <div class="flex justify-between mb-4">
    <h1 class="text-2xl font-semibold">Customers</h1>
    <a href="{{ route('customers.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded">New</a>
  </div>
  <div class="bg-white dark:bg-gray-800 shadow rounded">
    <table class="min-w-full">
      <thead>
        <tr>
          <th class="p-3 text-left">Name</th>
          <th class="p-3 text-left">Phone</th>
          <th class="p-3 text-left">Email</th>
          <th class="p-3 text-left">Actions</th>
        </tr>
      </thead>
      <tbody>
        @forelse($customers as $customer)
          <tr class="border-t border-gray-200 dark:border-gray-700">
            <td class="p-3">{{ $customer->name }}</td>
            <td class="p-3">{{ $customer->phone }}</td>
            <td class="p-3">{{ $customer->email }}</td>
            <td class="p-3 space-x-2">
              <a href="{{ route('customers.show', $customer) }}" class="text-blue-600">View</a>
              <a href="{{ route('customers.edit', $customer) }}" class="text-yellow-600">Edit</a>
              <form action="{{ route('customers.destroy', $customer) }}" method="POST" class="inline">
                @csrf @method('DELETE')
                <button class="text-red-600" onclick="return confirm('Delete?')">Delete</button>
              </form>
            </td>
          </tr>
        @empty
          <tr><td class="p-3" colspan="4">No customers</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
  <div class="mt-4">{{ $customers->links() }}</div>
</div>
@endsection
