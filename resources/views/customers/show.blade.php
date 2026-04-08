<x-app-layout>
    <div class="py-6">
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @if(session('error'))
                        <div class="alert alert-danger text-red-600 mb-4 p-3 bg-red-100 rounded">
                            {{ session('error') }}
                        </div>
                    @endif
                    @if(session('success'))
                        <div class="alert alert-success text-green-600 mb-4 p-3 bg-green-100 rounded">
                            {{ session('success') }}
                        </div>
                    @endif
                    
                    <div class="flex justify-between items-center mb-6 border-b-2 border-slate-100 pb-4">
                        <div>
                            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                                {{ $customer->name }}
                            </h2>
                            <p class="text-sm text-gray-500 mt-1">
                                <span class="px-2 py-1 text-xs rounded bg-green-100 text-green-800">
                                    <i class="fas fa-user mr-1"></i>Customer
                                </span>
                                <span class="px-2 py-1 text-xs rounded ml-2 
                                    {{ $customer->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ ucfirst($customer->status) }}
                                </span>
                            </p>
                        </div>
                        
                        <div class="flex items-center gap-2">
                            @if($customer->detail)
                                <a href="#" 
                                   class="inline-flex items-center px-4 py-2 bg-sky-500 hover:bg-sky-600 text-white border border-transparent rounded-md font-semibold text-xs uppercase transition">
                                    <i class="fas fa-exchange-alt mr-1"></i> {{ __('Change package') }}
                                </a>
                            @endif

                            <a href="{{ route('customers.edit', $customer) }}" 
                               class="inline-flex items-center px-4 py-2 bg-gray-800 hover:bg-gray-700 text-white border border-transparent rounded-md font-semibold text-xs uppercase transition">
                                <i class="fas fa-edit mr-1"></i> {{ __('Edit') }}
                            </a>

                            @if($customer->status == 'active')
                                <form method="post" action="{{ route('customer.disable', $customer) }}">
                                    @csrf
                                    @method('patch')
                                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white border border-transparent rounded-md font-semibold text-xs uppercase transition">
                                        <i class="fas fa-ban mr-1"></i> {{ __('Suspend') }}
                                    </button>
                                </form>
                            @else
                                <form method="post" action="{{ route('customer.enable', $customer) }}">
                                    @csrf
                                    @method('patch')
                                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white border border-transparent rounded-md font-semibold text-xs uppercase transition">
                                        <i class="fas fa-check mr-1"></i> {{ __('Activate') }}
                                    </button>
                                </form>
                            @endif

                            <a href="{{ route('users.index') }}" 
                               class="inline-flex items-center px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-800 rounded-md font-semibold text-xs uppercase transition">
                                <i class="fas fa-arrow-left mr-1"></i> {{ __('Back') }}
                            </a>
                        </div>
                    </div>
                    
                    @if($customer->detail)
                        <!-- Customer Details Display -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div class="bg-gray-50 dark:bg-gray-700 p-6 rounded-lg border border-gray-200">
                                <h3 class="font-semibold text-lg mb-4 text-gray-800 dark:text-gray-200 border-b pb-2">
                                    <i class="fas fa-user text-blue-600"></i> Personal Information
                                </h3>
                                <dl class="space-y-3">
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Email</dt>
                                        <dd class="text-sm text-gray-900 dark:text-gray-100 mt-1">
                                            <i class="fas fa-envelope text-gray-400 mr-2"></i>{{ $customer->email }}
                                        </dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Phone</dt>
                                        <dd class="text-sm text-gray-900 dark:text-gray-100 mt-1">
                                            <i class="fas fa-phone text-gray-400 mr-2"></i>{{ $customer->phone ?? $customer->detail->phone ?? 'N/A' }}
                                        </dd>
                                    </div>
                                    @if($customer->detail->address)
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Address</dt>
                                        <dd class="text-sm text-gray-900 dark:text-gray-100 mt-1">
                                            <i class="fas fa-map-marker-alt text-gray-400 mr-2"></i>{{ $customer->detail->address }}
                                        </dd>
                                    </div>
                                    @endif
                                    @if($customer->detail->dob)
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Date of Birth</dt>
                                        <dd class="text-sm text-gray-900 dark:text-gray-100 mt-1">
                                            <i class="fas fa-calendar text-gray-400 mr-2"></i>{{ \Carbon\Carbon::parse($customer->detail->dob)->format('M d, Y') }}
                                        </dd>
                                    </div>
                                    @endif
                                    @if($customer->detail->pin)
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">PIN</dt>
                                        <dd class="text-sm text-gray-900 dark:text-gray-100 mt-1">
                                            <i class="fas fa-key text-gray-400 mr-2"></i>{{ $customer->detail->pin }}
                                        </dd>
                                    </div>
                                    @endif
                                </dl>
                            </div>

                            <div class="bg-gray-50 dark:bg-gray-700 p-6 rounded-lg border border-gray-200">
                                <h3 class="font-semibold text-lg mb-4 text-gray-800 dark:text-gray-200 border-b pb-2">
                                    <i class="fas fa-box text-green-600"></i> Package Information
                                </h3>
                                <dl class="space-y-3">
                                    @if($customer->detail->package_name)
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Package</dt>
                                        <dd class="text-sm font-semibold text-gray-900 dark:text-gray-100 mt-1">
                                            <i class="fas fa-cube text-gray-400 mr-2"></i>{{ $customer->detail->package_name }}
                                        </dd>
                                    </div>
                                    @endif
                                    @if($customer->detail->router_name)
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Router</dt>
                                        <dd class="text-sm text-gray-900 dark:text-gray-100 mt-1">
                                            <i class="fas fa-router text-gray-400 mr-2"></i>{{ $customer->detail->router_name }}
                                        </dd>
                                    </div>
                                    @endif
                                    @if(isset($customer->detail->package_price))
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Package Price</dt>
                                        <dd class="text-sm text-gray-900 dark:text-gray-100 mt-1">
                                            <i class="fas fa-tag text-gray-400 mr-2"></i>৳{{ number_format($customer->detail->package_price) }}
                                        </dd>
                                    </div>
                                    @endif
                                    @if(isset($customer->detail->due))
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Due Amount</dt>
                                        <dd class="text-sm font-bold text-red-600 mt-1">
                                            <i class="fas fa-exclamation-triangle mr-2"></i>৳{{ number_format($customer->detail->due) }}
                                        </dd>
                                    </div>
                                    @endif
                                    @if($customer->detail->package_start)
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Package Start Date</dt>
                                        <dd class="text-sm text-gray-900 dark:text-gray-100 mt-1">
                                            <i class="fas fa-calendar-check text-gray-400 mr-2"></i>{{ \Carbon\Carbon::parse($customer->detail->package_start)->format('M d, Y') }}
                                        </dd>
                                    </div>
                                    @endif
                                    @if($customer->detail->status)
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Account Status</dt>
                                        <dd class="text-sm mt-1">
                                            <span class="px-2 py-1 rounded {{ $customer->detail->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                {{ ucfirst($customer->detail->status) }}
                                            </span>
                                        </dd>
                                    </div>
                                    @endif
                                </dl>
                            </div>
                        </div>
                    @else
                        <div class="text-center py-12">
                            <i class="fas fa-info-circle text-gray-400 text-5xl mb-4"></i>
                            <p class="text-gray-500 text-lg mb-4">No package details available for this customer</p>
                            <a href="{{ route('customers.edit', $customer) }}" 
                               class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-md">
                                <i class="fas fa-plus mr-2"></i> Add Package Details
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>