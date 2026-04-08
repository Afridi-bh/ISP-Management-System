<x-app-layout>
    <div class="py-6">
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if(session('error'))
                        <div class="alert alert-danger text-red-600 mb-4 p-3 bg-red-100 rounded">
                            {{ session('error') }}
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="mb-4 p-3 bg-red-100 border border-red-400 text-red-700 rounded">
                            <ul class="list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="flex justify-between items-center mb-6 border-b-2 border-slate-100 pb-4">
                        <div>
                            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                                {{ __('Generate Monthly Bills') }}
                            </h2>
                            <p class="text-sm text-gray-500 mt-1">Select users to generate bills for this month</p>
                        </div>
                        <a href="{{ route('billing.index') }}" 
                           class="inline-flex items-center px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-800 rounded-md font-semibold text-xs uppercase transition">
                            <i class="fas fa-arrow-left mr-2"></i> Back
                        </a>
                    </div>

                    <div>
                        <form method="post" action="{{ route('billing.store') }}" class="mt-6 space-y-6">
                            @csrf

                            <!-- Select All Checkbox -->
                            <div class="mb-4 p-3 bg-blue-50 rounded-lg border border-blue-200">
                                <label class="flex items-center cursor-pointer">
                                    <input type="checkbox" id="select-all" class="rounded mr-2">
                                    <span class="font-semibold text-blue-800">Select All Users</span>
                                </label>
                            </div>

                            <!-- Users Section -->
                            @if($users->count() > 0)
                            <div class="mb-6">
                                <h3 class="text-lg font-semibold text-gray-800 mb-3 flex items-center">
                                    <i class="fas fa-user-shield mr-2 text-blue-600"></i>
                                    Users ({{ $users->count() }})
                                </h3>
                                <div class="overflow-x-auto">
                                    <table class="w-full border-collapse border border-gray-300 rounded-lg overflow-hidden">
                                        <thead class="bg-gradient-to-r from-blue-500 to-blue-600 text-white">
                                            <tr>
                                                <th class="border border-gray-300 p-3 text-left w-20">
                                                    <input type="checkbox" class="rounded select-all-users">
                                                </th>
                                                <th class="border border-gray-300 p-3 text-left">{{ __('User') }}</th>
                                                <th class="border border-gray-300 p-3 text-left">{{ __('Package') }}</th>
                                                <th class="border border-gray-300 p-3 text-left">{{ __('Price') }}</th>
                                                <th class="border border-gray-300 p-3 text-left">{{ __('Current Due') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($users as $user)
                                        <tr class="hover:bg-blue-50 transition">
                                            <td class="border border-gray-300 p-3">
                                                <input type="checkbox" 
                                                       class="rounded account-checkbox user-checkbox" 
                                                       name="checked[]" 
                                                       value="{{ $user->id }}">
                                                <input type="hidden" name="user_id[]" value="{{ $user->id }}">
                                            </td>
                                            <td class="border border-gray-300 p-3 font-semibold text-gray-800">
                                                {{ $user->name }}
                                                <span class="block text-xs text-gray-500">{{ $user->email }}</span>
                                            </td>
                                            <td class="border border-gray-300 p-3">
                                                <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded text-sm">
                                                    {{ $user->detail->package_name }}
                                                </span>
                                            </td>
                                            <td class="border border-gray-300 p-3 font-bold text-green-600">
                                                ৳{{ number_format($user->detail->package_price) }}
                                            </td>
                                            <td class="border border-gray-300 p-3 font-semibold text-red-600">
                                                ৳{{ number_format($user->detail->due ?? 0) }}
                                            </td>
                                        </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!-- Summary -->
                            <div class="bg-gray-50 p-4 rounded-lg border border-gray-300">
                                <div class="flex justify-between items-center">
                                    <div>
                                        <p class="text-sm text-gray-600">Selected Users: <span id="selected-count" class="font-bold text-gray-800">0</span></p>
                                        <p class="text-sm text-gray-600">Total Amount: <span id="total-amount" class="font-bold text-green-600">৳0</span></p>
                                    </div>
                                    <button type="submit" 
                                            class="inline-flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-semibold text-sm uppercase transition shadow-lg disabled:opacity-50 disabled:cursor-not-allowed"
                                            id="generate-btn"
                                            disabled>
                                        <i class="fas fa-file-invoice-dollar mr-2"></i>
                                        {{ __('Generate Bills') }}
                                    </button>
                                </div>
                            </div>
                            @else
                            <div class="text-center py-12 bg-gray-50 rounded-lg border border-gray-300">
                                <i class="fas fa-inbox text-gray-400 text-5xl mb-4"></i>
                                <p class="text-gray-500 font-medium text-lg">No active users found.</p>
                                <p class="text-gray-400 text-sm mt-2">There are no users with active packages to generate bills for.</p>
                            </div>
                            @endif
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const selectAll = document.getElementById('select-all');
            const accountCheckboxes = document.querySelectorAll('.account-checkbox');
            const selectedCount = document.getElementById('selected-count');
            const totalAmount = document.getElementById('total-amount');
            const generateBtn = document.getElementById('generate-btn');

            // Select All functionality
            selectAll?.addEventListener('change', function() {
                accountCheckboxes.forEach(cb => cb.checked = this.checked);
                updateSummary();
            });

            // Individual checkbox functionality
            accountCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    updateSelectAllState();
                    updateSummary();
                });
            });

            function updateSelectAllState() {
                const allChecked = Array.from(accountCheckboxes).every(cb => cb.checked);
                const someChecked = Array.from(accountCheckboxes).some(cb => cb.checked);
                
                if (selectAll) {
                    selectAll.checked = allChecked;
                    selectAll.indeterminate = !allChecked && someChecked;
                }
            }

            function updateSummary() {
                const checked = document.querySelectorAll('.account-checkbox:checked');
                let total = 0;

                checked.forEach(checkbox => {
                    const row = checkbox.closest('tr');
                    const priceText = row.querySelector('td:nth-child(4)').textContent;
                    const price = parseInt(priceText.replace(/[^\d]/g, ''));
                    total += price;
                });

                if (selectedCount) selectedCount.textContent = checked.length;
                if (totalAmount) totalAmount.textContent = '৳' + total.toLocaleString();
                if (generateBtn) generateBtn.disabled = checked.length === 0;
            }

            // Initial state
            updateSummary();
        });
    </script>
</x-app-layout>