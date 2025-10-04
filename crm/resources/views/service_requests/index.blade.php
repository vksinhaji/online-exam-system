@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto p-6">
  <div class="flex justify-between mb-4">
    <h1 class="text-2xl font-semibold">Service Requests</h1>
    <a href="{{ route('service-requests.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded">New</a>
  </div>
  <div class="bg-white dark:bg-gray-800 shadow rounded">
    <table class="min-w-full">
      <thead>
        <tr>
          <th class="p-3 text-left">Customer</th>
          <th class="p-3 text-left">Service</th>
          <th class="p-3 text-left">Status</th>
          <th class="p-3 text-left">Due Date</th>
          <th class="p-3 text-left">Assigned</th>
          <th class="p-3 text-left">Actions</th>
        </tr>
      </thead>
      <tbody>
        @forelse($serviceRequests as $sr)
          <tr class="border-t border-gray-200 dark:border-gray-700">
            <td class="p-3">{{ $sr->customer->name }}</td>
            <td class="p-3">{{ $sr->service->name }}</td>
            <td class="p-3">{{ ucfirst(str_replace('_',' ', $sr->status)) }}</td>
            <td class="p-3">{{ optional($sr->due_date)->format('Y-m-d') }}</td>
            <td class="p-3">{{ optional($sr->assignee)->name }}</td>
            <td class="p-3 space-x-2">
              <a href="{{ route('service-requests.show', $sr) }}" class="text-blue-600">View</a>
              <a href="{{ route('service-requests.edit', $sr) }}" class="text-yellow-600">Edit</a>
            </td>
          </tr>
        @empty
          <tr><td class="p-3" colspan="6">No service requests</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
  <div class="mt-4">{{ $serviceRequests->links() }}</div>
</div>
@endsection
