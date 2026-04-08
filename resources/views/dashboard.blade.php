<x-app-layout>
      <div class="py-6 min-h-screen bg-gradient-to-br from-indigo-50 via-purple-50 to-pink-50 dark:from-gray-950 dark:via-slate-950 dark:to-gray-950">
       <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Main Card -->
            <div class="bg-white/80 dark:bg-slate-900/80 backdrop-blur-xl shadow-2xl sm:rounded-3xl border border-white/20 dark:border-slate-800 overflow-hidden p-6 lg:p-8">

                <!-- Dashboard Header -->
                <div class="mb-10 pb-6 border-b-2 border-gradient-to-r from-indigo-200 via-purple-200 to-pink-200 dark:border-slate-700">
                    <h2 class="font-bold text-3xl bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600 bg-clip-text text-transparent">
                        Dashboard Overview
                    </h2>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">Monitor your business metrics in real-time</p>
                </div>

                <!-- Top Stats Cards -->
                <div class="grid grid-cols-1 sm:grid-cols-3 lg:grid-cols-4 gap-6 mb-10">
                    @php
                        $cards = [
                            ['label' => 'Total Bills', 'value' => $totalBills, 'gradient' => 'from-blue-500 via-blue-600 to-indigo-600', 'icon' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z', 'shadow' => 'shadow-blue-500/50'],
                            ['label' => 'Total Payments', 'value' => $totalPayments, 'gradient' => 'from-emerald-500 via-green-600 to-teal-600', 'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z', 'shadow' => 'shadow-emerald-500/50'],
                            ['label' => 'Bills This Month', 'value' => $billsThisMonth, 'gradient' => 'from-violet-500 via-purple-600 to-fuchsia-600', 'icon' => 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z', 'shadow' => 'shadow-violet-500/50'],
                            ['label' => 'Payments This Month', 'value' => $paymentsThisMonth, 'gradient' => 'from-orange-500 via-amber-600 to-yellow-600', 'icon' => 'M13 7h8m0 0v8m0-8l-8 8-4-4-6 6', 'shadow' => 'shadow-orange-500/50'],
                        ];
                    @endphp
                    @foreach($cards as $card)
                        <div class="group relative rounded-2xl p-6 bg-gradient-to-br {{ $card['gradient'] }} shadow-xl {{ $card['shadow'] }} hover:shadow-2xl hover:scale-105 transition-all duration-500 transform hover:-translate-y-1">
                            <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full -mr-16 -mt-16 group-hover:scale-150 transition-transform duration-700"></div>
                            <div class="relative">
                                <div class="flex items-center justify-between mb-4">
                                    <div class="p-3 bg-white/20 backdrop-blur-sm rounded-xl group-hover:bg-white/30 transition-all duration-300 group-hover:rotate-12 transform">
                                        <svg class="w-7 h-7 text-black drop-shadow-lg" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="{{ $card['icon'] }}"/>
                                        </svg>
                                    </div>
                                </div>
                                <h3 class="text-xl font-black text-black mb-2 drop-shadow-lg">{{ config('app.currency') . number_format($card['value'], 2) }}</h3>
                                <p class="text-sm text-black/90 font-semibold tracking-wide">{{ __($card['label']) }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Charts -->
                <div class="space-y-8 mb-10">
                    <div class="bg-white/90 dark:bg-slate-800/50 backdrop-blur-sm p-8 rounded-2xl border border-gray-100 dark:border-slate-700 shadow-xl hover:shadow-2xl transition-shadow duration-500">
                        <div class="flex items-center justify-between mb-6">
                            <div class="flex items-center gap-3">
                                <div class="p-2 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-lg">
                                    <svg class="w-5 h-5 text-black" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                                    </svg>
                                </div>
                                <h3 class="text-xl font-bold bg-gradient-to-r from-blue-600 to-blue-600 bg-clip-text text-transparent">{{ __('Monthly Billing & Payments') }}</h3>
                            </div>
                            <span class="text-xs font-medium text-gray-500 dark:text-gray-400 bg-gray-100 dark:bg-slate-700 px-4 py-2 rounded-full">Last 12 months</span>
                        </div>
                        <div style="height: 380px;">
                            <canvas id="monthlyChart"></canvas>
                        </div>
                    </div>
                    
                    <div class="bg-white/90 dark:bg-slate-800/50 backdrop-blur-sm p-8 rounded-2xl border border-gray-100 dark:border-slate-700 shadow-xl hover:shadow-2xl transition-shadow duration-500">
                        <div class="flex items-center justify-between mb-6">
                            <div class="flex items-center gap-3">
                                <div class="p-2 bg-gradient-to-br from-violet-500 to-purple-600 rounded-lg">
                                    <svg class="w-5 h-5 text-black" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 8v8m-4-5v5m-4-2v2m-2 4h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                                <h3 class="text-xl font-bold bg-gradient-to-r from-blue-600 to-blue-600 bg-clip-text text-transparent">{{ __('Daily Billing & Payments') }}</h3>
                            </div>
                            <span class="text-xs font-medium text-gray-500 dark:text-gray-400 bg-gray-100 dark:bg-slate-700 px-4 py-2 rounded-full">Last 30 days</span>
                        </div>
                        <div style="height: 380px;">
                            <canvas id="dailyChart"></canvas>
                        </div>
                    </div>
                </div>

                <!-- User Stats Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
                    <div class="group relative bg-gradient-to-br from-indigo-500 via-blue-600 to-cyan-600 p-6 rounded-2xl shadow-xl shadow-indigo-500/40 hover:shadow-2xl hover:scale-105 transition-all duration-500 transform hover:-translate-y-1 overflow-hidden">
                        <div class="absolute top-0 right-0 w-24 h-24 bg-white/10 rounded-full -mr-12 -mt-12 group-hover:scale-150 transition-transform duration-700"></div>
                        <div class="relative">
                            <div class="p-3 bg-white/20 backdrop-blur-sm rounded-xl inline-block mb-4 group-hover:bg-white/30 transition-all duration-300 group-hover:rotate-12 transform">
                                <svg class="w-8 h-8 text-black drop-shadow-lg" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                </svg>
                            </div>
                            <p class="text-4xl font-black text-black mb-2 drop-shadow-lg">{{ $totalUsers }}</p>
                            <p class="text-sm text-black/90 font-semibold tracking-wide">{{ __('Total Users') }}</p>
                        </div>
                    </div>
                    
                    <div class="group relative bg-gradient-to-br from-rose-500 via-red-600 to-pink-600 p-6 rounded-2xl shadow-xl shadow-rose-500/40 hover:shadow-2xl hover:scale-105 transition-all duration-500 transform hover:-translate-y-1 overflow-hidden">
                        <div class="absolute top-0 right-0 w-24 h-24 bg-white/10 rounded-full -mr-12 -mt-12 group-hover:scale-150 transition-transform duration-700"></div>
                        <div class="relative">
                            <div class="p-3 bg-white/20 backdrop-blur-sm rounded-xl inline-block mb-4 group-hover:bg-white/30 transition-all duration-300 group-hover:rotate-12 transform">
                                <svg class="w-8 h-8 text-black drop-shadow-lg" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                </svg>
                            </div>
                            <p class="text-4xl font-black text-black mb-2 drop-shadow-lg">{{ $usersWithDueCount }}</p>
                            <p class="text-sm text-black/90 font-semibold tracking-wide">{{ __('Users With Due') }}</p>
                        </div>
                    </div>
                    
                    <div class="group relative bg-gradient-to-br from-cyan-500 via-teal-600 to-emerald-600 p-6 rounded-2xl shadow-xl shadow-cyan-500/40 hover:shadow-2xl hover:scale-105 transition-all duration-500 transform hover:-translate-y-1 overflow-hidden">
                        <div class="absolute top-0 right-0 w-24 h-24 bg-white/10 rounded-full -mr-12 -mt-12 group-hover:scale-150 transition-transform duration-700"></div>
                        <div class="relative">
                            <div class="p-3 bg-white/20 backdrop-blur-sm rounded-xl inline-block mb-4 group-hover:bg-white/30 transition-all duration-300 group-hover:rotate-12 transform">
                                <svg class="w-8 h-8 text-black drop-shadow-lg" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 14l6-6m-5.5.5h.01m4.99 5h.01M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2z"/>
                                </svg>
                            </div>
                            <p class="text-4xl font-black text-black mb-2 drop-shadow-lg">{{ config('app.currency') . number_format($billsThisYear, 2) }}</p>
                            <p class="text-sm text-black/90 font-semibold tracking-wide">{{ __('Bills This Year') }}</p>
                        </div>
                    </div>
                    
                    <div class="group relative bg-gradient-to-br from-emerald-500 via-green-600 to-lime-600 p-6 rounded-2xl shadow-xl shadow-emerald-500/40 hover:shadow-2xl hover:scale-105 transition-all duration-500 transform hover:-translate-y-1 overflow-hidden">
                        <div class="absolute top-0 right-0 w-24 h-24 bg-white/10 rounded-full -mr-12 -mt-12 group-hover:scale-150 transition-transform duration-700"></div>
                        <div class="relative">
                            <div class="p-3 bg-white/20 backdrop-blur-sm rounded-xl inline-block mb-4 group-hover:bg-white/30 transition-all duration-300 group-hover:rotate-12 transform">
                                <svg class="w-8 h-8 text-black drop-shadow-lg" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <p class="text-4xl font-black text-black mb-2 drop-shadow-lg">{{ config('app.currency') . number_format($paymentsThisYear, 2) }}</p>
                            <p class="text-sm text-black/90 font-semibold tracking-wide">{{ __('Payments This Year') }}</p>
                        </div>
                    </div>
                </div>

                <!-- Tables Section -->
                <div class="space-y-8">

                    <!-- Recent Users & Recent Payments -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                        <div class="group bg-white/90 dark:bg-slate-800/50 backdrop-blur-sm rounded-2xl border border-gray-100 dark:border-slate-700 shadow-lg hover:shadow-2xl transition-all duration-500 overflow-hidden">
                            <div class="bg-gradient-to-r from-blue-500 to-indigo-600 px-6 py-5 border-b border-gray-200 dark:border-slate-700 flex items-center gap-3">
                                <div class="p-2 bg-white/20 backdrop-blur-sm rounded-lg">
                                    <svg class="w-5 h-5 text-black" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                                    </svg>
                                </div>
                                <h3 class="font-bold text-lg text-black drop-shadow">{{ __('Recent Users') }}</h3>
                            </div>
                            <div class="overflow-x-auto">
                                <table class="w-full">
                                    <thead>
                                    <tr class="bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-slate-800 dark:to-slate-800">
                                        <th class="px-6 py-4 text-left text-xs font-bold text-blue-700 dark:text-blue-300 uppercase tracking-wider">{{ __('Name') }}</th>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-blue-700 dark:text-blue-300 uppercase tracking-wider">{{ __('Package') }}</th>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-blue-700 dark:text-blue-300 uppercase tracking-wider">{{ __('Joined') }}</th>
                                    </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200 dark:divide-slate-700">
                                    @foreach ($recentUsers as $user)
                                        <tr class="hover:bg-blue-50 dark:hover:bg-slate-800/50 transition-colors duration-200">
                                            <td class="px-6 py-4 text-sm font-semibold text-gray-900 dark:text-black">{{ $user->name }}</td>
                                            <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">{{ $user->detail->package_name }}</td>
                                            <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">{{ date('Y-m-d', strtotime($user->created_at)) }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        
                        <div class="group bg-white/90 dark:bg-slate-800/50 backdrop-blur-sm rounded-2xl border border-gray-100 dark:border-slate-700 shadow-lg hover:shadow-2xl transition-all duration-500 overflow-hidden">
                            <div class="bg-gradient-to-r from-emerald-500 to-green-600 px-6 py-5 border-b border-gray-200 dark:border-slate-700 flex items-center gap-3">
                                <div class="p-2 bg-white/20 backdrop-blur-sm rounded-lg">
                                    <svg class="w-5 h-5 text-black" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                                    </svg>
                                </div>
                                <h3 class="font-bold text-lg text-black drop-shadow">{{ __('Recent Payments') }}</h3>
                            </div>
                            <div class="overflow-x-auto">
                                <table class="w-full">
                                    <thead>
                                    <tr class="bg-gradient-to-r from-emerald-50 to-green-50 dark:from-slate-800 dark:to-slate-800">
                                        <th class="px-6 py-4 text-left text-xs font-bold text-emerald-700 dark:text-emerald-300 uppercase tracking-wider">{{ __('User') }}</th>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-emerald-700 dark:text-emerald-300 uppercase tracking-wider">{{ __('Amount') }}</th>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-emerald-700 dark:text-emerald-300 uppercase tracking-wider">{{ __('Date') }}</th>
                                    </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200 dark:divide-slate-700">
                                    @foreach ($recentPayments as $payment)
                                        <tr class="hover:bg-emerald-50 dark:hover:bg-slate-800/50 transition-colors duration-200">
                                            <td class="px-6 py-4 text-sm font-semibold text-gray-900 dark:text-black">{{ $payment->user->name }}</td>
                                            <td class="px-6 py-4 text-sm font-bold text-emerald-600 dark:text-emerald-400">{{ config('app.currency') . number_format($payment->package_price, 2) }}</td>
                                            <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">{{ date('Y-m-d', strtotime($payment->created_at)) }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Users With Due & Recent Tickets -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                        <div class="group bg-white/90 dark:bg-slate-800/50 backdrop-blur-sm rounded-2xl border border-gray-100 dark:border-slate-700 shadow-lg hover:shadow-2xl transition-all duration-500 overflow-hidden">
                            <div class="bg-gradient-to-r from-rose-500 to-red-600 px-6 py-5 border-b border-gray-200 dark:border-slate-700 flex items-center gap-3">
                                <div class="p-2 bg-white/20 backdrop-blur-sm rounded-lg">
                                    <svg class="w-5 h-5 text-black" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                <h3 class="font-bold text-lg text-black drop-shadow">{{ __('Users With Due') }}</h3>
                            </div>
                            <div class="overflow-x-auto">
                                <table class="w-full">
                                    <thead>
                                    <tr class="bg-gradient-to-r from-rose-50 to-red-50 dark:from-slate-800 dark:to-slate-800">
                                        <th class="px-6 py-4 text-left text-xs font-bold text-rose-700 dark:text-rose-300 uppercase tracking-wider">{{ __('Name') }}</th>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-rose-700 dark:text-rose-300 uppercase tracking-wider">{{ __('Package') }}</th>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-rose-700 dark:text-rose-300 uppercase tracking-wider">{{ __('Due') }}</th>
                                    </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200 dark:divide-slate-700">
                                    @foreach ($usersWithDueList as $user)
                                        <tr class="hover:bg-rose-50 dark:hover:bg-slate-800/50 transition-colors duration-200">
                                            <td class="px-6 py-4 text-sm font-semibold text-gray-900 dark:text-black">{{ $user->name }}</td>
                                            <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">{{ $user->detail->package_name }}</td>
                                            <td class="px-6 py-4 text-sm font-bold text-rose-600 dark:text-rose-400">{{ config('app.currency') . number_format($user->due_amount($user->id), 2) }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        
                        <div class="group bg-white/90 dark:bg-slate-800/50 backdrop-blur-sm rounded-2xl border border-gray-100 dark:border-slate-700 shadow-lg hover:shadow-2xl transition-all duration-500 overflow-hidden">
                            <div class="bg-gradient-to-r from-violet-500 to-purple-600 px-6 py-5 border-b border-gray-200 dark:border-slate-700 flex items-center gap-3">
                                <div class="p-2 bg-white/20 backdrop-blur-sm rounded-lg">
                                    <svg class="w-5 h-5 text-black" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/>
                                    </svg>
                                </div>
                                <h3 class="font-bold text-lg text-black drop-shadow">{{ __('Recent Tickets') }}</h3>
                            </div>
                            <div class="overflow-x-auto">
                                <table class="w-full">
                                    <thead>
                                    <tr class="bg-gradient-to-r from-violet-50 to-purple-50 dark:from-slate-800 dark:to-slate-800">
                                        <th class="px-6 py-4 text-left text-xs font-bold text-violet-700 dark:text-violet-300 uppercase tracking-wider">{{ __('Subject') }}</th>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-violet-700 dark:text-violet-300 uppercase tracking-wider">{{ __('Status') }}</th>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-violet-700 dark:text-violet-300 uppercase tracking-wider">{{ __('Date') }}</th>
                                    </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200 dark:divide-slate-700">
                                    @foreach ($recentTickets as $ticket)
                                        <tr class="hover:bg-violet-50 dark:hover:bg-slate-800/50 transition-colors duration-200">
                                            <td class="px-6 py-4 text-sm font-semibold text-gray-900 dark:text-black">{{ $ticket->subject }}</td>
                                            <td class="px-6 py-4 text-sm">
                                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-gradient-to-r from-violet-100 to-purple-100 text-violet-800 dark:from-violet-900/30 dark:to-purple-900/30 dark:text-violet-300">
                                                    {{ $ticket->status }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">{{ date('Y-m-d', strtotime($ticket->created_at)) }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            const billingData = @json($billingData);
            const paymentData = @json($paymentData);
            const labels = Array.from({ length: billingData.length }, (_, i) => `Month ${i+1}`);

            const monthlyCtx = document.getElementById('monthlyChart').getContext('2d');
            new Chart(monthlyCtx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [
                        {
                            label: 'Billing Amount',
                            data: billingData,
                            backgroundColor: 'rgba(59, 130, 246, 0.85)',
                            borderColor: 'rgba(59, 130, 246, 1)',
                            borderWidth: 0,
                            borderRadius: 4,
                            barThickness: 28,
                            maxBarThickness: 32
                        },
                        {
                            label: 'Payment Amount',
                            data: paymentData,
                            backgroundColor: 'rgba(16, 185, 129, 0.85)',
                            borderColor: 'rgba(16, 185, 129, 1)',
                            borderWidth: 0,
                            borderRadius: 4,
                            barThickness: 28,
                            maxBarThickness: 32
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { 
                        legend: { 
                            position: 'top',
                            align: 'end',
                            labels: {
                                usePointStyle: true,
                                pointStyle: 'circle',
                                padding: 20,
                                font: { size: 12, weight: '500' },
                                color: '#64748b'
                            }
                        },
                        tooltip: {
                            backgroundColor: 'rgba(15, 23, 42, 0.95)',
                            padding: 12,
                            titleFont: { size: 13, weight: '600' },
                            bodyFont: { size: 12 },
                            cornerRadius: 6,
                            displayColors: true,
                            boxPadding: 6
                        }
                    },
                    animation: { 
                        duration: 800, 
                        easing: 'easeInOutQuart' 
                    },
                    scales: { 
                        y: { 
                            beginAtZero: true,
                            grid: { 
                                color: 'rgba(148, 163, 184, 0.1)',
                                drawBorder: false
                            },
                            border: { display: false },
                            ticks: { 
                                font: { size: 11 },
                                color: '#94a3b8',
                                padding: 8
                            }
                        },
                        x: {
                            grid: { display: false },
                            border: { display: false },
                            ticks: { 
                                font: { size: 11 },
                                color: '#94a3b8',
                                padding: 8
                            }
                        }
                    }
                }
            });

            const dailyBillingData = @json($dailyBillingData);
            const dailyPaymentData = @json($dailyPaymentData);
            const dailyLabels = Array.from({ length: dailyBillingData.length }, (_, i) => `Day ${i+1}`);

            const dailyCtx = document.getElementById('dailyChart').getContext('2d');
            new Chart(dailyCtx, {
                type: 'bar',
                data: {
                    labels: dailyLabels,
                    datasets: [
                        {
                            label: 'Daily Billing',
                            data: dailyBillingData,
                            backgroundColor: 'rgba(139, 92, 246, 0.85)',
                            borderColor: 'rgba(139, 92, 246, 1)',
                            borderWidth: 0,
                            borderRadius: 4,
                            barThickness: 20,
                            maxBarThickness: 24
                        },
                        {
                            label: 'Daily Payment',
                            data: dailyPaymentData,
                            backgroundColor: 'rgba(245, 158, 11, 0.85)',
                            borderColor: 'rgba(245, 158, 11, 1)',
                            borderWidth: 0,
                            borderRadius: 4,
                            barThickness: 20,
                            maxBarThickness: 24
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { 
                        legend: { 
                            position: 'top',
                            align: 'end',
                            labels: {
                                usePointStyle: true,
                                pointStyle: 'circle',
                                padding: 20,
                                font: { size: 12, weight: '500' },
                                color: '#64748b'
                            }
                        },
                        tooltip: {
                            backgroundColor: 'rgba(15, 23, 42, 0.95)',
                            padding: 12,
                            titleFont: { size: 13, weight: '600' },
                            bodyFont: { size: 12 },
                            cornerRadius: 6,
                            displayColors: true,
                            boxPadding: 6
                        }
                    },
                    animation: { 
                        duration: 800, 
                        easing: 'easeInOutQuart' 
                    },
                    scales: { 
                        y: { 
                            beginAtZero: true,
                            grid: { 
                                color: 'rgba(148, 163, 184, 0.1)',
                                drawBorder: false
                            },
                            border: { display: false },
                            ticks: { 
                                font: { size: 11 },
                                color: '#94a3b8',
                                padding: 8
                            }
                        },
                        x: {
                            grid: { display: false },
                            border: { display: false },
                            ticks: { 
                                font: { size: 11 },
                                color: '#94a3b8',
                                padding: 8
                            }
                        }
                    }
                }
            });
        </script>
    @endpush
</x-app-layout>