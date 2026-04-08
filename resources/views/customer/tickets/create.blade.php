@extends('layouts.customer')

@section('title', 'Create Support Ticket')

@section('content')
<div class="py-8">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-900">
                <i class="fas fa-ticket-alt text-blue-600"></i> Create Support Ticket
            </h1>
            <p class="mt-1 text-sm text-gray-600">Describe your issue and our team will help you</p>
        </div>

        <div class="bg-white rounded-lg shadow-sm">
            <div class="p-6">
                <form method="POST" action="{{ route('customer.tickets.store') }}">
                    @csrf

                    <!-- Subject -->
                    <div class="mb-6">
                        <label for="subject" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-heading text-gray-400"></i> Subject <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               name="subject" 
                               id="subject" 
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('subject') border-red-500 @enderror"
                               value="{{ old('subject') }}" 
                               placeholder="Brief description of your issue"
                               required>
                        @error('subject')
                            <p class="text-red-500 text-xs mt-1">
                                <i class="fas fa-exclamation-circle"></i> {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Priority -->
                    <div class="mb-6">
                        <label for="priority" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-flag text-gray-400"></i> Priority <span class="text-red-500">*</span>
                        </label>
                        <select name="priority" 
                                id="priority" 
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('priority') border-red-500 @enderror"
                                required>
                            <option value="Low" {{ old('priority') == 'Low' ? 'selected' : '' }}>
                                Low - General inquiry
                            </option>
                            <option value="Medium" {{ old('priority') == 'Medium' ? 'selected' : '' }}>
                                Medium - Service question
                            </option>
                            <option value="High" {{ old('priority') == 'High' ? 'selected' : '' }}>
                                High - Service disruption
                            </option>
                            <option value="Urgent" {{ old('priority') == 'Urgent' ? 'selected' : '' }}>
                                Urgent - Critical issue
                            </option>
                        </select>
                        @error('priority')
                            <p class="text-red-500 text-xs mt-1">
                                <i class="fas fa-exclamation-circle"></i> {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Message -->
                    <div class="mb-6">
                        <label for="message" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-comment-dots text-gray-400"></i> Message <span class="text-red-500">*</span>
                        </label>
                        <textarea name="message" 
                                  id="message" 
                                  rows="6"
                                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('message') border-red-500 @enderror"
                                  placeholder="Please provide detailed information about your issue..."
                                  required>{{ old('message') }}</textarea>
                        @error('message')
                            <p class="text-red-500 text-xs mt-1">
                                <i class="fas fa-exclamation-circle"></i> {{ $message }}
                            </p>
                        @enderror
                        <p class="text-xs text-gray-500 mt-1">
                            <i class="fas fa-info-circle"></i> Please include as much detail as possible to help us resolve your issue quickly
                        </p>
                    </div>

                    <!-- Actions -->
                    <div class="flex justify-between items-center pt-4 border-t border-gray-200">
                        <a href="{{ route('customer.tickets.index') }}" 
                           class="inline-flex items-center px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold rounded-lg transition duration-150">
                            <i class="fas fa-arrow-left mr-2"></i> Cancel
                        </a>
                        <button type="submit" 
                                class="inline-flex items-center px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg shadow-sm transition duration-150">
                            <i class="fas fa-paper-plane mr-2"></i> Submit Ticket
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Help Box -->
        <div class="mt-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
            <div class="flex">
                <i class="fas fa-info-circle text-blue-600 mt-0.5"></i>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-blue-800">Need immediate help?</h3>
                    <div class="mt-2 text-sm text-blue-700">
                        <p>For urgent issues, please contact us directly:</p>
                        <ul class="list-disc list-inside mt-1">
                            <li>Phone: +880 1234-567890</li>
                            <li>Email: support@ispportal.com</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection