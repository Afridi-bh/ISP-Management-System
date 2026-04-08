<x-app-layout>
    <div class="py-6">
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="alert alert-success text-green-600 mb-4 p-3 bg-green-100 rounded-lg shadow-sm border border-green-200">
                    <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger text-red-600 mb-4 p-3 bg-red-100 rounded-lg shadow-sm border border-red-200">
                    <i class="fas fa-exclamation-circle mr-2"></i>{{ session('error') }}
                </div>
            @endif

            <!-- Page Header with Search -->
            <div class="bg-white shadow-2xl rounded-lg mb-6 border-2 border-purple-200">
                <div class="p-6 bg-gradient-to-r from-blue-600 to-purple-600 rounded-t-lg">
                    <div class="flex justify-between items-center flex-wrap gap-4">
                        <div>
                            <h2 class="font-semibold text-2xl text-black">
                                <i class="fas fa-users mr-2"></i> Users & Customers Management
                            </h2>
                            <p class="text-sm text-blue-100 mt-2">Manage all users, customers, and package requests</p>
                        </div>
                        <a href="{{ route('users.create') }}" 
                           class="inline-flex items-center px-5 py-2.5 bg-gradient-to-r from-pink-500 via-rose-500 to-red-500 hover:from-pink-600 hover:via-rose-600 hover:to-red-600 text-black rounded-lg font-bold text-sm uppercase transition-all duration-300 shadow-xl hover:shadow-2xl transform hover:scale-110 hover:-translate-y-1 border-2 border-white">
                            <i class="fas fa-plus mr-2"></i> Add New User/Customer
                        </a>
                    </div>
                    
                    <!-- Search Form -->
                    <form method="GET" action="{{ route('users.index') }}" class="mt-4">
                        <div class="flex gap-2">
                            <div class="flex-1">
                                <input type="text" 
                                       name="search" 
                                       value="{{ $search ?? '' }}" 
                                       placeholder="Search by name, email, or phone..." 
                                       class="w-full px-4 py-2 rounded-lg border-2 border-white/30 bg-white/10 text-black placeholder-white/60 focus:outline-none focus:ring-2 focus:ring-white/50">
                            </div>
                            <button type="submit" 
                                    class="px-6 py-2 bg-white text-blue-600 rounded-lg font-semibold hover:bg-blue-50 transition-all shadow-lg">
                                <i class="fas fa-search mr-1"></i> Search
                            </button>
                            @if($search)
                                <a href="{{ route('users.index') }}" 
                                   class="px-6 py-2 bg-red-500 text-black rounded-lg font-semibold hover:bg-red-600 transition-all shadow-lg">
                                    <i class="fas fa-times mr-1"></i> Clear
                                </a>
                            @endif
                        </div>
                    </form>
                </div>
            </div>

            <!-- Package Requests Quick Access -->
            <div class="bg-white shadow-2xl rounded-lg mb-6 border-2 border-indigo-200">
                <div class="bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600 px-6 py-4 rounded-t-lg">
                    <h3 class="font-semibold text-lg text-black flex items-center">
                        <i class="fas fa-box mr-2"></i> Package Requests Overview
                    </h3>
                </div>
                <div class="p-6 bg-white">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        
                        <!-- View All Requests -->
                        <a href="{{ route('package-requests.index') }}" 
                           class="group bg-gradient-to-br from-blue-50 to-indigo-50 hover:from-blue-100 hover:to-indigo-100 rounded-lg p-6 border-2 border-blue-200 hover:border-blue-400 transition-all duration-300 shadow-lg hover:shadow-2xl transform hover:scale-105">
                            <div class="flex items-center justify-between mb-3">
                                <div class="h-12 w-12 rounded-full bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform">
                                    <i class="fas fa-list text-white text-xl"></i>
                                </div>
                                <i class="fas fa-arrow-right text-blue-600 group-hover:translate-x-1 transition-transform"></i>
                            </div>
                            <h4 class="font-bold text-gray-800 text-lg mb-1">All Requests</h4>
                            <p class="text-sm text-gray-600">View all package requests</p>
                        </a>

                        <!-- Pending Requests -->
                        <a href="{{ route('package-requests.index', ['status' => 'pending']) }}" 
                           class="group bg-gradient-to-br from-yellow-50 to-orange-50 hover:from-yellow-100 hover:to-orange-100 rounded-lg p-6 border-2 border-yellow-200 hover:border-yellow-400 transition-all duration-300 shadow-lg hover:shadow-2xl transform hover:scale-105">
                            <div class="flex items-center justify-between mb-3">
                                <div class="h-12 w-12 rounded-full bg-gradient-to-br from-yellow-500 to-orange-600 flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform">
                                    <i class="fas fa-clock text-white text-xl"></i>
                                </div>
                                <span class="px-3 py-1 bg-yellow-500 text-white text-xs font-bold rounded-full shadow">
                                    {{ $pendingPackageRequests->count() }}
                                </span>
                            </div>
                            <h4 class="font-bold text-gray-800 text-lg mb-1">Pending</h4>
                            <p class="text-sm text-gray-600">Awaiting review</p>
                        </a>

                        <!-- Approved Requests -->
                        <a href="{{ route('package-requests.index', ['status' => 'approved']) }}" 
                           class="group bg-gradient-to-br from-green-50 to-emerald-50 hover:from-green-100 hover:to-emerald-100 rounded-lg p-6 border-2 border-green-200 hover:border-green-400 transition-all duration-300 shadow-lg hover:shadow-2xl transform hover:scale-105">
                            <div class="flex items-center justify-between mb-3">
                                <div class="h-12 w-12 rounded-full bg-gradient-to-br from-green-500 to-emerald-600 flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform">
                                    <i class="fas fa-check-circle text-white text-xl"></i>
                                </div>
                                <i class="fas fa-arrow-right text-green-600 group-hover:translate-x-1 transition-transform"></i>
                            </div>
                            <h4 class="font-bold text-gray-800 text-lg mb-1">Approved</h4>
                            <p class="text-sm text-gray-600">Successfully approved</p>
                        </a>

                        <!-- Rejected Requests -->
                        <a href="{{ route('package-requests.index', ['status' => 'rejected']) }}" 
                           class="group bg-gradient-to-br from-red-50 to-rose-50 hover:from-red-100 hover:to-rose-100 rounded-lg p-6 border-2 border-red-200 hover:border-red-400 transition-all duration-300 shadow-lg hover:shadow-2xl transform hover:scale-105">
                            <div class="flex items-center justify-between mb-3">
                                <div class="h-12 w-12 rounded-full bg-gradient-to-br from-red-500 to-rose-600 flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform">
                                    <i class="fas fa-times-circle text-white text-xl"></i>
                                </div>
                                <i class="fas fa-arrow-right text-red-600 group-hover:translate-x-1 transition-transform"></i>
                            </div>
                            <h4 class="font-bold text-gray-800 text-lg mb-1">Rejected</h4>
                            <p class="text-sm text-gray-600">Declined requests</p>
                        </a>

                    </div>
                </div>
            </div>

            <!-- Pending Package Requests Section -->
            @if($pendingPackageRequests->count() > 0)
            <div class="bg-white shadow-2xl rounded-lg mb-6 border-2 border-orange-200">
                <div class="bg-gradient-to-r from-yellow-500 via-orange-500 to-red-500 px-6 py-4 rounded-t-lg">
                    <h3 class="font-semibold text-lg text-black flex items-center">
                        <i class="fas fa-clock mr-2"></i> Pending Package Requests
                        <span class="ml-2 px-3 py-1 bg-white text-orange-600 text-xs rounded-full font-bold shadow-lg">
                            {{ $pendingPackageRequests->count() }}
                        </span>
                    </h3>
                </div>
                <div class="p-6 bg-white">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gradient-to-r from-gray-50 to-gray-100">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">#</th>
                                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Customer</th>
                                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Package</th>
                                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Price</th>
                                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Requested</th>
                                    <th class="px-6 py-3 text-center text-xs font-bold text-gray-700 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($pendingPackageRequests as $request)
                                    <tr class="hover:bg-blue-50 transition duration-200">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">
                                            {{ $loop->iteration }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-10 w-10">
                                                    <div class="h-10 w-10 rounded-full bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center shadow">
                                                        <i class="fas fa-user text-white"></i>
                                                    </div>
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-bold text-gray-900">{{ $request->customer->name }}</div>
                                                    <div class="text-sm text-gray-600">{{ $request->customer->email }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full bg-gradient-to-r from-blue-500 to-blue-600 text-white shadow">
                                                {{ $request->package->name }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-blue-600">
                                            ৳{{ number_format($request->package->price) }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                            <i class="fas fa-calendar-alt mr-1 text-blue-500"></i>
                                            {{ $request->created_at->diffForHumans() }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                            <a href="{{ route('package-requests.show', $request->id) }}" 
                                               class="inline-flex items-center px-3 py-2 bg-gradient-to-r from-purple-600 via-pink-600 to-fuchsia-600 hover:from-purple-700 hover:via-pink-700 hover:to-fuchsia-700 text-black text-xs font-bold rounded-lg transition-all duration-300 shadow-xl hover:shadow-2xl transform hover:scale-110 hover:-translate-y-1 border-2 border-purple-300">
                                                <i class="fas fa-eye mr-1"></i> View Details
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-6 text-center">
                        <a href="{{ route('package-requests.index') }}" 
                           class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-700 hover:from-blue-700 hover:via-indigo-700 hover:to-purple-800 text-black text-sm font-bold rounded-lg transition-all duration-300 shadow-xl hover:shadow-2xl transform hover:scale-110 hover:-translate-y-1 border-2 border-blue-300">
                            <i class="fas fa-list mr-2"></i> View All Package Requests
                        </a>
                    </div>
                </div>
            </div>
            @endif

            <!-- Users Section -->
            <div class="bg-white shadow-2xl rounded-lg mb-6 border-2 border-blue-200">
                <div class="bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 px-6 py-4 rounded-t-lg">
                    <h3 class="font-semibold text-lg text-black flex items-center">
                        <i class="fas fa-user-shield mr-2"></i> Users (Admin Panel Access)
                        <span class="ml-2 px-3 py-1 bg-white text-blue-600 text-xs rounded-full font-bold shadow-lg">
                            {{ $users->count() }}
                        </span>
                    </h3>
                </div>
                <div class="p-6 bg-white">
                    @if($users->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gradient-to-r from-gray-50 to-gray-100">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">#</th>
                                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Name</th>
                                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Email</th>
                                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Package</th>
                                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Status</th>
                                        <th class="px-6 py-3 text-center text-xs font-bold text-gray-700 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($users as $user)
                                        <tr class="hover:bg-blue-50 transition duration-200">
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">
                                                {{ $loop->iteration }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-bold text-gray-900">{{ $user->name }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                                {{ $user->email }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                @if($user->detail)
                                                    <span class="px-3 py-1 bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-full text-xs font-semibold shadow">
                                                        {{ $user->detail->package_name }}
                                                    </span>
                                                @else
                                                    <span class="text-gray-400 font-medium">No Package</span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @if($user->detail)
                                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full shadow
                                                        {{ $user->detail->status === 'active' ? 'bg-gradient-to-r from-green-400 to-green-500 text-Black' : 'bg-gradient-to-r from-red-400 to-red-500 text-white' }}">
                                                        {{ ucfirst($user->detail->status) }}
                                                    </span>
                                                @else
                                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full bg-gradient-to-r from-gray-400 to-gray-500 text-white shadow">
                                                        Inactive
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                                <div class="flex items-center justify-center gap-2">
                                                    <a href="{{ route('users.show', $user->id) }}" 
                                                       class="inline-flex items-center px-3 py-2 bg-gradient-to-r from-purple-600 via-pink-600 to-fuchsia-600 hover:from-purple-700 hover:via-pink-700 hover:to-fuchsia-700 text-black text-xs font-bold rounded-lg transition-all duration-300 shadow-xl hover:shadow-2xl transform hover:scale-110 hover:-translate-y-1 border-2 border-purple-300">
                                                        <i class="fas fa-eye mr-1"></i> View
                                                    </a>
                                                    <a href="{{ route('users.edit', $user->id) }}" 
                                                       class="inline-flex items-center px-3 py-2 bg-gradient-to-r from-orange-600 via-amber-600 to-yellow-600 hover:from-orange-700 hover:via-amber-700 hover:to-yellow-700 text-black text-xs font-bold rounded-lg transition-all duration-300 shadow-xl hover:shadow-2xl transform hover:scale-110 hover:-translate-y-1 border-2 border-orange-300">
                                                        <i class="fas fa-edit mr-1"></i> Edit
                                                    </a>
                                                    <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this user? This action cannot be undone.');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" 
                                                                class="inline-flex items-center px-3 py-2 bg-gradient-to-r from-red-600 via-rose-600 to-pink-600 hover:from-red-700 hover:via-rose-700 hover:to-pink-700 text-black text-xs font-bold rounded-lg transition-all duration-300 shadow-xl hover:shadow-2xl transform hover:scale-110 hover:-translate-y-1 border-2 border-red-300">
                                                            <i class="fas fa-trash mr-1"></i> Delete
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-12">
                            <i class="fas fa-users text-gray-400 text-5xl mb-4"></i>
                            <p class="text-gray-500 font-medium">
                                @if($search)
                                    No users found matching "{{ $search }}"
                                @else
                                    No users found.
                                @endif
                            </p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Customers Section -->
            <div class="bg-white shadow-2xl rounded-lg border-2 border-green-200">
                <div class="bg-gradient-to-r from-green-600 via-emerald-600 to-teal-600 px-6 py-4 rounded-t-lg">
                    <h3 class="font-semibold text-lg text-black flex items-center">
                        <i class="fas fa-user-friends mr-2"></i> Customers (Customer Portal Access)
                        <span class="ml-2 px-3 py-1 bg-white text-green-600 text-xs rounded-full font-bold shadow-lg">
                            {{ $customers->count() }}
                        </span>
                    </h3>
                </div>
                <div class="p-6 bg-white">
                    @if($customers->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gradient-to-r from-gray-50 to-gray-100">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-bold text-white-700 uppercase tracking-wider">#</th>
                                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Name</th>
                                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Email</th>
                                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Phone</th>
                                        <th class="px-6 py-3 text-center text-xs font-bold text-gray-700 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($customers as $customer)
                                        <tr class="hover:bg-green-50 transition duration-200">
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">
                                                {{ $loop->iteration }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-bold text-gray-900">{{ $customer->name }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                                {{ $customer->email }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                                {{ $customer->phone }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                                <div class="flex items-center justify-center gap-2">
                                                    <a href="{{ route('customers.show', $customer->id) }}" 
                                                       class="inline-flex items-center px-3 py-2 bg-gradient-to-r from-cyan-600 via-sky-600 to-blue-600 hover:from-cyan-700 hover:via-sky-700 hover:to-blue-700 text-black text-xs font-bold rounded-lg transition-all duration-300 shadow-xl hover:shadow-2xl transform hover:scale-110 hover:-translate-y-1 border-2 border-cyan-300">
                                                        <i class="fas fa-eye mr-1"></i> View
                                                    </a>
                                                    <a href="{{ route('customers.edit', $customer->id) }}" 
                                                       class="inline-flex items-center px-3 py-2 bg-gradient-to-r from-amber-600 via-orange-600 to-red-600 hover:from-amber-700 hover:via-orange-700 hover:to-red-700 text-black text-xs font-bold rounded-lg transition-all duration-300 shadow-xl hover:shadow-2xl transform hover:scale-110 hover:-translate-y-1 border-2 border-amber-300">
                                                        <i class="fas fa-edit mr-1"></i> Edit
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-12">
                            <i class="fas fa-user-friends text-gray-400 text-5xl mb-4"></i>
                            <p class="text-gray-500 font-medium">
                                @if($search)
                                    No customers found matching "{{ $search }}"
                                @else
                                    No customers found.
                                @endif
                            </p>
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
</x-app-layout>