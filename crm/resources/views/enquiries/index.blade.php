@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto p-6 space-y-4">
  <div class="flex justify-between items-center">
    <h1 class="text-2xl font-semibold">Enquiries</h1>
    <a href="{{ route('enquiries.create') }}" class="px-3 py-1 bg-blue-600 text-white rounded">New</a>
  </div>

  <div class="bg-white dark:bg-gray-800 shadow rounded overflow-x-auto">
    <table class="min-w-full text-left">
      <thead>
        <tr class="border-b border-gray-200 dark:border-gray-700 text-sm text-gray-600">
          <th class="p-3">#</th>
          <th class="p-3">Customer</th>
          <th class="p-3">Mobile</th>
          <th class="p-3">Service</th>
          <th class="p-3">Created</th>
          <th class="p-3">Actions</th>
        </tr>
      </thead>
      <tbody>
        @forelse($enquiries as $enquiry)
          <tr class="border-b border-gray-100 dark:border-gray-700">
            <td class="p-3">{{ $enquiry->id }}</td>
            <td class="p-3">{{ $enquiry->customer_name }}</td>
            <td class="p-3">{{ $enquiry->mobile_number }}</td>
            <td class="p-3">{{ $enquiry->service->name ?? '-' }}</td>
            <td class="p-3">{{ optional($enquiry->created_at)->format('Y-m-d H:i') }}</td>
            <td class="p-3 space-x-2 whitespace-nowrap">
              <a href="{{ route('enquiries.show', $enquiry) }}" class="text-blue-600">View</a>
              <a href="{{ route('enquiries.edit', $enquiry) }}" class="text-yellow-600">Edit</a>
              <a href="{{ route('enquiries.print', $enquiry) }}" class="text-green-700" target="_blank">Print</a>
              <a href="{{ route('enquiries.pdf', $enquiry) }}" class="text-indigo-700">PDF</a>
              <form method="POST" action="{{ route('enquiries.whatsapp', $enquiry) }}" class="inline">
                @csrf
                <button class="text-emerald-700">WhatsApp</button>
              </form>
              <form method="POST" action="{{ route('enquiries.destroy', $enquiry) }}" class="inline">
                @csrf
                @method('DELETE')
                <button class="text-red-600" onclick="return confirm('Delete this enquiry?')">Delete</button>
              </form>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="6" class="p-6 text-center text-gray-500">No enquiries yet.</td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  <div>
    {{ $enquiries->links() }}
  </div>
</div>
@endsection
