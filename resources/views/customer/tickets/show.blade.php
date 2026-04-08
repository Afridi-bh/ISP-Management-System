@extends('layouts.customer')

@section('title', 'Ticket #' . $ticket->number)

@section('content')
<div class="py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Back Button -->
        <div class="mb-4">
            <a href="{{ route('customer.tickets.index') }}" 
               class="inline-flex items-center text-sm text-gray-600 hover:text-gray-900">
                <i class="fas fa-arrow-left mr-2"></i> Back to Tickets
            </a>
        </div>

        <div class="bg-white rounded-lg shadow-sm">
            <!-- Ticket Header -->
            <div class="border-b border-gray-200 p-6">
                <div class="flex justify-between items-start">
                    <div class="flex-1">
                        <div class="flex items-center gap-3 mb-2">
                            <h1 class="text-2xl font-bold text-gray-900">
                                Ticket #{{ $ticket->number }}
                            </h1>
                            <span class="px-3 py-1 text-sm font-semibold rounded-full
                                @if($ticket->status == 'Open') bg-blue-100 text-blue-800
                                @else bg-gray-100 text-gray-800
                                @endif">
                                <i class="fas fa-circle text-[8px] mr-1"></i>
                                {{ $ticket->status }}
                            </span>
                            <span class="px-3 py-1 text-sm font-semibold rounded-full
                                @if($ticket->priority == 'Urgent') bg-red-100 text-red-800
                                @elseif($ticket->priority == 'High') bg-orange-100 text-orange-800
                                @elseif($ticket->priority == 'Medium') bg-yellow-100 text-yellow-800
                                @else bg-green-100 text-green-800
                                @endif">
                                <i class="fas fa-flag text-xs mr-1"></i>
                                {{ $ticket->priority }}
                            </span>
                        </div>
                        <p class="text-sm text-gray-500">
                            <i class="far fa-clock"></i> Created {{ $ticket->created_at->format('M d, Y \a\t h:i A') }}
                        </p>
                    </div>
                </div>

                <div class="mt-4">
                    <h2 class="text-lg font-semibold text-gray-900">{{ $ticket->subject }}</h2>
                </div>
            </div>

            <!-- Original Message -->
            <div class="p-6 bg-gray-50">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <div class="h-10 w-10 rounded-full bg-blue-600 flex items-center justify-center text-white font-semibold">
                            {{ substr(auth('customer')->user()->name, 0, 1) }}
                        </div>
                    </div>
                    <div class="ml-4 flex-1">
                        <div class="flex items-center justify-between">
                            <h3 class="text-sm font-medium text-gray-900">You</h3>