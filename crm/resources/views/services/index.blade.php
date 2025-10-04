@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto p-6">
  <div class="flex justify-between mb-4">
    <h1 class="text-2xl font-semibold">Services</h1>
    <a href="{{ route('services.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded">New</a>
  </div>
  <div class="bg-white dark:bg-gray-800 shadow rounded">
    <table class="min-w-full">
      <thead>
        <tr>
          <th class="p-3 text-left">Name</th>
          <th class="p-3 text-left">Expected Days</th>
          <th class="p-3 text-left">Actions</th>
        </tr>
      </thead>
      <tbody>
        @forelse($services as $service)
          <tr class="border-t border-gray-200 dark:border-gray-700">
            <td class="p-3">{{ $service->name }}</td>
            <td class="p-3">{{ $service->expected_completion_days }}</td>
            <td class="p-3 space-x-2">
              <a href="{{ route('services.show', $service) }}" class="text-blue-600">View</a>
              <a href="{{ route('services.edit', $service) }}" class="text-yellow-600">Edit</a>
              <form action="{{ route('services.destroy', $service) }}" method="POST" class="inline">
                @csrf @method('DELETE')
                <button class="text-red-600" onclick="return confirm('Delete?')">Delete</button>
              </form>
            </td>
          </tr>
        @empty
          <tr><td class="p-3" colspan="3">No services</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
  <div class="mt-4">{{ $services->links() }}</div>
</div>
@endsection
