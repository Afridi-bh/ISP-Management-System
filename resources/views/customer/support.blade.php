@extends('layouts.customer')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-6 text-gray-800">Support Center</h1>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Sidebar - Quick Help -->
        <div class="space-y-6">
            <!-- Contact Info -->
            <div class="bg-gradient-to-r from-blue-500 to-purple-600 rounded-lg shadow text-white p-6">
                <h3 class="text-xl font-semibold mb-4">
                    <i class="fas fa-headset mr-2"></i> Need Help?
                </h3>
                <div class="space-y-3">
                    <div class="flex items-center">
                        <i class="fas fa-phone fa-lg mr-3"></i>
                        <div>
                            <div class="text-xs opacity-75">Call Us</div>
                            <div class="font-semibold">+880 1234-567890</div>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-envelope fa-lg mr-3"></i>
                        <div>
                            <div class="text-xs opacity-75">Email Us</div>
                            <div class="font-semibold">support@company.com</div>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-clock fa-lg mr-3"></i>
                        <div>
                            <div class="text-xs opacity-75">Support Hours</div>
                            <div class="font-semibold">24/7 Available</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- FAQ Quick Links -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold mb-4">
                    <i class="fas fa-question-circle mr-2 text-blue-600"></i> Quick Help
                </h3>
                <div class="space-y-2">
                    <a href="#" class="block px-3 py-2 rounded hover:bg-blue-50 text-sm">
                        <i class="fas fa-wifi mr-2 text-blue-600"></i> Connection Issues
                    </a>
                    <a href="#" class="block px-3 py-2 rounded hover:bg-blue-50 text-sm">
                        <i class="fas fa-credit-card mr-2 text-green-600"></i> Payment Help
                    </a>
                    <a href="#" class="block px-3 py-2 rounded hover:bg-blue-50 text-sm">
                        <i class="fas fa-key mr-2 text-purple-600"></i> Password Reset
                    </a>
                    <a href="#" class="block px-3 py-2 rounded hover:bg-blue-50 text-sm">
                        <i class="fas fa-box mr-2 text-orange-600"></i> Package Upgrade
                    </a>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Create Ticket -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-semibold mb-4">
                    <i class="fas fa-ticket-alt mr-2 text-purple-600"></i> Open Support Ticket
                </h2>
                
                <form method="POST" action="{{ route('customer.tickets.store') }}">
                    @csrf
                    
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium mb-2">Subject *</label>
                            <input type="text" name="subject" 
                                   class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" 
                                   placeholder="Brief description of your issue" required>
                        </div>

                        <div>
                            <label class="block text-sm font-medium mb-2">Priority</label>
                            <select name="priority" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="low">Low - General inquiry</option>
                                <option value="medium" selected>Medium - Need assistance</option>
                                <option value="high">High - Service disruption</option>
                                <option value="urgent">Urgent - No internet access</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium mb-2">Category</label>
                            <select name="category" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="technical">Technical Issue</option>
                                <option value="billing">Billing Question</option>
                                <option value="account">Account Issue</option>
                                <option value="general">General Inquiry</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium mb-2">Description *</label>
                            <textarea name="description" rows="6" 
                                      class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" 
                                      placeholder="Please provide detailed information about your issue..." required></textarea>
                        </div>

                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                            <h4 class="font-semibold text-blue-800 mb-2">
                                <i class="fas fa-lightbulb mr-2"></i> Tips for faster resolution:
                            </h4>
                            <ul class="text-sm text-blue-700 space-y-1">
                                <li>• Be as specific as possible</li>
                                <li>• Include error messages if any</li>
                                <li>• Mention when the problem started</li>
                                <li>• Describe steps you've already tried</li>
                            </ul>
                        </div>

                        <button type="submit" class="w-full bg-blue-500 hover:bg-blue-600 text-white py-3 rounded-lg font-semibold">
                            <i class="fas fa-paper-plane mr-2"></i> Submit Ticket
                        </button>
                    </div>
                </form>
            </div>

            <!-- My Tickets -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-semibold mb-4">
                    <i class="fas fa-list mr-2 text-green-600"></i> My Support Tickets
                </h2>

                @php
                    // Mock ticket data - Replace with actual data
                    $tickets = collect([
                        (object)[
                            'id' => 'TKT-001',
                            'subject' => 'Internet connection slow',
                            'status' => 'open',
                            'priority' => 'high',
                            'created_at' => now()->subHours(2),
                            'updated_at' => now()->subHours(1),
                        ],
                        (object)[
                            'id' => 'TKT-002',
                            'subject' => 'Payment confirmation',
                            'status' => 'closed',
                            'priority' => 'low',
                            'created_at' => now()->subDays(5),
                            'updated_at' => now()->subDays(4),
                        ],
                    ]);
                @endphp

                @if($tickets->count() > 0)
                    <div class="space-y-4">
                        @foreach($tickets as $ticket)
                            <div class="border rounded-lg p-4 hover:bg-gray-50">
                                <div class="flex justify-between items-start mb-2">
                                    <div>
                                        <h4 class="font-semibold text-lg">{{ $ticket->subject }}</h4>
                                        <p class="text-sm text-gray-600">{{ $ticket->id }}</p>
                                    </div>
                                    <div class="text-right">
                                        <span class="px-2 py-1 text-xs rounded 
                                            {{ $ticket->status === 'open' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                            {{ ucfirst($ticket->status) }}
                                        </span>
                                        <div class="text-xs text-gray-500 mt-1">
                                            Priority: <span class="font-semibold 
                                                {{ $ticket->priority === 'urgent' ? 'text-red-600' : 
                                                   ($ticket->priority === 'high' ? 'text-orange-600' : 'text-gray-600') }}">
                                                {{ ucfirst($ticket->priority) }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="flex justify-between items-center mt-3 pt-3 border-t">
                                    <div class="text-xs text-gray-600">
                                        Created: {{ \Carbon\Carbon::parse($ticket->created_at)->diffForHumans() }}
                                    </div>
                                    <a href="{{ route('customer.tickets.show', $ticket->id) }}" 
                                       class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                        View Details <i class="fas fa-arrow-right ml-1"></i>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-4 text-center">
                        <a href="{{ route('customer.tickets.index') }}" class="text-blue-600 hover:underline">
                            View All Tickets →
                        </a>
                    </div>
                @else
                    <div class="text-center py-8 text-gray-500">
                        <i class="fas fa-ticket-alt fa-3x mb-3 opacity-50"></i>
                        <p>No support tickets yet</p>
                    </div>
                @endif
            </div>

            <!-- FAQs -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-semibold mb-4">
                    <i class="fas fa-question-circle mr-2 text-yellow-600"></i> Frequently Asked Questions
                </h2>
                
                <div class="space-y-4">
                    <details class="border rounded-lg p-4">
                        <summary class="font-semibold cursor-pointer">How do I check my subscription status?</summary>
                        <p class="mt-2 text-gray-600 text-sm">
                            Go to the Dashboard or Subscriptions page to view your current subscription details, including expiry date and package information.
                        </p>
                    </details>

                    <details class="border rounded-lg p-4">
                        <summary class="font-semibold cursor-pointer">How can I make a payment?</summary>
                        <p class="mt-2 text-gray-600 text-sm">
                            Navigate to Invoices, select an unpaid invoice, and click "Pay Now". You can pay using Stripe (card), bKash, or Cash.
                        </p>
                    </details>

                    <details class="border rounded-lg p-4">
                        <summary class="font-semibold cursor-pointer">How do I upgrade my package?</summary>
                        <p class="mt-2 text-gray-600 text-sm">
                            Visit the Subscriptions page and click "Upgrade Plan" to view available packages and upgrade options.
                        </p>
                    </details>

                    <details class="border rounded-lg p-4">
                        <summary class="font-semibold cursor-pointer">What should I do if my internet is not working?</summary>
                        <p class="mt-2 text-gray-600 text-sm">
                            First, check if your subscription is active and you have no pending dues. Try restarting your router. If the issue persists, open a support ticket with priority "Urgent".
                        </p>
                    </details>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection