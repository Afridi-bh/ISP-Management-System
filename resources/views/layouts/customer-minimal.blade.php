<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Portal</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50">
    <!-- Simple Navigation -->
    <nav class="bg-white shadow-sm border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="{{ route('customer.dashboard') }}" class="text-2xl font-bold text-blue-600">
                        <i class="fas fa-wifi mr-2"></i>ISP Portal
                    </a>
                    
                    <div class="ml-10 flex space-x-4">
                        <a href="{{ route('customer.dashboard') }}" class="text-gray-700 hover:text-blue-600 px-3 py-2">
                            <i class="fas fa-home mr-1"></i> Dashboard
                        </a>
                        <a href="{{ route('customer.subscriptions') }}" class="text-gray-700 hover:text-blue-600 px-3 py-2">
                            <i class="fas fa-box mr-1"></i> Subscription
                        </a>
                        <a href="{{ route('customer.invoices') }}" class="text-gray-700 hover:text-blue-600 px-3 py-2">
                            <i class="fas fa-file-invoice mr-1"></i> Invoices
                        </a>
                        <a href="{{ route('customer.payments') }}" class="text-gray-700 hover:text-blue-600 px-3 py-2">
                            <i class="fas fa-credit-card mr-1"></i> Payments
                        </a>
                        <a href="{{ route('customer.support') }}" class="text-gray-700 hover:text-blue-600 px-3 py-2">
                            <i class="fas fa-headset mr-1"></i> Support
                        </a>
                    </div>
                </div>

                <div class="flex items-center">
                    <span class="text-gray-700 mr-4">{{ auth()->guard('customer')->user()->name }}</span>
                    <form method="POST" action="{{ route('customer.logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded">
                            <i class="fas fa-sign-out-alt mr-1"></i> Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <!-- Page Content -->
    <main class="min-h-screen">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-gray-200 mt-12">
        <div class="max-w-7xl mx-auto py-6 px-4">
            <div class="text-center text-gray-500 text-sm">
                <p>&copy; {{ date('Y') }} ISP Customer Portal. All rights reserved.</p>
            </div>
        </div>
    </footer>
</body>
</html>