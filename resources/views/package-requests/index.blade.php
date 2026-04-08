<x-app-layout>
    <div class="py-6">
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">

            {{-- Success Message --}}
            @if(session('success'))
                <div class="mb-4 p-3 bg-green-100 border border-green-200 text-green-700 rounded-md">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Error Message --}}
            @if(session('error'))
                <div class="mb-4 p-3 bg-red-100 border border-red-200 text-red-700 rounded-md">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Page Header -->
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg mb-6">
                <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                    <div class="flex flex-wrap justify-between items-center gap-3">
                        <div>
                            <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200">
                                <i class="fas fa-inbox text-blue-600"></i> Package Requests Management
                            </h2>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                Review and manage customer package requests
                            </p>
                        </div>

                        <a href="{{ route('users.index') }}" 
                           class="inline-flex items-center px-4 py-2 bg-gray-700 hover:bg-gray-800 text-white rounded-md font-semibold text-xs uppercase transition">
                            <i class="fas fa-arrow-left mr-2"></i> Back to Users
                        </a>
                    </div>

                    <!-- Search Form -->
                    <form method="GET" action="{{ route('package-requests.index') }}" class="mt-4">
                        <div class="flex gap-2">
                            <div class="flex-1">
                                <input type="text" 
                                       name="search" 
                                       value="{{ $search ?? '' }}" 
                                       placeholder="Search by customer name, email, package, or status..." 
                                       class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                            <button type="submit" 
                                    class="px-6 py-2 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 transition-all shadow-lg">
                                <i class="fas fa-search mr-1"></i> Search
                            </button>
                            @if($search)
                                <a href="{{ route('package-requests.index') }}" 
                                   class="px-6 py-2 bg-red-500 text-white rounded-lg font-semibold hover:bg-red-600 transition-all shadow-lg">
                                    <i class="fas fa-times mr-1"></i> Clear
                                </a>
                            @endif
                        </div>
                    </form>

                    <!-- Statistics -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-6">
                        <!-- Pending -->
                        <div class="bg-yellow-50 dark:bg-gray-700 rounded-lg p-4 border border-yellow-200 dark:border-gray-600">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm text-yellow-700 dark:text-yellow-300 font-medium">Pending</p>
                                    <p class="text-2xl font-bold text-yellow-800 dark:text-yellow-200">{{ $pendingCount }}</p>
                                </div>
                                <i class="fas fa-clock text-3xl text-yellow-400"></i>
                            </div>
                        </div>

                        <!-- Approved -->
                        <div class="bg-green-50 dark:bg-gray-700 rounded-lg p-4 border border-green-200 dark:border-gray-600">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm text-green-700 dark:text-green-300 font-medium">Approved</p>
                                    <p class="text-2xl font-bold text-green-800 dark:text-green-200">{{ $approvedCount }}</p>
                                </div>
                                <i class="fas fa-check-circle text-3xl text-green-400"></i>
                            </div>
                        </div>

                        <!-- Rejected -->
                        <div class="bg-red-50 dark:bg-gray-700 rounded-lg p-4 border border-red-200 dark:border-gray-600">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm text-red-700 dark:text-red-300 font-medium">Rejected</p>
                                    <p class="text-2xl font-bold text-red-800 dark:text-red-200">{{ $rejectedCount }}</p>
                                </div>
                                <i class="fas fa-times-circle text-3xl text-red-400"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Package Requests Table -->
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg">
                <div class="p-6">

                    @if($packageRequests->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-300 dark:divide-gray-700">
                                <thead class="bg-gray-50 dark:bg-gray-700">
                                    <tr>
                                        @foreach(['#','Customer','Contact','Package','Price','Status','Requested','Actions'] as $col)
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                                            {{ $col }}
                                        </th>
                                        @endforeach
                                    </tr>
                                </thead>

                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                    @foreach($packageRequests as $req)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                                        <!-- Index -->
                                        <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-200">
                                            {{ $loop->iteration + ($packageRequests->currentPage() - 1) * $packageRequests->perPage() }}
                                        </td>

                                        <!-- Customer -->
                                        <td class="px-6 py-4">
                                            <div class="flex items-center">
                                                <div class="h-10 w-10 rounded-full bg-blue-100 dark:bg-gray-600 flex items-center justify-center">
                                                    <i class="fas fa-user text-blue-600 dark:text-blue-300"></i>
                                                </div>

                                                <div class="ml-4">
                                                    <p class="text-sm font-medium text-gray-900 dark:text-gray-200">
                                                        {{ $req->customer->name }}
                                                    </p>
                                                    <p class="text-sm text-gray-500 dark:text-gray-400">
                                                        {{ $req->customer->email }}
                                                    </p>
                                                </div>
                                            </div>
                                        </td>

                                        <!-- Contact Info -->
                                        <td class="px-6 py-4">
                                            <p class="text-sm text-gray-900 dark:text-gray-200">
                                                <i class="fas fa-phone mr-1 text-gray-400"></i>
                                                {{ $req->customer->phone }}
                                            </p>
                                            @if($req->customer->detail && $req->customer->detail->address)
                                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                                <i class="fas fa-map-marker-alt mr-1"></i>
                                                {{ Str::limit($req->customer->detail->address, 30) }}
                                            </p>
                                            @endif
                                        </td>

                                        <!-- Package -->
                                        <td class="px-6 py-4">
                                            <span class="px-3 py-1 inline-flex text-xs font-semibold rounded-full bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300">
                                                {{ $req->package->name }}
                                            </span>
                                        </td>

                                        <!-- Price -->
                                        <td class="px-6 py-4 text-sm font-semibold text-gray-900 dark:text-gray-200">
                                            ৳{{ number_format($req->package->price) }}
                                        </td>

                                        <!-- Status -->
                                        <td class="px-6 py-4">
                                            @php
                                                $statusColors = [
                                                    'pending' => 'yellow',
                                                    'approved' => 'green',
                                                    'rejected' => 'red',
                                                ];
                                            @endphp

                                            <span class="px-3 py-1 inline-flex text-xs font-semibold rounded-full 
                                                bg-{{ $statusColors[$req->status] }}-100 
                                                text-{{ $statusColors[$req->status] }}-800
                                                dark:bg-{{ $statusColors[$req->status] }}-900 
                                                dark:text-{{ $statusColors[$req->status] }}-300">

                                                @if($req->status === 'pending')
                                                    <i class="fas fa-clock mr-1"></i>
                                                @elseif($req->status === 'approved')
                                                    <i class="fas fa-check mr-1"></i>
                                                @else
                                                    <i class="fas fa-times mr-1"></i>
                                                @endif

                                                {{ ucfirst($req->status) }}
                                            </span>
                                        </td>

                                        <!-- Created -->
                                        <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">
                                            <i class="fas fa-calendar-alt mr-1"></i>
                                            {{ $req->created_at->diffForHumans() }}
                                        </td>

                                        <!-- Actions -->
                                        <td class="px-6 py-4 text-center">
                                            <div class="flex items-center justify-center gap-2">

                                                <!-- View -->
                                                <a href="{{ route('package-requests.show', $req->id) }}" 
                                                   class="inline-flex items-center px-3 py-2 bg-gray-800 hover:bg-gray-900 text-white text-xs rounded-md shadow transition">
                                                    <i class="fas fa-eye mr-1"></i> View
                                                </a>

                                                @if($req->status === 'pending')
                                                    <!-- Accept -->
                                                    <button onclick="openModal('approveModal{{ $req->id }}')"
                                                            class="inline-flex items-center px-3 py-2 bg-green-600 hover:bg-green-700 text-white text-xs rounded-md shadow transition">
                                                        <i class="fas fa-check mr-1"></i> Accept
                                                    </button>

                                                    <!-- Reject -->
                                                    <button onclick="openModal('rejectModal{{ $req->id }}')"
                                                            class="inline-flex items-center px-3 py-2 bg-red-600 hover:bg-red-700 text-white text-xs rounded-md shadow transition">
                                                        <i class="fas fa-times mr-1"></i> Reject
                                                    </button>
                                                @endif
                                            </div>

                                            <!-- Approve Modal -->
                                            @if($req->status === 'pending')
                                            <div id="approveModal{{ $req->id }}" class="modal-overlay fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full z-50">
                                                <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
                                                    <form action="{{ route('package-requests.approve', $req->id) }}" method="POST">
                                                        @csrf
                                                        <div class="mb-4">
                                                            <h3 class="text-lg font-semibold">Approve Request</h3>
                                                        </div>
                                                        <div class="mb-4 text-sm">
                                                            <p><strong>Customer:</strong> {{ $req->customer->name }}</p>
                                                            <p><strong>Package:</strong> {{ $req->package->name }}</p>
                                                            <p><strong>Price:</strong> ৳{{ number_format($req->package->price) }}</p>
                                                            <div class="mt-3">
                                                                <label class="block font-medium mb-1">Remarks (Optional)</label>
                                                                <textarea name="admin_remarks" rows="3" 
                                                                          class="w-full border rounded px-3 py-2"></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="flex justify-end gap-2">
                                                            <button type="button" onclick="closeModal('approveModal{{ $req->id }}')"
                                                                    class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">
                                                                Cancel
                                                            </button>
                                                            <button type="submit" 
                                                                    class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                                                                Approve
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>

                                            <!-- Reject Modal -->
                                            <div id="rejectModal{{ $req->id }}" class="modal-overlay fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full z-50">
                                                <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
                                                    <form action="{{ route('package-requests.reject', $req->id) }}" method="POST">
                                                        @csrf
                                                        <div class="mb-4">
                                                            <h3 class="text-lg font-semibold">Reject Request</h3>
                                                        </div>
                                                        <div class="mb-4 text-sm">
                                                            <p><strong>Customer:</strong> {{ $req->customer->name }}</p>
                                                            <div class="mt-3">
                                                                <label class="block font-medium mb-1">Reason for Rejection *</label>
                                                                <textarea name="admin_remarks" rows="3" required
                                                                          class="w-full border rounded px-3 py-2"></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="flex justify-end gap-2">
                                                            <button type="button" onclick="closeModal('rejectModal{{ $req->id }}')"
                                                                    class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">
                                                                Cancel
                                                            </button>
                                                            <button type="submit" 
                                                                    class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">
                                                                Reject
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="mt-4">
                            {{ $packageRequests->appends(['search' => $search])->links() }}
                        </div>

                    @else
                        <div class="text-center py-12">
                            <i class="fas fa-inbox text-gray-400 text-5xl mb-4"></i>
                            <p class="text-gray-500 dark:text-gray-400">
                                @if($search)
                                    No package requests found matching "{{ $search }}"
                                @else
                                    No package requests found.
                                @endif
                            </p>
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>

    {{-- Modal Script --}}
    <script>
        function openModal(id) {
            document.getElementById(id).classList.remove('hidden');
        }

        function closeModal(id) {
            document.getElementById(id).classList.add('hidden');
        }

        window.onclick = function(e) {
            if (e.target.classList.contains('modal-overlay')) {
                e.target.classList.add('hidden');
            }
        }

        document.addEventListener('keydown', e => {
            if (e.key === 'Escape') {
                document.querySelectorAll('.modal-overlay').forEach(m => m.classList.add('hidden'));
            }
        });
    </script>

</x-app-layout>