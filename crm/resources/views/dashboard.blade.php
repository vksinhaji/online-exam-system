<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("You're logged in!") }}
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                @role('admin')
                <a href="{{ route('customers.index') }}" class="block p-6 bg-white dark:bg-gray-800 rounded shadow">
                    <div class="font-semibold">Manage Customers</div>
                    <div class="text-sm text-gray-500">Create and edit customer records</div>
                </a>
                <a href="{{ route('services.index') }}" class="block p-6 bg-white dark:bg-gray-800 rounded shadow">
                    <div class="font-semibold">Manage Services</div>
                    <div class="text-sm text-gray-500">Define PAN, Aadhaar and schemes</div>
                </a>
                <a href="{{ route('document-requirements.index') }}" class="block p-6 bg-white dark:bg-gray-800 rounded shadow">
                    <div class="font-semibold">Document Requirements</div>
                    <div class="text-sm text-gray-500">Required docs per service</div>
                </a>
                @endrole
                @role('admin|staff')
                <a href="{{ route('service-requests.index') }}" class="block p-6 bg-white dark:bg-gray-800 rounded shadow">
                    <div class="font-semibold">Service Requests</div>
                    <div class="text-sm text-gray-500">Track progress and remarks</div>
                </a>
                @endrole
            </div>
        </div>
    </div>
</x-app-layout>
