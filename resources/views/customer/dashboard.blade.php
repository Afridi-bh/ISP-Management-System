@extends('layouts.customer')

@section('title', 'Dashboard')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        {{-- Success Message --}}
        @if(session('success'))
            <div class="mb-4 rounded-md bg-green-50 border border-green-200 text-green-800 px-4 py-3">
                <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
            </div>
        @endif

        {{-- Header Stats --}}
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">
                <span style="color: #D12053;">Welcome Back, {{ $customer->name }}! 👋</span>
            </h1>
            <p class="text-gray-600 dark:text-gray-400 mt-1">
                @if($user && $detail)
                    You have {{ $totalDueBill > 0 ? '৳' . number_format($totalDueBill) . ' Due Bill' : 'No Due Bill' }}
                @else
                    <span class="text-yellow-600">No account information found. Please contact support.</span>
                @endif
            </p>
        </div>

        {{-- Quick Stats Grid --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
            <!-- Monthly Bill -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Monthly Bill</p>
                        <h3 class="text-2xl font-bold text-gray-900 dark:text-white mt-1">
                            ৳{{ number_format($monthlyBill) }}
                        </h3>
                        <p class="text-xs text-gray-500 mt-1">
                            <span class="{{ $detail ? 'text-green-600' : 'text-red-600' }}">
                                {{ $detail ? 'Current package' : 'No package' }}
                            </span>
                        </p>
                    </div>
                    <div class="p-3 bg-blue-100 rounded-full">
                        <i class="fas fa-file-invoice-dollar text-blue-600 text-xl"></i>
                    </div>
                </div>
            </div>

            <!-- Advance Amount -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Advance Amount</p>
                        <h3 class="text-2xl font-bold text-gray-900 dark:text-white mt-1">
                            ৳{{ number_format($advanceAmount, 2) }}
                        </h3>
                        <button class="mt-1 px-3 py-1 bg-blue-600 text-white text-xs rounded hover:bg-blue-700 transition">
                            Advance Pay
                        </button>
                    </div>
                    <div class="p-3 bg-green-100 rounded-full">
                        <i class="fas fa-money-bill-wave text-green-600 text-xl"></i>
                    </div>
                </div>
            </div>

            <!-- Total Due Bill -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Total Due Bill</p>
                        <h3 class="text-2xl font-bold {{ $totalDueBill > 0 ? 'text-red-600' : 'text-green-600' }} mt-1">
                            ৳{{ number_format($totalDueBill, 2) }}
                        </h3>
                        <p class="text-xs text-gray-500 mt-1">
                            <span class="{{ $totalDueBill > 0 ? 'text-red-600' : 'text-green-600' }}">
                                {{ $totalDueBill > 0 ? 'Pay now' : 'All clear!' }}
                            </span>
                        </p>
                    </div>
                    <div class="p-3 {{ $totalDueBill > 0 ? 'bg-red-100' : 'bg-green-100' }} rounded-full">
                        <i class="fas {{ $totalDueBill > 0 ? 'fa-exclamation-triangle text-red-600' : 'fa-check-circle text-green-600' }} text-xl"></i>
                    </div>
                </div>
            </div>

            <!-- My Package -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 dark:text-gray-400">My Package</p>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mt-1">
                            {{ $detail->package_name ?? 'No Package' }}
                        </h3>
                        <p class="text-xs text-gray-500 mt-1">
                            @if($detail && $detail->status)
                                <span class="{{ $detail->status === 'active' ? 'text-green-600' : 'text-red-600' }}">
                                    <i class="fas fa-wifi mr-1"></i>{{ ucfirst($detail->status) }}
                                </span>
                            @else
                                <span class="text-gray-500">
                                    <i class="fas fa-wifi-slash mr-1"></i>No service
                                </span>
                            @endif
                        </p>
                    </div>
                    <div class="p-3 bg-purple-100 rounded-full">
                        <i class="fas fa-box text-purple-600 text-xl"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Left Column (2/3 width) -->
            <div class="lg:col-span-2 space-y-6">
                
                <!-- Expire Date Calendar -->
                <div class="bg-gradient-to-br from-gray-900 to-gray-800 rounded-lg shadow p-6 text-white">
                    <h3 class="text-xl font-bold mb-4">
                        <i class="fas fa-calendar-alt mr-2"></i>Package Expiry Calendar
                    </h3>
                    
                    <div class="flex items-center justify-between mb-4">
                        <button class="text-white hover:text-gray-300 px-3 py-1 rounded hover:bg-gray-700 transition">
                            <i class="fas fa-chevron-left"></i>
                        </button>
                        <h4 class="text-lg font-semibold">{{ now()->format('F Y') }}</h4>
                        <button class="text-white hover:text-gray-300 px-3 py-1 rounded hover:bg-gray-700 transition">
                            <i class="fas fa-chevron-right"></i>
                        </button>
                    </div>
                    
                    <!-- Calendar Grid -->
                    <div class="mb-3">
                        <!-- Day Names -->
                        <div class="grid grid-cols-7 gap-2 text-center text-xs font-semibold mb-2">
                            <div class="text-gray-400">Sun</div>
                            <div class="text-gray-400">Mon</div>
                            <div class="text-gray-400">Tue</div>
                            <div class="text-gray-400">Wed</div>
                            <div class="text-gray-400">Thu</div>
                            <div class="text-gray-400">Fri</div>
                            <div class="text-gray-400">Sat</div>
                        </div>
                        
                        <!-- Calendar Days -->
                        <div class="grid grid-cols-7 gap-2 text-center">
                            @php
                                $now = now();
                                $expireDay = $packageExpireDate ? $packageExpireDate->day : null;
                                $today = $now->day;
                                $daysInMonth = $now->daysInMonth;
                                $firstDayOfMonth = $now->copy()->startOfMonth()->dayOfWeek;
                            @endphp
                            
                            {{-- Empty cells before first day --}}
                            @for ($i = 0; $i < $firstDayOfMonth; $i++)
                                <div class="p-2 text-gray-600"></div>
                            @endfor
                            
                            {{-- Days of the month --}}
                            @for ($day = 1; $day <= $daysInMonth; $day++)
                                @php
                                    $isToday = $day === $today;
                                    $isExpireDay = $day === $expireDay;
                                    $isPast = $day < $today;
                                @endphp
                                
                                <div class="p-2 rounded transition-all
                                    @if($isExpireDay)
                                        bg-red-600 font-bold ring-2 ring-red-400 animate-pulse
                                    @elseif($isToday)
                                        bg-blue-600 font-semibold ring-2 ring-blue-400
                                    @elseif($isPast)
                                        text-gray-500
                                    @else
                                        hover:bg-gray-700
                                    @endif
                                ">
                                    <div class="text-sm">{{ $day }}</div>
                                    @if($isExpireDay)
                                        <div class="text-xs mt-1">
                                            <i class="fas fa-exclamation-triangle"></i>
                                        </div>
                                    @endif
                                </div>
                            @endfor
                        </div>
                    </div>
                    
                    <!-- Expiry Info -->
                    @if($packageExpireDate)
                        <div class="mt-4 p-3 bg-red-600 bg-opacity-20 rounded border border-red-500">
                            <p class="text-sm">
                                <i class="fas fa-calendar-times mr-2"></i>
                                Your package expires on <strong>{{ $packageExpireDate->format('F d, Y') }}</strong>
                                @if($daysUntilExpiry > 0)
                                    (<span class="font-semibold">{{ $daysUntilExpiry }} days remaining</span>)
                                @else
                                    <span class="text-red-400 font-semibold">(Expired)</span>
                                @endif
                            </p>
                        </div>
                    @else
                        <div class="mt-4 p-3 bg-yellow-600 bg-opacity-20 rounded border border-yellow-500">
                            <p class="text-sm">
                                <i class="fas fa-info-circle mr-2"></i>
                                No active package. Please subscribe to a package to start service.
                            </p>
                        </div>
                    @endif
                    
                    <!-- Calendar Legend -->
                    <div class="mt-4 flex flex-wrap gap-4 text-xs">
                        <div class="flex items-center">
                            <div class="w-3 h-3 bg-blue-600 rounded mr-2"></div>
                            <span>Today</span>
                        </div>
                        <div class="flex items-center">
                            <div class="w-3 h-3 bg-red-600 rounded mr-2"></div>
                            <span>Expiry Date</span>
                        </div>
                        <div class="flex items-center">
                            <div class="w-3 h-3 bg-gray-700 rounded mr-2"></div>
                            <span>Regular Day</span>
                        </div>
                    </div>
                </div>

                <!-- Real-Time Internet Speed -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white">
                            <i class="fas fa-tachometer-alt text-blue-600 mr-2"></i>
                            Real-Time Internet Speed
                        </h3>
                        <div class="flex items-center gap-4">
                            <div class="flex items-center">
                                <div class="w-3 h-3 bg-cyan-500 rounded-full mr-2"></div>
                                <span class="text-sm text-gray-600 dark:text-gray-400">Download</span>
                            </div>
                            <div class="flex items-center">
                                <div class="w-3 h-3 bg-purple-500 rounded-full mr-2"></div>
                                <span class="text-sm text-gray-600 dark:text-gray-400">Upload</span>
                            </div>
                        </div>
                    </div>
                    
                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">
                        <i class="fas fa-info-circle mr-1"></i>
                        Simulated speed updates every 2 seconds (Demo data)
                    </p>
                    
                    <!-- Current Speed Display -->
                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div class="text-center p-4 bg-cyan-50 dark:bg-cyan-900 dark:bg-opacity-20 rounded-lg">
                            <p class="text-sm text-gray-600 dark:text-gray-400">Download Speed</p>
                            <p class="text-3xl font-bold text-cyan-600" id="currentDownload">
                                {{ number_format($networkSpeed['current_download'], 1) }}
                            </p>
                            <p class="text-xs text-gray-500">Mbps</p>
                        </div>
                        <div class="text-center p-4 bg-purple-50 dark:bg-purple-900 dark:bg-opacity-20 rounded-lg">
                            <p class="text-sm text-gray-600 dark:text-gray-400">Upload Speed</p>
                            <p class="text-3xl font-bold text-purple-600" id="currentUpload">
                                {{ number_format($networkSpeed['current_upload'], 1) }}
                            </p>
                            <p class="text-xs text-gray-500">Mbps</p>
                        </div>
                    </div>
                    
                    <!-- Speed Chart -->
                    <div class="relative" style="height: 300px;">
                        <canvas id="speedChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Right Column (1/3 width) -->
            <div class="space-y-6">
                
                <!-- Package Upgrade Card -->
                <div class="bg-gradient-to-br from-purple-600 to-blue-600 rounded-lg shadow p-6 text-white">
                    <div class="text-center mb-4">
                        <i class="fas fa-rocket text-4xl mb-3 opacity-90"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-2 text-center">
                        Choose the Best Package
                    </h3>
                    <p class="text-sm text-purple-100 mb-4 text-center">
                        Upgrade or downgrade anytime to enjoy the best internet experience
                    </p>
                    <a href="{{ route('customer.subscriptions') }}" 
                       class="block w-full text-center py-3 bg-white text-purple-600 font-semibold rounded-lg hover:bg-purple-50 transition">
                        <i class="fas fa-arrow-up mr-2"></i>View Packages
                    </a>
                </div>

                <!-- Quick Actions -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                    <h3 class="font-bold text-gray-900 dark:text-white mb-4">
                        <i class="fas fa-bolt text-yellow-500 mr-2"></i>Quick Actions
                    </h3>
                    <div class="space-y-2">
                        <a href="{{ route('customer.payments') }}" 
                           class="flex items-center justify-center w-full px-4 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                            <i class="fas fa-credit-card mr-2"></i>Make Payment
                        </a>
                        <a href="{{ route('customer.subscriptions') }}" 
                           class="flex items-center justify-center w-full px-4 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                            <i class="fas fa-box mr-2"></i>View Packages
                        </a>
                        <a href="{{ route('customer.tickets.index') }}" 
                           class="flex items-center justify-center w-full px-4 py-3 bg-orange-600 text-white rounded-lg hover:bg-orange-700 transition">
                            <i class="fas fa-headset mr-2"></i>Get Support
                        </a>
                    </div>
                </div>

                <!-- Usage Summary -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                    <h3 class="font-bold text-gray-900 dark:text-white mb-4">
                        <i class="fas fa-chart-pie text-green-600 mr-2"></i>Usage Summary
                    </h3>
                    <div>
                        <div class="flex justify-between text-sm text-gray-600 dark:text-gray-400 mb-2">
                            <span>Data Usage (Demo)</span>
                            <span class="font-semibold">
                                {{ number_format($usage->download + $usage->upload, 2) }} GB / {{ $usage->quota }} GB
                            </span>
                        </div>
                        <div class="w-full h-3 bg-gray-200 dark:bg-gray-700 rounded-full overflow-hidden">
                            <div class="h-full rounded-full transition-all duration-300
                                @if($usagePercent < 50) bg-green-500
                                @elseif($usagePercent < 80) bg-yellow-500
                                @else bg-red-500
                                @endif" 
                                 style="width: {{ $usagePercent }}%"></div>
                        </div>

                        <div class="grid grid-cols-2 gap-3 mt-4">
                            <div class="p-3 bg-gray-50 dark:bg-gray-700 rounded-lg text-center">
                                <p class="text-xs text-gray-600 dark:text-gray-400">Download</p>
                                <p class="text-lg font-bold text-gray-900 dark:text-white">
                                    {{ number_format($usage->download, 2) }} GB
                                </p>
                            </div>
                            <div class="p-3 bg-gray-50 dark:bg-gray-700 rounded-lg text-center">
                                <p class="text-xs text-gray-600 dark:text-gray-400">Upload</p>
                                <p class="text-lg font-bold text-gray-900 dark:text-white">
                                    {{ number_format($usage->upload, 2) }} GB
                                </p>
                            </div>
                        </div>
                        
                        @if($usage->quota > 0)
                            <p class="text-xs text-center text-gray-500 dark:text-gray-400 mt-3">
                                {{ number_format($usage->quota - ($usage->download + $usage->upload), 2) }} GB remaining this month
                            </p>
                        @endif
                    </div>
                </div>

                <!-- Notifications -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                    <h3 class="font-bold text-gray-900 dark:text-white mb-4">
                        <i class="fas fa-bell text-red-600 mr-2"></i>Notifications
                        @if($notifications->count() > 0)
                            <span class="ml-2 px-2 py-1 bg-red-600 text-white text-xs rounded-full">
                                {{ $notifications->count() }}
                            </span>
                        @endif
                    </h3>
                    <div class="space-y-3 max-h-96 overflow-y-auto">
                        @forelse($notifications as $note)
                            <div class="p-3 
                                @if($note->type === 'danger') bg-red-50 dark:bg-red-900 dark:bg-opacity-20 border border-red-200
                                @elseif($note->type === 'warning') bg-yellow-50 dark:bg-yellow-900 dark:bg-opacity-20 border border-yellow-200
                                @elseif($note->type === 'success') bg-green-50 dark:bg-green-900 dark:bg-opacity-20 border border-green-200
                                @else bg-blue-50 dark:bg-blue-900 dark:bg-opacity-20 border border-blue-200
                                @endif
                                rounded-lg">
                                <div class="flex justify-between items-start">
                                    <div class="flex items-start gap-2 flex-1">
                                        <i class="fas 
                                            @if($note->type === 'danger') fa-times-circle text-red-600
                                            @elseif($note->type === 'warning') fa-exclamation-circle text-yellow-600
                                            @elseif($note->type === 'success') fa-check-circle text-green-600
                                            @else fa-info-circle text-blue-600
                                            @endif mt-1"></i>
                                        <div class="flex-1">
                                            <p class="font-semibold text-sm 
                                                @if($note->type === 'danger') text-red-900 dark:text-red-100
                                                @elseif($note->type === 'warning') text-yellow-900 dark:text-yellow-100
                                                @elseif($note->type === 'success') text-green-900 dark:text-green-100
                                                @else text-blue-900 dark:text-blue-100
                                                @endif">
                                                {{ $note->title }}
                                            </p>
                                            <p class="text-xs mt-1
                                                @if($note->type === 'danger') text-red-700 dark:text-red-200
                                                @elseif($note->type === 'warning') text-yellow-700 dark:text-yellow-200
                                                @elseif($note->type === 'success') text-green-700 dark:text-green-200
                                                @else text-blue-700 dark:text-blue-200
                                                @endif">
                                                {{ $note->message }}
                                            </p>
                                            
                                            {{-- Show Package Name if it's a package request notification --}}
                                            @if(isset($note->package_name))
                                                <div class="mt-2 pt-2 border-t 
                                                    @if($note->type === 'danger') border-red-200
                                                    @elseif($note->type === 'success') border-green-200
                                                    @elseif($note->type === 'info') border-blue-200
                                                    @endif">
                                                    <p class="text-xs font-semibold
                                                        @if($note->type === 'danger') text-red-800 dark:text-red-100
                                                        @elseif($note->type === 'success') text-green-800 dark:text-green-100
                                                        @elseif($note->type === 'info') text-blue-800 dark:text-blue-100
                                                        @endif">
                                                        <i class="fas fa-box mr-1"></i>Package: {{ $note->package_name }}
                                                    </p>
                                                    
                                                    {{-- Show Admin Remarks if available --}}
                                                    @if(isset($note->admin_remarks) && $note->admin_remarks)
                                                        <div class="mt-2 p-2 rounded
                                                            @if($note->type === 'danger') bg-red-100 dark:bg-red-800 dark:bg-opacity-30
                                                            @elseif($note->type === 'success') bg-green-100 dark:bg-green-800 dark:bg-opacity-30
                                                            @elseif($note->type === 'info') bg-blue-100 dark:bg-blue-800 dark:bg-opacity-30
                                                            @endif">
                                                            <p class="text-xs font-medium
                                                                @if($note->type === 'danger') text-red-900 dark:text-red-100
                                                                @elseif($note->type === 'success') text-green-900 dark:text-green-100
                                                                @elseif($note->type === 'info') text-blue-900 dark:text-blue-100
                                                                @endif">
                                                                <i class="fas fa-user-shield mr-1"></i>Admin Remarks:
                                                            </p>
                                                            <p class="text-xs mt-1
                                                                @if($note->type === 'danger') text-red-800 dark:text-red-200
                                                                @elseif($note->type === 'success') text-green-800 dark:text-green-200
                                                                @elseif($note->type === 'info') text-blue-800 dark:text-blue-200
                                                                @endif">
                                                                "{{ $note->admin_remarks }}"
                                                            </p>
                                                        </div>
                                                    @endif
                                                    
                                                    {{-- Action Button --}}
                                                    <div class="mt-2">
                                                        <a href="{{ route('customer.package-requests.index') }}" 
                                                           class="inline-flex items-center text-xs font-semibold
                                                            @if($note->type === 'success') text-green-700 hover:text-green-800
                                                            @elseif($note->type === 'info') text-blue-700 hover:text-blue-800
                                                            @else text-red-700 hover:text-red-800
                                                            @endif">
                                                            View Details <i class="fas fa-arrow-right ml-1 text-xs"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <span class="text-xs text-gray-500 dark:text-gray-400 whitespace-nowrap ml-2">
                                        {{ $note->created_at->diffForHumans() }}
                                    </span>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-8">
                                <i class="fas fa-bell-slash text-gray-400 text-3xl mb-2"></i>
                                <p class="text-sm text-gray-500 dark:text-gray-400">No notifications</p>
                            </div>
                        @endforelse
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
<script>
    // Network Speed Chart
    const speedCtx = document.getElementById('speedChart').getContext('2d');
    const networkData = @json($networkSpeed);
    
    const speedChart = new Chart(speedCtx, {
        type: 'line',
        data: {
            labels: networkData.timestamps,
            datasets: [
                {
                    label: 'Download Speed (Mbps)',
                    data: networkData.data.map(d => d.download),
                    borderColor: 'rgb(6, 182, 212)',
                    backgroundColor: 'rgba(6, 182, 212, 0.1)',
                    fill: true,
                    tension: 0.4,
                    borderWidth: 2,
                    pointRadius: 0,
                    pointHoverRadius: 4,
                },
                {
                    label: 'Upload Speed (Mbps)',
                    data: networkData.data.map(d => d.upload),
                    borderColor: 'rgb(168, 85, 247)',
                    backgroundColor: 'rgba(168, 85, 247, 0.1)',
                    fill: true,
                    tension: 0.4,
                    borderWidth: 2,
                    pointRadius: 0,
                    pointHoverRadius: 4,
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    mode: 'index',
                    intersect: false,
                    callbacks: {
                        label: function(context) {
                            return context.dataset.label + ': ' + context.parsed.y.toFixed(1) + ' Mbps';
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    max: networkData.max_speed,
                    ticks: {
                        callback: function(value) {
                            return value + ' Mbps';
                        },
                        color: '#6B7280'
                    },
                    grid: {
                        color: 'rgba(0, 0, 0, 0.05)'
                    }
                },
                x: {
                    display: true,
                    ticks: {
                        color: '#6B7280',
                        maxTicksLimit: 10
                    },
                    grid: {
                        color: 'rgba(0, 0, 0, 0.05)'
                    }
                }
            },
            interaction: {
                mode: 'nearest',
                axis: 'x',
                intersect: false
            }
        }
    });

    // Simulate real-time speed updates (DUMMY DATA)
    setInterval(() => {
        const maxSpeed = networkData.max_speed;
        
        // Generate random speeds with variation
        const newDownload = (maxSpeed * (Math.random() * 0.35 + 0.60)).toFixed(1);
        const newUpload = ((maxSpeed * 0.25) * (Math.random() * 0.40 + 0.50)).toFixed(1);
        
        // Update display
        document.getElementById('currentDownload').textContent = newDownload;
        document.getElementById('currentUpload').textContent = newUpload;
        
        // Update chart - remove oldest, add newest
        const now = new Date();
        const timeString = now.toTimeString().split(' ')[0];
        
        speedChart.data.labels.shift();
        speedChart.data.labels.push(timeString);
        
        speedChart.data.datasets[0].data.shift();
        speedChart.data.datasets[0].data.push(parseFloat(newDownload));
        
        speedChart.data.datasets[1].data.shift();
        speedChart.data.datasets[1].data.push(parseFloat(newUpload));
        
        speedChart.update('none'); // Update without animation for smooth real-time feel
    }, 2000); // Update every 2 seconds
</script>
@endpush
@endsection