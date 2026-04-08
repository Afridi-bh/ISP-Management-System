<x-app-layout>
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Header with Back Button -->
            <div class="mb-6 flex items-center justify-between">
                <div>
                    <h2 class="font-semibold text-2xl text-black">
                        <i class="fas fa-box-open text-blue-600"></i> Package Request Details
                    </h2>
                    <p class="text-sm text-black mt-1">Request ID: #{{ $packageRequest->id }}</p>
                </div>
                <a href="{{ route('package-requests.index') }}" 
                   class="inline-flex items-center px-4 py-2 bg-gray-300 hover:bg-gray-400 text-black rounded-md font-semibold text-xs uppercase transition">
                    <i class="fas fa-arrow-left mr-2"></i> Back to List
                </a>
            </div>

            <!-- Status Badge -->
            <div class="mb-6">
                @if($packageRequest->status === 'pending')
                    <span class="px-4 py-2 inline-flex text-sm leading-5 font-semibold rounded-full bg-yellow-100 text-black border-2 border-yellow-300">
                        <i class="fas fa-clock mr-2"></i> Pending Review
                    </span>
                @elseif($packageRequest->status === 'approved')
                    <span class="px-4 py-2 inline-flex text-sm leading-5 font-semibold rounded-full bg-green-100 text-black border-2 border-green-300">
                        <i class="fas fa-check-circle mr-2"></i> Approved
                    </span>
                @else
                    <span class="px-4 py-2 inline-flex text-sm leading-5 font-semibold rounded-full bg-red-100 text-black border-2 border-red-300">
                        <i class="fas fa-times-circle mr-2"></i> Rejected
                    </span>
                @endif
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                
                <!-- Customer Information - FULL DETAILS -->
                <div class="bg-white shadow-lg rounded-lg border-2 border-blue-200">
                    <div class="bg-gradient-to-r from-blue-500 to-blue-600 border-b px-6 py-4">
                        <h3 class="font-semibold text-lg text-black flex items-center">
                            <i class="fas fa-user text-black mr-2"></i> Customer Information
                        </h3>
                    </div>
                    <div class="p-6">
                        <dl class="space-y-4">
                            <!-- Name -->
                            <div class="border-b pb-3">
                                <dt class="text-sm font-bold text-black mb-1">
                                    <i class="fas fa-user-circle mr-2 text-blue-600"></i>Full Name
                                </dt>
                                <dd class="text-base font-semibold text-black pl-6">
                                    {{ $packageRequest->customer->name }}
                                </dd>
                            </div>

                            <!-- Email -->
                            <div class="border-b pb-3">
                                <dt class="text-sm font-bold text-black mb-1">
                                    <i class="fas fa-envelope mr-2 text-blue-600"></i>Email Address
                                </dt>
                                <dd class="text-base text-black pl-6">
                                    {{ $packageRequest->customer->email }}
                                </dd>
                            </div>

                            <!-- Phone -->
                            <div class="border-b pb-3">
                                <dt class="text-sm font-bold text-black mb-1">
                                    <i class="fas fa-phone mr-2 text-blue-600"></i>Phone Number
                                </dt>
                                <dd class="text-base text-black pl-6">
                                    {{ $packageRequest->customer->phone }}
                                </dd>
                            </div>

                            <!-- Address -->
                            <div class="border-b pb-3">
                                <dt class="text-sm font-bold text-black mb-1">
                                    <i class="fas fa-map-marker-alt mr-2 text-blue-600"></i>Address
                                </dt>
                                <dd class="text-base text-black pl-6">
                                    @if($packageRequest->customer->detail && $packageRequest->customer->detail->address)
                                        {{ $packageRequest->customer->detail->address }}
                                    @elseif($packageRequest->customer->address)
                                        {{ $packageRequest->customer->address }}
                                    @else
                                        <span class="text-gray-500 italic">No address provided</span>
                                    @endif
                                </dd>
                            </div>

                            <!-- Date of Birth -->
                            @if($packageRequest->customer->detail && $packageRequest->customer->detail->dob)
                            <div class="border-b pb-3">
                                <dt class="text-sm font-bold text-black mb-1">
                                    <i class="fas fa-birthday-cake mr-2 text-blue-600"></i>Date of Birth
                                </dt>
                                <dd class="text-base text-black pl-6">
                                    {{ \Carbon\Carbon::parse($packageRequest->customer->detail->dob)->format('F d, Y') }}
                                    <span class="text-sm text-gray-600 ml-2">
                                        ({{ \Carbon\Carbon::parse($packageRequest->customer->detail->dob)->age }} years old)
                                    </span>
                                </dd>
                            </div>
                            @endif

                            <!-- Current Package -->
                            <div class="border-b pb-3">
                                <dt class="text-sm font-bold text-black mb-1">
                                    <i class="fas fa-box mr-2 text-blue-600"></i>Current Package
                                </dt>
                                <dd class="text-base text-black pl-6">
                                    @if($packageRequest->customer->detail && $packageRequest->customer->detail->package_name)
                                        <span class="px-3 py-1 bg-blue-100 text-black rounded-full text-sm font-semibold border border-blue-300">
                                            {{ $packageRequest->customer->detail->package_name }}
                                        </span>
                                        <span class="ml-2 text-sm text-black">
                                            (৳{{ number_format($packageRequest->customer->detail->package_price) }}/month)
                                        </span>
                                    @else
                                        <span class="px-3 py-1 bg-gray-100 text-black rounded-full text-sm font-semibold border border-gray-300">
                                            No Active Package
                                        </span>
                                    @endif
                                </dd>
                            </div>

                            <!-- Account Status -->
                            <div class="border-b pb-3">
                                <dt class="text-sm font-bold text-black mb-1">
                                    <i class="fas fa-info-circle mr-2 text-blue-600"></i>Account Status
                                </dt>
                                <dd class="text-base text-black pl-6">
                                    <span class="px-3 py-1 rounded-full text-sm font-semibold border-2
                                        {{ $packageRequest->customer->status === 'active' ? 'bg-green-100 text-black border-green-300' : 'bg-red-100 text-black border-red-300' }}">
                                        {{ ucfirst($packageRequest->customer->status) }}
                                    </span>
                                </dd>
                            </div>

                            <!-- Due Amount -->
                            @if($packageRequest->customer->detail)
                            <div class="border-b pb-3">
                                <dt class="text-sm font-bold text-black mb-1">
                                    <i class="fas fa-dollar-sign mr-2 text-blue-600"></i>Due Amount
                                </dt>
                                <dd class="text-base font-bold text-black pl-6">
                                    ৳{{ number_format($packageRequest->customer->detail->due ?? 0) }}
                                    @if(($packageRequest->customer->detail->due ?? 0) > 0)
                                        <span class="ml-2 px-2 py-1 bg-red-100 text-black text-xs rounded border border-red-300">
                                            Payment Pending
                                        </span>
                                    @else
                                        <span class="ml-2 px-2 py-1 bg-green-100 text-black text-xs rounded border border-green-300">
                                            No Due
                                        </span>
                                    @endif
                                </dd>
                            </div>
                            @endif

                            <!-- Customer Since -->
                            <div class="pb-3">
                                <dt class="text-sm font-bold text-black mb-1">
                                    <i class="fas fa-calendar-plus mr-2 text-blue-600"></i>Customer Since
                                </dt>
                                <dd class="text-base text-black pl-6">
                                    {{ $packageRequest->customer->created_at->format('F d, Y') }}
                                    <span class="text-sm text-gray-600 ml-2">
                                        ({{ $packageRequest->customer->created_at->diffForHumans() }})
                                    </span>
                                </dd>
                            </div>
                        </dl>

                        <div class="mt-6 pt-6 border-t">
                            <a href="{{ route('customers.show', $packageRequest->customer->id) }}" 
                               class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-black text-sm rounded-lg transition w-full justify-center font-semibold shadow-lg">
                                <i class="fas fa-external-link-alt mr-2"></i> View Full Customer Profile
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Package Information -->
                <div class="bg-white shadow-lg rounded-lg border-2 border-green-200">
                    <div class="bg-gradient-to-r from-green-500 to-green-600 border-b px-6 py-4">
                        <h3 class="font-semibold text-lg text-black flex items-center">
                            <i class="fas fa-box text-black mr-2"></i> Requested Package Details
                        </h3>
                    </div>
                    <div class="p-6">
                        <dl class="space-y-4">
                            <!-- Package Name -->
                            <div class="border-b pb-3">
                                <dt class="text-sm font-bold text-black mb-1">
                                    <i class="fas fa-tag mr-2 text-green-600"></i>Package Name
                                </dt>
                                <dd class="text-lg font-bold text-black pl-6">
                                    {{ $packageRequest->package->name }}
                                </dd>
                            </div>

                            <!-- Speed -->
                            <div class="border-b pb-3">
                                <dt class="text-sm font-bold text-black mb-1">
                                    <i class="fas fa-tachometer-alt mr-2 text-green-600"></i>Connection Speed
                                </dt>
                                <dd class="text-base text-black pl-6">
                                    <span class="font-semibold text-lg">{{ $packageRequest->package->speed }} Mbps</span>
                                </dd>
                            </div>

                            <!-- Price -->
                            <div class="border-b pb-3">
                                <dt class="text-sm font-bold text-black mb-1">
                                    <i class="fas fa-money-bill-wave mr-2 text-green-600"></i>Monthly Price
                                </dt>
                                <dd class="text-2xl font-bold text-black pl-6">
                                    ৳{{ number_format($packageRequest->package->price) }}
                                    <span class="text-sm font-normal text-gray-600">/month</span>
                                </dd>
                            </div>

                            <!-- Description -->
                            @if($packageRequest->package->description)
                            <div class="pb-3">
                                <dt class="text-sm font-bold text-black mb-2">
                                    <i class="fas fa-info-circle mr-2 text-green-600"></i>Package Description
                                </dt>
                                <dd class="text-base text-black bg-gray-50 p-4 rounded-lg border border-gray-200">
                                    {{ $packageRequest->package->description }}
                                </dd>
                            </div>
                            @endif

                            <!-- Package Features (if available) -->
                            <div class="bg-green-50 p-4 rounded-lg border border-green-200">
                                <h4 class="text-sm font-bold text-black mb-2">
                                    <i class="fas fa-check-circle mr-2 text-green-600"></i>Package Highlights
                                </h4>
                                <ul class="space-y-2 text-black">
                                    <li class="flex items-center">
                                        <i class="fas fa-wifi text-green-600 mr-2"></i>
                                        <span>High-speed internet: {{ $packageRequest->package->speed }} Mbps</span>
                                    </li>
                                    <li class="flex items-center">
                                        <i class="fas fa-calendar-check text-green-600 mr-2"></i>
                                        <span>Monthly subscription</span>
                                    </li>
                                    <li class="flex items-center">
                                        <i class="fas fa-headset text-green-600 mr-2"></i>
                                        <span>24/7 customer support</span>
                                    </li>
                                </ul>
                            </div>
                        </dl>
                    </div>
                </div>

                <!-- Request Timeline -->
                <div class="bg-white shadow-lg rounded-lg border-2 border-purple-200">
                    <div class="bg-gradient-to-r from-purple-500 to-purple-600 border-b px-6 py-4">
                        <h3 class="font-semibold text-lg text-black flex items-center">
                            <i class="fas fa-history text-black mr-2"></i> Request Timeline
                        </h3>
                    </div>
                    <div class="p-6">
                        <div class="space-y-6">
                            <!-- Requested -->
                            <div class="flex items-start">
                                <div class="flex-shrink-0 h-12 w-12 rounded-full bg-blue-100 flex items-center justify-center border-2 border-blue-300">
                                    <i class="fas fa-paper-plane text-blue-600 text-lg"></i>
                                </div>
                                <div class="ml-4">
                                    <p class="text-base font-bold text-black">Request Submitted</p>
                                    <p class="text-sm text-black font-semibold">
                                        {{ $packageRequest->created_at->format('F d, Y') }} at {{ $packageRequest->created_at->format('h:i A') }}
                                    </p>
                                    <p class="text-sm text-gray-600">{{ $packageRequest->created_at->diffForHumans() }}</p>
                                </div>
                            </div>

                            @if($packageRequest->status === 'approved')
                                <!-- Approved -->
                                <div class="flex items-start">
                                    <div class="flex-shrink-0 h-12 w-12 rounded-full bg-green-100 flex items-center justify-center border-2 border-green-300">
                                        <i class="fas fa-check text-green-600 text-lg"></i>
                                    </div>
                                    <div class="ml-4">
                                        <p class="text-base font-bold text-black">Request Approved</p>
                                        <p class="text-sm text-black font-semibold">
                                            {{ $packageRequest->approved_at->format('F d, Y') }} at {{ $packageRequest->approved_at->format('h:i A') }}
                                        </p>
                                        <p class="text-sm text-gray-600">
                                            Approved by: <span class="font-semibold text-black">{{ $packageRequest->approvedBy->name ?? 'System Administrator' }}</span>
                                        </p>
                                    </div>
                                </div>
                            @elseif($packageRequest->status === 'rejected')
                                <!-- Rejected -->
                                <div class="flex items-start">
                                    <div class="flex-shrink-0 h-12 w-12 rounded-full bg-red-100 flex items-center justify-center border-2 border-red-300">
                                        <i class="fas fa-times text-red-600 text-lg"></i>
                                    </div>
                                    <div class="ml-4">
                                        <p class="text-base font-bold text-black">Request Rejected</p>
                                        <p class="text-sm text-black font-semibold">
                                            {{ $packageRequest->updated_at->format('F d, Y') }} at {{ $packageRequest->updated_at->format('h:i A') }}
                                        </p>
                                        <p class="text-sm text-gray-600">
                                            Rejected by: <span class="font-semibold text-black">{{ $packageRequest->approvedBy->name ?? 'System Administrator' }}</span>
                                        </p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Admin Remarks -->
                <div class="bg-white shadow-lg rounded-lg border-2 border-gray-200">
                    <div class="bg-gradient-to-r from-gray-400 to-gray-500 border-b px-6 py-4">
                        <h3 class="font-semibold text-lg text-black flex items-center">
                            <i class="fas fa-comment-alt text-black mr-2"></i> Admin Remarks
                        </h3>
                    </div>
                    <div class="p-6">
                        @if($packageRequest->admin_remarks)
                            <div class="bg-gray-50 border-2 border-gray-300 rounded-lg p-4">
                                <p class="text-base text-black whitespace-pre-line leading-relaxed">{{ $packageRequest->admin_remarks }}</p>
                            </div>
                        @else
                            <div class="text-center py-8">
                                <i class="fas fa-comment-slash text-gray-400 text-4xl mb-3"></i>
                                <p class="text-black italic">No remarks added yet.</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Customer Notes -->
                @if($packageRequest->customer_notes)
                <div class="bg-white shadow-lg rounded-lg border-2 border-indigo-200 md:col-span-2">
                    <div class="bg-gradient-to-r from-indigo-500 to-indigo-600 border-b px-6 py-4">
                        <h3 class="font-semibold text-lg text-black flex items-center">
                            <i class="fas fa-sticky-note text-black mr-2"></i> Customer Notes & Special Requests
                        </h3>
                    </div>
                    <div class="p-6">
                        <div class="bg-indigo-50 border-2 border-indigo-300 rounded-lg p-4">
                            <p class="text-base text-black whitespace-pre-line leading-relaxed">{{ $packageRequest->customer_notes }}</p>
                        </div>
                        <p class="text-sm text-gray-600 mt-3 flex items-center">
                            <i class="fas fa-info-circle mr-2"></i>
                            This information was provided by the customer during request submission.
                        </p>
                    </div>
                </div>
                @endif

            </div>

            <!-- Action Buttons (Only for Pending) -->
            @if($packageRequest->status === 'pending')
                <div class="mt-6 bg-white shadow-lg rounded-lg p-6 border-2 border-yellow-200">
                    <h3 class="font-semibold text-lg text-black mb-4 flex items-center">
                        <i class="fas fa-tasks mr-2 text-yellow-600"></i> Administrative Actions
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <button type="button" 
                                onclick="openModal('approveModalShow')"
                                class="inline-flex items-center justify-center px-6 py-4 bg-green-600 hover:bg-green-700 text-black rounded-lg font-bold text-base uppercase transition shadow-lg hover:shadow-xl">
                            <i class="fas fa-check-circle mr-2 text-lg"></i> Approve Request
                        </button>
                        <button type="button" 
                                onclick="openModal('rejectModalShow')"
                                class="inline-flex items-center justify-center px-6 py-4 bg-red-600 hover:bg-red-700 text-black rounded-lg font-bold text-base uppercase transition shadow-lg hover:shadow-xl">
                            <i class="fas fa-times-circle mr-2 text-lg"></i> Reject Request
                        </button>
                    </div>
                </div>

                <!-- Approve Modal -->
                <div id="approveModalShow" class="fixed inset-0 bg-gray-900 bg-opacity-75 hidden overflow-y-auto h-full w-full z-50">
                    <div class="relative top-20 mx-auto p-6 border-2 w-full max-w-md shadow-2xl rounded-lg bg-white">
                        <form action="{{ route('package-requests.approve', $packageRequest->id) }}" method="POST">
                            @csrf
                            <div class="mb-4">
                                <h3 class="text-xl font-bold text-black flex items-center">
                                    <i class="fas fa-check-circle text-green-600 mr-2 text-2xl"></i>
                                    Approve Package Request
                                </h3>
                            </div>
                            <div class="mb-4 text-sm text-black">
                                <p class="mb-3 text-base">Are you sure you want to approve this package request?</p>
                                <div class="bg-gray-50 p-4 rounded-lg border border-gray-300 space-y-2">
                                    <p class="text-black"><strong>Customer:</strong> {{ $packageRequest->customer->name }}</p>
                                    <p class="text-black"><strong>Package:</strong> {{ $packageRequest->package->name }}</p>
                                    <p class="text-black"><strong>Price:</strong> ৳{{ number_format($packageRequest->package->price) }}/month</p>
                                </div>
                                <div class="mt-4">
                                    <label class="block text-sm font-bold text-black mb-2">Admin Remarks (Optional)</label>
                                    <textarea name="admin_remarks" rows="3" 
                                              class="w-full border-2 border-gray-300 rounded-lg px-3 py-2 text-black focus:border-green-500 focus:ring focus:ring-green-200"
                                              placeholder="Add any remarks or notes..."></textarea>
                                </div>
                            </div>
                            <div class="flex justify-end gap-3">
                                <button type="button" 
                                        onclick="closeModal('approveModalShow')"
                                        class="px-5 py-2 bg-gray-300 text-black rounded-lg hover:bg-gray-400 font-semibold">
                                    Cancel
                                </button>
                                <button type="submit" 
                                        class="px-5 py-2 bg-green-600 text-black rounded-lg hover:bg-green-700 font-semibold shadow-lg">
                                    <i class="fas fa-check mr-1"></i> Approve
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Reject Modal -->
                <div id="rejectModalShow" class="fixed inset-0 bg-gray-900 bg-opacity-75 hidden overflow-y-auto h-full w-full z-50">
                    <div class="relative top-20 mx-auto p-6 border-2 w-full max-w-md shadow-2xl rounded-lg bg-white">
                        <form action="{{ route('package-requests.reject', $packageRequest->id) }}" method="POST">
                            @csrf
                            <div class="mb-4">
                                <h3 class="text-xl font-bold text-black flex items-center">
                                    <i class="fas fa-times-circle text-red-600 mr-2 text-2xl"></i>
                                    Reject Package Request
                                </h3>
                            </div>
                            <div class="mb-4 text-sm text-black">
                                <p class="mb-3 text-base">Are you sure you want to reject this package request?</p>
                                <div class="bg-gray-50 p-4 rounded-lg border border-gray-300 space-y-2">
                                    <p class="text-black"><strong>Customer:</strong> {{ $packageRequest->customer->name }}</p>
                                    <p class="text-black"><strong>Package:</strong> {{ $packageRequest->package->name }}</p>
                                </div>
                                <div class="mt-4">
                                    <label class="block text-sm font-bold text-black mb-2">Reason for Rejection *</label>
                                    <textarea name="admin_remarks" rows="4" required
                                              class="w-full border-2 border-gray-300 rounded-lg px-3 py-2 text-black focus:border-red-500 focus:ring focus:ring-red-200"
                                              placeholder="Please provide a clear reason for rejection..."></textarea>
                                    <p class="text-xs text-gray-600 mt-1">This reason will be visible to the customer.</p>
                                </div>
                            </div>
                            <div class="flex justify-end gap-3">
                                <button type="button" 
                                        onclick="closeModal('rejectModalShow')"
                                        class="px-5 py-2 bg-gray-300 text-black rounded-lg hover:bg-gray-400 font-semibold">
                                    Cancel
                                </button>
                                <button type="submit" 
                                        class="px-5 py-2 bg-red-600 text-black rounded-lg hover:bg-red-700 font-semibold shadow-lg">
                                    <i class="fas fa-times mr-1"></i> Reject
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            @endif

        </div>
    </div>

    <script>
        function openModal(modalId) {
            document.getElementById(modalId).classList.remove('hidden');
        }

        function closeModal(modalId) {
            document.getElementById(modalId).classList.add('hidden');
        }

        window.onclick = function(event) {
            if (event.target.classList.contains('bg-opacity-75')) {
                event.target.classList.add('hidden');
            }
        }

        // Close modal on ESC key
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                document.querySelectorAll('[id$="ModalShow"]').forEach(modal => {
                    modal.classList.add('hidden');
                });
            }
        });
    </script>
</x-app-layout>