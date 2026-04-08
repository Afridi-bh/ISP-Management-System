<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'Customer Portal') - {{ config('app.name', 'ISP Billing') }}</title>
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet" />
    
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
    
    @stack('styles')
</head>
<body class="bg-gray-100">
    
    <!-- Navigation -->
    <nav class="bg-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex">
                    <!-- Logo -->
                    <div class="flex-shrink-0 flex items-center">
                        <a href="{{ route('customer.dashboard') }}" class="text-2xl font-bold text-blue-600">
                            ISP Billing
                        </a>
                    </div>
                    
                    <!-- Navigation Links -->
                    <div class="hidden sm:ml-6 sm:flex sm:space-x-8">
                        <a href="{{ route('customer.dashboard') }}" 
                           class="@if(request()->routeIs('customer.dashboard')) border-blue-500 text-gray-900 @else border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 @endif inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                            Dashboard
                        </a>
                        
                        <a href="{{ route('customer.subscriptions') }}" 
                           class="@if(request()->routeIs('customer.subscriptions*')) border-blue-500 text-gray-900 @else border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 @endif inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                            Subscriptions
                        </a>
                        
                        <a href="{{ route('customer.payments') }}" 
                           class="@if(request()->routeIs('customer.payment*')) border-blue-500 text-gray-900 @else border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 @endif inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                            Payments
                        </a>
                        
                        <a href="{{ route('customer.support') }}" 
                           class="@if(request()->routeIs('customer.support') || request()->routeIs('customer.tickets*')) border-blue-500 text-gray-900 @else border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 @endif inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                            Support
                        </a>
                    </div>
                </div>
                
                <!-- User Menu -->
                <div class="hidden sm:ml-6 sm:flex sm:items-center">
                    <div class="ml-3 relative">
                        <div class="flex items-center space-x-4">
                            <span class="text-sm text-gray-700">{{ $customer->name }}</span>
                            <div class="relative" x-data="{ open: false }">
                                <button @click="open = !open" class="flex items-center text-sm focus:outline-none">
                                    <div class="h-8 w-8 rounded-full bg-blue-500 flex items-center justify-center text-white font-semibold">
                                        {{ strtoupper(substr($customer->name, 0, 1)) }}
                                    </div>
                                </button>
                                
                                <div x-show="open" @click.away="open = false" 
                                     class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 z-50"
                                     style="display: none;">
                                    <a href="{{ route('customer.profile') }}" 
                                       class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        Profile
                                    </a>
                                    <form method="POST" action="{{ route('customer.logout') }}">
                                        @csrf
                                        <button type="submit" 
                                                class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                            Logout
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Mobile menu button -->
                <div class="-mr-2 flex items-center sm:hidden">
                    <button @click="mobileMenuOpen = !mobileMenuOpen" 
                            class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100">
                        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
        
        <!-- Mobile menu -->
        <div x-show="mobileMenuOpen" class="sm:hidden" style="display: none;" x-data="{ mobileMenuOpen: false }">
            <div class="pt-2 pb-3 space-y-1">
                <a href="{{ route('customer.dashboard') }}" 
                   class="@if(request()->routeIs('customer.dashboard')) bg-blue-50 border-blue-500 text-blue-700 @else border-transparent text-gray-500 hover:bg-gray-50 @endif block pl-3 pr-4 py-2 border-l-4 text-base font-medium">
                    Dashboard
                </a>
                <a href="{{ route('customer.subscriptions') }}" 
                   class="@if(request()->routeIs('customer.subscriptions*')) bg-blue-50 border-blue-500 text-blue-700 @else border-transparent text-gray-500 hover:bg-gray-50 @endif block pl-3 pr-4 py-2 border-l-4 text-base font-medium">
                    Subscriptions
                </a>
                <a href="{{ route('customer.payments') }}" 
                   class="@if(request()->routeIs('customer.payment*')) bg-blue-50 border-blue-500 text-blue-700 @else border-transparent text-gray-500 hover:bg-gray-50 @endif block pl-3 pr-4 py-2 border-l-4 text-base font-medium">
                    Payments
                </a>
                <a href="{{ route('customer.support') }}" 
                   class="@if(request()->routeIs('customer.support') || request()->routeIs('customer.tickets*')) bg-blue-50 border-blue-500 text-blue-700 @else border-transparent text-gray-500 hover:bg-gray-50 @endif block pl-3 pr-4 py-2 border-l-4 text-base font-medium">
                    Support
                </a>
                <a href="{{ route('customer.profile') }}" 
                   class="@if(request()->routeIs('customer.profile')) bg-blue-50 border-blue-500 text-blue-700 @else border-transparent text-gray-500 hover:bg-gray-50 @endif block pl-3 pr-4 py-2 border-l-4 text-base font-medium">
                    Profile
                </a>
                <form method="POST" action="{{ route('customer.logout') }}">
                    @csrf
                    <button type="submit" 
                            class="block w-full text-left pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-500 hover:bg-gray-50">
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </nav>
    
    <!-- Flash Messages -->
    @if(session('success'))
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
        <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    </div>
    @endif
    
    @if(session('error'))
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
        <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
    </div>
    @endif
    
    @if(session('info'))
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
        <div class="bg-blue-50 border border-blue-200 text-blue-800 px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline">{{ session('info') }}</span>
        </div>
    </div>
    @endif
    
    @if($errors->any())
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
        <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded relative" role="alert">
            <strong class="font-bold">Whoops!</strong>
            <ul class="mt-2 list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
    @endif
    
    <!-- Main Content -->
    <main class="py-8">
        <div class="max-w-7xl mx-auto">
            @yield('content')
        </div>
    </main>
    
    <!-- Footer -->
    <footer class="bg-white border-t mt-12">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <p class="text-center text-gray-500 text-sm">
                © {{ date('Y') }} BetterNet. All rights reserved.
            </p>
        </div>
    </footer>
    
    <!-- Alpine.js for dropdown functionality -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    @stack('scripts')
</body>
</html>