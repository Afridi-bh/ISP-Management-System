<div class="w-64 min-h-screen hidden md:flex flex-col shadow-2xl relative overflow-hidden" style="background-color: #D12053;">

    <!-- Animated Header -->
    <div class="relative z-20 px-6 py-6 border-b border-white/10 bg-gradient-to-r from-pink-600/20 via-[#D12053] to-purple-600/20">
        <div class="flex flex-col items-center justify-center">
            <!-- Animated Logo -->
            <div class="relative mb-3">
                <!-- Outer Glow -->
                <div class="absolute -inset-4 bg-gradient-to-r from-blue-400 via-purple-500 to-pink-500 rounded-full blur-xl opacity-60 animate-pulse"></div>
                
                <!-- Main Logo Container -->
                <div class="relative w-14 h-14 bg-gradient-to-br from-white via-gray-100 to-gray-200 rounded-xl flex items-center justify-center shadow-2xl 
                          transform hover:scale-110 hover:rotate-6 transition-all duration-300 group cursor-pointer">
                    <!-- Inner Logo -->
                    <div class="absolute inset-0 bg-gradient-to-br from-blue-400 via-purple-500 to-pink-500 rounded-xl opacity-0 group-hover:opacity-20 transition-opacity duration-300"></div>
                    <i class="fa-solid fa-bolt text-2xl text-[#D12053] relative z-10 animate-bounce-slow"></i>
                    
                    <!-- Animated Ring -->
                    <div class="absolute -inset-2 border-2 border-transparent border-t-blue-400 border-r-purple-500 border-b-pink-500 border-l-cyan-400 rounded-xl animate-spin-slow opacity-70"></div>
                </div>
            </div>
            
            <!-- App Title with Gradient -->
            <div class="text-center">
                <h1 class="text-2xl font-bold bg-gradient-to-r from-yellow-300 via-cyan-300 to-pink-300 bg-clip-text text-transparent 
                          animate-gradient-x">
                    ISP Billing
                </h1>
              
            </div>
        </div>
        
        <!-- Animated IP Address Display -->
        <div class>
            <div class="flex items-center justify-between">
               
                <div class="flex items-center space-x-0">
                    
                    
                </div>
            </div>
        </div>
    </div>

    <!-- Glowing Background Blobs -->
    <div class="absolute inset-0 opacity-15">
        <div class="absolute top-16 left-8 w-32 h-32 bg-blue-300/20 rounded-full blur-3xl animate-blob"></div>
        <div class="absolute bottom-20 right-10 w-28 h-28 bg-purple-300/20 rounded-full blur-3xl animate-blob animation-delay-2000"></div>
        <div class="absolute top-1/2 left-1/2 w-28 h-28 bg-cyan-300/20 rounded-full blur-3xl animate-blob animation-delay-4000"></div>
    </div>

    <!-- Floating Animation Elements -->
    <div class="absolute inset-0 pointer-events-none overflow-hidden">
        <!-- Floating Dots -->
        <div class="absolute top-20 right-6 w-2 h-2 bg-yellow-300/40 rounded-full animate-float animation-delay-0"></div>
        <div class="absolute top-40 left-4 w-1.5 h-1.5 bg-cyan-300/40 rounded-full animate-float animation-delay-1500"></div>
        <div class="absolute bottom-32 right-8 w-1 h-1 bg-purple-300/40 rounded-full animate-float animation-delay-3000"></div>
        <div class="absolute top-2/3 left-8 w-2 h-2 bg-pink-300/40 rounded-full animate-float animation-delay-1000"></div>
    </div>

    <!-- Navigation -->
    <nav class="relative z-10 flex-1 pt-4 px-3 space-y-2 overflow-y-auto custom-scrollbar">
        
        <!-- DASHBOARD -->
        <x-sidebar-item :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="group">
            <div class="sidebar-btn {{ request()->routeIs('dashboard') ? 'active-dashboard' : 'hover:bg-white/10' }} 
                  transform transition-all duration-300 relative overflow-hidden">
                
                <!-- Active Indicator Bar -->
                <div class="absolute left-0 top-1/2 -translate-y-1/2 w-1 h-8 bg-gradient-to-b from-blue-400 to-cyan-400 rounded-r-full 
                      {{ request()->routeIs('dashboard') ? 'opacity-100' : 'opacity-0 group-hover:opacity-70' }} 
                      transition-opacity duration-300"></div>
                
                <!-- Icon with Glow -->
                <div class="relative ml-1">
                    <i class="fa-solid fa-chart-line text-lg {{ request()->routeIs('dashboard') ? 'text-blue-300' : 'text-white/90' }}
                          group-hover:text-blue-300 transition-colors duration-300"></i>
                    <!-- Icon Glow Effect -->
                    <div class="absolute -inset-2 bg-blue-500/20 rounded-full blur-md opacity-0 
                          {{ request()->routeIs('dashboard') ? 'opacity-100' : 'group-hover:opacity-50' }} 
                          transition-opacity duration-300"></div>
                </div>
                
                <!-- Text with Better Contrast -->
                <span class="font-medium ml-3 {{ request()->routeIs('dashboard') ? 'text-blue-100 font-bold' : 'text-white/95' }}
                      group-hover:text-blue-100 transition-colors duration-300">
                    {{ __('Dashboard') }}
                </span>
                
                <!-- Animated Arrow -->
                <i class="fa-solid fa-chevron-right text-xs ml-auto arrow-hover transform transition-all duration-300
                      {{ request()->routeIs('dashboard') ? 'text-blue-300 translate-x-0 opacity-100' : 'text-white/70' }}"></i>
                
                <!-- Rounded Rectangle Background -->
                <div class="absolute inset-0 rounded-xl bg-gradient-to-r from-blue-600/30 via-blue-500/25 to-blue-400/20 
                      border-2 border-blue-400/30 {{ request()->routeIs('dashboard') ? 'opacity-100' : 'opacity-0' }} 
                      transition-opacity duration-300 z-0"></div>
                
                <!-- Shimmer Effect -->
                <div class="absolute inset-0 rounded-xl bg-gradient-to-r from-transparent via-white/10 to-transparent 
                      {{ request()->routeIs('dashboard') ? 'animate-shimmer' : 'opacity-0' }} z-0"></div>
            </div>
        </x-sidebar-item>

        <!-- PACKAGES -->
        <x-sidebar-item :href="route('packages.index')" :active="request()->routeIs('packages.index')" class="group">
            <div class="sidebar-btn {{ request()->routeIs('packages.index') ? 'active-packages' : 'hover:bg-white/10' }} 
                  transform transition-all duration-300 relative overflow-hidden">
                
                <div class="absolute left-0 top-1/2 -translate-y-1/2 w-1 h-8 bg-gradient-to-b from-pink-400 to-purple-400 rounded-r-full 
                      {{ request()->routeIs('packages.index') ? 'opacity-100' : 'opacity-0 group-hover:opacity-70' }}"></div>
                
                <div class="relative ml-1">
                    <i class="fa-solid fa-box-open text-lg {{ request()->routeIs('packages.index') ? 'text-pink-300' : 'text-white/90' }}
                          group-hover:text-pink-300"></i>
                    <div class="absolute -inset-2 bg-pink-500/20 rounded-full blur-md opacity-0 
                          {{ request()->routeIs('packages.index') ? 'opacity-100' : 'group-hover:opacity-50' }}"></div>
                </div>
                
                <span class="font-medium ml-3 {{ request()->routeIs('packages.index') ? 'text-pink-100 font-bold' : 'text-white/95' }}
                      group-hover:text-pink-100">
                    {{ __('Packages') }}
                </span>
                
                <i class="fa-solid fa-chevron-right text-xs ml-auto arrow-hover transform transition-all duration-300
                      {{ request()->routeIs('packages.index') ? 'text-pink-300 translate-x-0 opacity-100' : 'text-white/70' }}"></i>
                
                <div class="absolute inset-0 rounded-xl bg-gradient-to-r from-pink-600/30 via-pink-500/25 to-pink-400/20 
                      border-2 border-pink-400/30 {{ request()->routeIs('packages.index') ? 'opacity-100' : 'opacity-0' }}"></div>
                
                <div class="absolute inset-0 rounded-xl bg-gradient-to-r from-transparent via-white/10 to-transparent 
                      {{ request()->routeIs('packages.index') ? 'animate-shimmer' : 'opacity-0' }} z-0"></div>
            </div>
        </x-sidebar-item>

        @if(auth()->user()->isAdmin())
        <!-- USERS -->
        <x-sidebar-item :href="route('users.index')" :active="request()->routeIs('users.index')" class="group">
            <div class="sidebar-btn {{ request()->routeIs('users.index') ? 'active-users' : 'hover:bg-white/10' }} 
                  transform transition-all duration-300 relative overflow-hidden">
                
                <div class="absolute left-0 top-1/2 -translate-y-1/2 w-1 h-8 bg-gradient-to-b from-green-400 to-emerald-400 rounded-r-full 
                      {{ request()->routeIs('users.index') ? 'opacity-100' : 'opacity-0 group-hover:opacity-70' }}"></div>
                
                <div class="relative ml-1">
                    <i class="fa-solid fa-users text-lg {{ request()->routeIs('users.index') ? 'text-green-300' : 'text-white/90' }}
                          group-hover:text-green-300"></i>
                    <div class="absolute -inset-2 bg-green-500/20 rounded-full blur-md opacity-0 
                          {{ request()->routeIs('users.index') ? 'opacity-100' : 'group-hover:opacity-50' }}"></div>
                </div>
                
                <span class="font-medium ml-3 {{ request()->routeIs('users.index') ? 'text-green-100 font-bold' : 'text-white/95' }}
                      group-hover:text-green-100">
                    {{ __('Users') }}
                </span>
                
                <i class="fa-solid fa-chevron-right text-xs ml-auto arrow-hover transform transition-all duration-300
                      {{ request()->routeIs('users.index') ? 'text-green-300 translate-x-0 opacity-100' : 'text-white/70' }}"></i>
                
                <div class="absolute inset-0 rounded-xl bg-gradient-to-r from-green-600/30 via-green-500/25 to-green-400/20 
                      border-2 border-green-400/30 {{ request()->routeIs('users.index') ? 'opacity-100' : 'opacity-0' }}"></div>
                
                <div class="absolute inset-0 rounded-xl bg-gradient-to-r from-transparent via-white/10 to-transparent 
                      {{ request()->routeIs('users.index') ? 'animate-shimmer' : 'opacity-0' }} z-0"></div>
            </div>
        </x-sidebar-item>

        <!-- ISP -->
        <x-sidebar-item :href="route('company.edit')" :active="request()->routeIs('company.edit')" class="group">
            <div class="sidebar-btn {{ request()->routeIs('company.edit') ? 'active-isp' : 'hover:bg-white/10' }} 
                  transform transition-all duration-300 relative overflow-hidden">
                
                <div class="absolute left-0 top-1/2 -translate-y-1/2 w-1 h-8 bg-gradient-to-b from-orange-400 to-amber-400 rounded-r-full 
                      {{ request()->routeIs('company.edit') ? 'opacity-100' : 'opacity-0 group-hover:opacity-70' }}"></div>
                
                <div class="relative ml-1">
                    <i class="fa-solid fa-building text-lg {{ request()->routeIs('company.edit') ? 'text-orange-300' : 'text-white/90' }}
                          group-hover:text-orange-300"></i>
                    <div class="absolute -inset-2 bg-orange-500/20 rounded-full blur-md opacity-0 
                          {{ request()->routeIs('company.edit') ? 'opacity-100' : 'group-hover:opacity-50' }}"></div>
                </div>
                
                <span class="font-medium ml-3 {{ request()->routeIs('company.edit') ? 'text-orange-100 font-bold' : 'text-white/95' }}
                      group-hover:text-orange-100">
                    {{ __('ISP') }}
                </span>
                
                <i class="fa-solid fa-chevron-right text-xs ml-auto arrow-hover transform transition-all duration-300
                      {{ request()->routeIs('company.edit') ? 'text-orange-300 translate-x-0 opacity-100' : 'text-white/70' }}"></i>
                
                <div class="absolute inset-0 rounded-xl bg-gradient-to-r from-orange-600/30 via-orange-500/25 to-orange-400/20 
                      border-2 border-orange-400/30 {{ request()->routeIs('company.edit') ? 'opacity-100' : 'opacity-0' }}"></div>
                
                <div class="absolute inset-0 rounded-xl bg-gradient-to-r from-transparent via-white/10 to-transparent 
                      {{ request()->routeIs('company.edit') ? 'animate-shimmer' : 'opacity-0' }} z-0"></div>
            </div>
        </x-sidebar-item>

        <!-- ROUTER -->
        <x-sidebar-item :href="route('router.index')" :active="request()->routeIs('router.index')" class="group">
            <div class="sidebar-btn {{ request()->routeIs('router.index') ? 'active-router' : 'hover:bg-white/10' }} 
                  transform transition-all duration-300 relative overflow-hidden">
                
                <div class="absolute left-0 top-1/2 -translate-y-1/2 w-1 h-8 bg-gradient-to-b from-cyan-400 to-blue-400 rounded-r-full 
                      {{ request()->routeIs('router.index') ? 'opacity-100' : 'opacity-0 group-hover:opacity-70' }}"></div>
                
                <div class="relative ml-1">
                    <i class="fa-solid fa-wifi text-lg {{ request()->routeIs('router.index') ? 'text-cyan-300' : 'text-white/90' }}
                          group-hover:text-cyan-300"></i>
                    <div class="absolute -inset-2 bg-cyan-500/20 rounded-full blur-md opacity-0 
                          {{ request()->routeIs('router.index') ? 'opacity-100' : 'group-hover:opacity-50' }}"></div>
                </div>
                
                <span class="font-medium ml-3 {{ request()->routeIs('router.index') ? 'text-cyan-100 font-bold' : 'text-white/95' }}
                      group-hover:text-cyan-100">
                    {{ __('Router') }}
                </span>
                
                <i class="fa-solid fa-chevron-right text-xs ml-auto arrow-hover transform transition-all duration-300
                      {{ request()->routeIs('router.index') ? 'text-cyan-300 translate-x-0 opacity-100' : 'text-white/70' }}"></i>
                
                <div class="absolute inset-0 rounded-xl bg-gradient-to-r from-cyan-600/30 via-cyan-500/25 to-cyan-400/20 
                      border-2 border-cyan-400/30 {{ request()->routeIs('router.index') ? 'opacity-100' : 'opacity-0' }}"></div>
                
                <div class="absolute inset-0 rounded-xl bg-gradient-to-r from-transparent via-white/10 to-transparent 
                      {{ request()->routeIs('router.index') ? 'animate-shimmer' : 'opacity-0' }} z-0"></div>
            </div>
        </x-sidebar-item>
        @endif

        <!-- BILLING -->
        <x-sidebar-item :href="route('billing.index')" :active="request()->routeIs('billing.index')" class="group">
            <div class="sidebar-btn {{ request()->routeIs('billing.index') ? 'active-billing' : 'hover:bg-white/10' }} 
                  transform transition-all duration-300 relative overflow-hidden">
                
                <div class="absolute left-0 top-1/2 -translate-y-1/2 w-1 h-8 bg-gradient-to-b from-yellow-400 to-amber-400 rounded-r-full 
                      {{ request()->routeIs('billing.index') ? 'opacity-100' : 'opacity-0 group-hover:opacity-70' }}"></div>
                
                <div class="relative ml-1">
                    <i class="fa-solid fa-file-invoice-dollar text-lg {{ request()->routeIs('billing.index') ? 'text-yellow-300' : 'text-white/90' }}
                          group-hover:text-yellow-300"></i>
                    <div class="absolute -inset-2 bg-yellow-500/20 rounded-full blur-md opacity-0 
                          {{ request()->routeIs('billing.index') ? 'opacity-100' : 'group-hover:opacity-50' }}"></div>
                </div>
                
                <span class="font-medium ml-3 {{ request()->routeIs('billing.index') ? 'text-yellow-100 font-bold' : 'text-white/95' }}
                      group-hover:text-yellow-100">
                    {{ __('Billing') }}
                </span>
                
                <i class="fa-solid fa-chevron-right text-xs ml-auto arrow-hover transform transition-all duration-300
                      {{ request()->routeIs('billing.index') ? 'text-yellow-300 translate-x-0 opacity-100' : 'text-white/70' }}"></i>
                
                <div class="absolute inset-0 rounded-xl bg-gradient-to-r from-yellow-600/30 via-yellow-500/25 to-yellow-400/20 
                      border-2 border-yellow-400/30 {{ request()->routeIs('billing.index') ? 'opacity-100' : 'opacity-0' }}"></div>
                
                <div class="absolute inset-0 rounded-xl bg-gradient-to-r from-transparent via-white/10 to-transparent 
                      {{ request()->routeIs('billing.index') ? 'animate-shimmer' : 'opacity-0' }} z-0"></div>
            </div>
        </x-sidebar-item>

        <!-- PAYMENT -->
        <x-sidebar-item :href="route('payment.index')" :active="request()->routeIs('payment.index')" class="group">
            <div class="sidebar-btn {{ request()->routeIs('payment.index') ? 'active-payment' : 'hover:bg-white/10' }} 
                  transform transition-all duration-300 relative overflow-hidden">
                
                <div class="absolute left-0 top-1/2 -translate-y-1/2 w-1 h-8 bg-gradient-to-b from-emerald-400 to-teal-400 rounded-r-full 
                      {{ request()->routeIs('payment.index') ? 'opacity-100' : 'opacity-0 group-hover:opacity-70' }}"></div>
                
                <div class="relative ml-1">
                    <i class="fa-solid fa-money-check-dollar text-lg {{ request()->routeIs('payment.index') ? 'text-emerald-300' : 'text-white/90' }}
                          group-hover:text-emerald-300"></i>
                    <div class="absolute -inset-2 bg-emerald-500/20 rounded-full blur-md opacity-0 
                          {{ request()->routeIs('payment.index') ? 'opacity-100' : 'group-hover:opacity-50' }}"></div>
                </div>
                
                <span class="font-medium ml-3 {{ request()->routeIs('payment.index') ? 'text-emerald-100 font-bold' : 'text-white/95' }}
                      group-hover:text-emerald-100">
                    {{ __('Payment') }}
                </span>
                
                <i class="fa-solid fa-chevron-right text-xs ml-auto arrow-hover transform transition-all duration-300
                      {{ request()->routeIs('payment.index') ? 'text-emerald-300 translate-x-0 opacity-100' : 'text-white/70' }}"></i>
                
                <div class="absolute inset-0 rounded-xl bg-gradient-to-r from-emerald-600/30 via-emerald-500/25 to-emerald-400/20 
                      border-2 border-emerald-400/30 {{ request()->routeIs('payment.index') ? 'opacity-100' : 'opacity-0' }}"></div>
                
                <div class="absolute inset-0 rounded-xl bg-gradient-to-r from-transparent via-white/10 to-transparent 
                      {{ request()->routeIs('payment.index') ? 'animate-shimmer' : 'opacity-0' }} z-0"></div>
            </div>
        </x-sidebar-item>

        <!-- TICKET -->
        <x-sidebar-item :href="route('ticket.index')" :active="request()->routeIs('ticket.index')" class="group">
            <div class="sidebar-btn {{ request()->routeIs('ticket.index') ? 'active-ticket' : 'hover:bg-white/10' }} 
                  transform transition-all duration-300 relative overflow-hidden">
                
                <div class="absolute left-0 top-1/2 -translate-y-1/2 w-1 h-8 bg-gradient-to-b from-red-400 to-pink-400 rounded-r-full 
                      {{ request()->routeIs('ticket.index') ? 'opacity-100' : 'opacity-0 group-hover:opacity-70' }}"></div>
                
                <div class="relative ml-1">
                    <i class="fa-solid fa-ticket text-lg {{ request()->routeIs('ticket.index') ? 'text-red-300' : 'text-white/90' }}
                          group-hover:text-red-300"></i>
                    <div class="absolute -inset-2 bg-red-500/20 rounded-full blur-md opacity-0 
                          {{ request()->routeIs('ticket.index') ? 'opacity-100' : 'group-hover:opacity-50' }}"></div>
                </div>
                
                <span class="font-medium ml-3 {{ request()->routeIs('ticket.index') ? 'text-red-100 font-bold' : 'text-white/95' }}
                      group-hover:text-red-100">
                    {{ __('Ticket') }}
                </span>
                
                <i class="fa-solid fa-chevron-right text-xs ml-auto arrow-hover transform transition-all duration-300
                      {{ request()->routeIs('ticket.index') ? 'text-red-300 translate-x-0 opacity-100' : 'text-white/70' }}"></i>
                
                <div class="absolute inset-0 rounded-xl bg-gradient-to-r from-red-600/30 via-red-500/25 to-red-400/20 
                      border-2 border-red-400/30 {{ request()->routeIs('ticket.index') ? 'opacity-100' : 'opacity-0' }}"></div>
                
                <div class="absolute inset-0 rounded-xl bg-gradient-to-r from-transparent via-white/10 to-transparent 
                      {{ request()->routeIs('ticket.index') ? 'animate-shimmer' : 'opacity-0' }} z-0"></div>
            </div>
        </x-sidebar-item>
    </nav>

    <!-- Footer -->
    <div class="relative z-10 px-4 py-3 border-t border-white/10 bg-black/30 backdrop-blur-sm">
        <div class="flex items-center justify-between mb-1">
            <div class="flex items-center gap-2">
                <div class="relative">
                    <div class="w-2 h-2 bg-green-400 rounded-full"></div>
                    <div class="absolute inset-0 bg-green-400 rounded-full animate-ping"></div>
                </div>
                <span class="text-sm text-white/90">Online</span>
            </div>
            <span class="text-xs text-white/70 font-mono bg-black/30 px-2 py-1 rounded">v2.0.1</span>
        </div>
        <div class="text-center text-white/60 text-[10px] tracking-wider">
            ISP Billing System
        </div>
    </div>

    <!-- Animations & Custom Classes -->
    <style>
        @keyframes blob {
            0%, 100% { transform: translate(0,0) scale(1); }
            33% { transform: translate(20px,-40px) scale(1.15); }
            66% { transform: translate(-25px,20px) scale(0.9); }
        }
        .animate-blob { animation: blob 10s infinite ease-in-out; }
        .animation-delay-1000 { animation-delay: 1s; }
        .animation-delay-1500 { animation-delay: 1.5s; }
        .animation-delay-2000 { animation-delay: 2s; }
        .animation-delay-3000 { animation-delay: 3s; }
        .animation-delay-4000 { animation-delay: 4s; }

        @keyframes float {
            0%, 100% { transform: translateY(0) rotate(0deg); opacity: 0.7; }
            50% { transform: translateY(-15px) rotate(180deg); opacity: 0.3; }
        }
        .animate-float { animation: float 8s infinite ease-in-out; }

        @keyframes spin-slow {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
        .animate-spin-slow { animation: spin-slow 20s linear infinite; }

        @keyframes bounce-slow {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-5px); }
        }
        .animate-bounce-slow { animation: bounce-slow 3s infinite ease-in-out; }

        @keyframes gradient-x {
            0%, 100% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
        }
        .animate-gradient-x {
            background-size: 200% auto;
            animation: gradient-x 5s ease infinite;
        }

        @keyframes pulse-slow {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.8; }
        }
        .animate-pulse-slow { animation: pulse-slow 3s infinite; }

        @keyframes shimmer {
            0% { transform: translateX(-100%); }
            100% { transform: translateX(100%); }
        }
        .animate-shimmer {
            animation: shimmer 2s infinite;
        }

        .sidebar-btn {
            @apply relative flex items-center px-4 py-3 
            rounded-xl transition-all duration-300
            cursor-pointer z-10;
        }

        /* Enhanced Active States with Rounded Rectangle */
        .active-dashboard,
        .active-packages,
        .active-users,
        .active-isp,
        .active-router,
        .active-billing,
        .active-payment,
        .active-ticket {
            background: rgba(255, 255, 255, 0.25) !important;
            border-radius: 12px !important;
            box-shadow: 0 8px 32px rgba(14, 2, 2, 0.2) !important;
            backdrop-filter: blur(10px) !important;
        }

        /* Make active text more visible */
        .active-dashboard span {
            color: #020b14ff !important;
            font-weight: 700 !important;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
        }
        
        .active-packages span {
            color: #000000ff !important;
            font-weight: 700 !important;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
        }
        
        .active-users span {
            color: #000000ff !important;
            font-weight: 700 !important;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
        }
        
        .active-isp span {
            color: #000000ff !important;
            font-weight: 700 !important;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
        }
        
        .active-router span {
            color: #000000ff !important;
            font-weight: 700 !important;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
        }
        
        .active-billing span {
            color: #020202ff !important;
            font-weight: 700 !important;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
        }
        
        .active-payment span {
            color: #000000ff !important;
            font-weight: 700 !important;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
        }
        
        .active-ticket span {
            color: #000000ff !important;
            font-weight: 700 !important;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
        }

        /* Chevron Animation */
        .arrow-hover {
            opacity: 0;
            transform: translateX(-5px);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .group:hover .arrow-hover {
            opacity: 1;
            transform: translateX(0);
        }

        /* Custom Scrollbar */
        .custom-scrollbar::-webkit-scrollbar { 
            width: 5px; 
        }
        .custom-scrollbar::-webkit-scrollbar-track { 
            background: rgba(255,255,255,0.05); 
            border-radius: 10px; 
        }
        .custom-scrollbar::-webkit-scrollbar-thumb { 
            background: linear-gradient(to bottom, rgba(255,255,255,0.2), rgba(255,255,255,0.4));
            border-radius: 10px; 
        }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover { 
            background: linear-gradient(to bottom, rgba(255,255,255,0.3), rgba(255,255,255,0.6)); 
        }
    </style>
</div>