<x-app-layout>
    <div class="max-w-7xl mx-auto py-8">

        {{-- Header --}}
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">Customer List</h1>

            <a href="{{ route('admin.customers.create') }}"
               class="px-4 py-2 bg-blue-600 text-white rounded">
                Add Customer
            </a>
        </div>

        {{-- Table --}}
        <div class="bg-white shadow rounded p-6">
            <table class="w-full text-left">
                <thead>
                    <tr class="border-b">
                        <th class="py-2">Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Package</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($customers as $customer)
                        <tr class="border-b">
                            <td class="py-2">{{ $customer->name }}</td>
                            <td>{{ $customer->email }}</td>
                            <td>{{ $customer->phone }}</td>
                            <td>{{ $customer->package_name ?? '-' }}</td>
                            <td>
                                <span class="px-2 py-1 bg-gray-200 rounded">
                                    {{ ucfirst($customer->status) }}
                                </span>
                            </td>
                            <td class="space-x-2">

                                {{-- View --}}
                                <a href="{{ route('admin.customers.show', $customer->id) }}" 
                                   class="px-3 py-1 bg-gray-700 text-white rounded">
                                    View
                                </a>

                                {{-- Edit --}}
                                <a href="{{ route('admin.customers.edit', $customer->id) }}" 
                                   class="px-3 py-1 bg-blue-600 text-white rounded">
                                    Edit
                                </a>

                                {{-- Delete --}}
                                <form action="{{ route('admin.customers.destroy', $customer->id) }}" 
                                      method="POST" class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button class="px-3 py-1 bg-red-600 text-white rounded"
                                            onclick="return confirm('Delete this customer?')">
                                        Delete
                                    </button>
                                </form>

                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            {{-- Empty state --}}
            @if($customers->isEmpty())
                <p class="text-gray-500 mt-4">No customers found.</p>
            @endif
        </div>
    </div>
</x-app-layout>
