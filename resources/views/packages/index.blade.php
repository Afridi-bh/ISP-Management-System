<x-app-layout>
    <div class="py-6">
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if(session('success'))
                        <div class="alert alert-success text-green-600 bg-green-50 border border-green-200 rounded-lg p-4 mb-4">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger text-red-600 bg-red-50 border border-red-200 rounded-lg p-4 mb-4">
                            {{ session('error') }}
                        </div>
                    @endif

                    <!-- Packages Table Section -->
                    <div class="flex justify-between items-center mb-6 border-b-2 border-slate-100 pb-4">
                        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                            {{ __('Packages') }}
                        </h2>
                        @if (auth()->user()->isAdmin())
                            <x-create-button url="{{ route('packages.create') }}"></x-create-button>
                        @endif
                    </div>

                    <div>
                        @if (auth()->user()->isAdmin())
                            <livewire:package-table/>
                        @endif
                        @if (auth()->user()->isUser())
                            <livewire:user-package-table/>
                        @endif
                    </div>

                    <!-- Package-wise User Details Section (Admin Only) -->
                    @if (auth()->user()->isAdmin() && isset($packageUsers) && $packageUsers !== null)
                        <div class="mt-10">
                            <div class="flex justify-between items-center mb-6 border-b-2 border-indigo-500 pb-4">
                                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                                    {{ __('Package-wise User Details') }}
                                </h2>
                            </div>

                            <!-- Date Range Filter -->
                            <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl shadow-md p-6 mb-8 border border-blue-200">
                                <form method="GET" action="{{ route('packages.index') }}" class="space-y-4">
                                    <div class="flex items-center gap-2 mb-3">
                                        <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                        </svg>
                                        <h3 class="text-lg font-semibold text-gray-800">{{ __('Search by Package Start Date') }}</h3>
                                    </div>
                                    
                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
                                        <div>
                                            <label for="from_date" class="block text-sm font-medium text-gray-700 mb-2">
                                                {{ __('From Date') }}
                                            </label>
                                            <input 
                                                type="date" 
                                                id="from_date" 
                                                name="from_date" 
                                                value="{{ $fromDate ?? '' }}"
                                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all"
                                            >
                                        </div>
                                        
                                        <div>
                                            <label for="to_date" class="block text-sm font-medium text-gray-700 mb-2">
                                                {{ __('To Date') }}
                                            </label>
                                            <input 
                                                type="date" 
                                                id="to_date" 
                                                name="to_date" 
                                                value="{{ $toDate ?? '' }}"
                                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all"
                                            >
                                        </div>
                                        
                                        <div class="flex gap-2">
                                            <button 
                                                type="submit" 
                                                class="flex-1 bg-gradient-to-r from-indigo-600 to-blue-600 hover:from-indigo-700 hover:to-blue-700 text-white font-semibold py-2.5 px-6 rounded-lg shadow-md hover:shadow-lg transition-all duration-200 flex items-center justify-center gap-2"
                                            >
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                                </svg>
                                                {{ __('Search') }}
                                            </button>
                                            
                                            <a 
                                                href="{{ route('packages.index') }}" 
                                                class="bg-gray-500 hover:bg-gray-600 text-white font-semibold py-2.5 px-6 rounded-lg shadow-md hover:shadow-lg transition-all duration-200 flex items-center justify-center gap-2"
                                            >
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                                </svg>
                                                {{ __('Clear') }}
                                            </a>
                                        </div>
                                    </div>
                                    
                                    @if($fromDate || $toDate)
                                        <div class="mt-3 p-3 bg-indigo-100 border border-indigo-300 rounded-lg">
                                            <p class="text-sm text-indigo-800 font-medium">
                                                <svg class="w-4 h-4 inline mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                                                </svg>
                                                {{ __('Showing results') }}
                                                @if($fromDate && $toDate)
                                                    {{ __('from') }} <strong>{{ $fromDate }}</strong> {{ __('to') }} <strong>{{ $toDate }}</strong>
                                                @elseif($fromDate)
                                                    {{ __('from') }} <strong>{{ $fromDate }}</strong> {{ __('onwards') }}
                                                @else
                                                    {{ __('up to') }} <strong>{{ $toDate }}</strong>
                                                @endif
                                            </p>
                                        </div>
                                    @endif
                                </form>
                            </div>

                            <!-- Package Statistics Cards -->
                            @if(isset($packageStats) && $packageStats->count() > 0)
                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 mb-8">
                                    @foreach($packageStats as $stat)
                                        <div class="bg-gradient-to-br from-blue-500 to-purple-500 rounded-xl shadow-lg p-4 text-black hover:scale-105 transition-transform duration-200">
                                            <h3 class="text-lg font-bold mb-2 truncate">{{ $stat->name }}</h3>
                                            <div class="space-y-1 text-sm">
                                                <p class="flex justify-between">
                                                    <span>Price:</span>
                                                    <span class="font-semibold">{{ config('app.currency') }}{{ $stat->price }}</span>
                                                </p>
                                                <p class="flex justify-between">
                                                    <span>Total Users:</span>
                                                    <span class="font-semibold">{{ $stat->total_users }}</span>
                                                </p>
                                                <p class="flex justify-between">
                                                    <span>Active:</span>
                                                    <span class="font-semibold">{{ $stat->active_users }}</span>
                                                </p>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif

                            <!-- Detailed Package-wise User Tables -->
                            <div class="space-y-8">
                                @forelse($packageUsers as $packageName => $users)
                                    <div class="bg-white border border-gray-200 rounded-lg shadow-md overflow-hidden">
                                        <!-- Package Header -->
                                        <div class="bg-gradient-to-r from-blue-600 to-purple-600 text-white px-6 py-4">
                                            <div class="flex justify-between items-center">
                                                <h3 class="text-lg font-bold">{{ $packageName }}</h3>
                                                <span class="bg-white/20 backdrop-blur-sm px-3 py-1 rounded-full text-sm font-semibold">
                                                    {{ $users->count() }} {{ $users->count() == 1 ? 'User' : 'Users' }}
                                                </span>
                                            </div>
                                        </div>

                                        <!-- Users Table -->
                                        <div class="overflow-x-auto">
                                            <table class="min-w-full divide-y divide-gray-200">
                                                <thead class="bg-gray-50">
                                                    <tr>
                                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                            User Name
                                                        </th>
                                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                            Email
                                                        </th>
                                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                            Phone
                                                        </th>
                                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                            Address
                                                        </th>
                                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                            Package Start
                                                        </th>
                                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                            Due Amount
                                                        </th>
                                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                            Status
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody class="bg-white divide-y divide-gray-200">
                                                    @foreach($users as $user)
                                                        <tr class="hover:bg-gray-50 transition-colors">
                                                            <td class="px-6 py-4 whitespace-nowrap">
                                                                <div class="flex items-center">
                                                                    <div class="flex-shrink-0 h-10 w-10">
                                                                        <div class="h-10 w-10 rounded-full bg-gradient-to-br from-indigo-400 to-purple-500 flex items-center justify-center text-white font-bold">
                                                                            {{ substr($user->user_name, 0, 1) }}
                                                                        </div>
                                                                    </div>
                                                                    <div class="ml-4">
                                                                        <div class="text-sm font-medium text-gray-900">
                                                                            {{ $user->user_name }}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                                {{ $user->user_email }}
                                                            </td>
                                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                                {{ $user->phone ?? 'N/A' }}
                                                            </td>
                                                            <td class="px-6 py-4 text-sm text-gray-500 max-w-xs truncate">
                                                                {{ $user->address ?? 'N/A' }}
                                                            </td>
                                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                                {{ $user->package_start ? \Carbon\Carbon::parse($user->package_start)->format('Y-m-d') : 'N/A' }}
                                                            </td>
                                                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $user->due > 0 ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800' }}">
                                                                    {{ config('app.currency') }}{{ $user->due ?? 0 }}
                                                                </span>
                                                            </td>
                                                            <td class="px-6 py-4 whitespace-nowrap">
                                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $user->status == 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                                    {{ ucfirst($user->status ?? 'inactive') }}
                                                                </span>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                @empty
                                    <div class="text-center py-12 bg-gray-50 rounded-lg border-2 border-dashed border-gray-300">
                                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                        </svg>
                                        <h3 class="mt-2 text-sm font-medium text-gray-900">No users found</h3>
                                        <p class="mt-1 text-sm text-gray-500">
                                            @if($fromDate || $toDate)
                                                No users found for the selected date range.
                                            @else
                                                No users are assigned to any packages yet.
                                            @endif
                                        </p>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>