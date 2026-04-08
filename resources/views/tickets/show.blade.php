<x-app-layout>
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <!-- Ticket Header -->
                    <div class="border-b border-gray-200 pb-4 mb-6">
                        <div class="flex justify-between items-start">
                            <div>
                                <h2 class="text-2xl font-bold text-gray-900">
                                    Ticket #{{ $ticket->number }}
                                </h2>
                                <p class="text-sm text-gray-500 mt-1">
                                    Created {{ $ticket->created_at->format('M d, Y \a\t h:i A') }}
                                </p>
                            </div>
                            <div class="flex gap-2">
                                <span class="px-3 py-1 text-sm rounded
                                    @if($ticket->status == 'Open') bg-green-100 text-green-800
                                    @elseif($ticket->status == 'Closed') bg-gray-100 text-gray-800
                                    @else bg-yellow-100 text-yellow-800
                                    @endif">
                                    {{ $ticket->status }}
                                </span>
                                <span class="px-3 py-1 text-sm rounded
                                    @if($ticket->priority == 'Urgent') bg-red-100 text-red-800
                                    @elseif($ticket->priority == 'High') bg-orange-100 text-orange-800
                                    @elseif($ticket->priority == 'Medium') bg-yellow-100 text-yellow-800
                                    @else bg-blue-100 text-blue-800
                                    @endif">
                                    {{ $ticket->priority }}
                                </span>
                            </div>
                        </div>

                        <div class="mt-4">
                            <h3 class="text-lg font-semibold text-gray-900">{{ $ticket->subject }}</h3>
                            <p class="text-sm text-gray-600 mt-1">
                                By: <strong>{{ $ticket->ticketable->name }}</strong> 
                                <span class="text-xs px-2 py-1 rounded 
                                    {{ $ticket->isCustomerTicket() ? 'bg-green-100 text-green-700' : 'bg-blue-100 text-blue-700' }}">
                                    {{ $ticket->isCustomerTicket() ? 'Customer' : 'Staff' }}
                                </span>
                                ({{ $ticket->ticketable->email }})
                            </p>
                        </div>
                    </div>

                    <!-- Original Message -->
                    <div class="bg-gray-50 rounded-lg p-4 mb-6">
                        <div class="prose max-w-none">
                            {!! nl2br(e($ticket->message)) !!}
                        </div>
                    </div>

                    <!-- Comments Section -->
                    <div class="space-y-4 mb-6">
                        <h3 class="text-lg font-semibold text-gray-900">Comments</h3>
                        
                        @forelse($comments as $comment)
                            <div class="bg-white border border-gray-200 rounded-lg p-4">
                                <div class="flex justify-between items-start mb-2">
                                    <div>
                                        <span class="font-semibold text-gray-900">
                                            {{ $comment->commenter()->name }}
                                        </span>
                                        <span class="text-xs px-2 py-1 rounded ml-2
                                            {{ $comment->isCustomerComment() ? 'bg-green-100 text-green-700' : 'bg-blue-100 text-blue-700' }}">
                                            {{ $comment->isCustomerComment() ? 'Customer' : 'Staff' }}
                                        </span>
                                    </div>
                                    <span class="text-sm text-gray-500">
                                        {{ $comment->created_at->format('M d, Y \a\t h:i A') }}
                                    </span>
                                </div>
                                <div class="text-gray-700">
                                    {!! nl2br(e($comment->comment)) !!}
                                </div>
                            </div>
                        @empty
                            <p class="text-gray-500 text-center py-4">No comments yet.</p>
                        @endforelse
                    </div>

                    <!-- Add Comment Form -->
                    @if($ticket->status !== 'Closed')
                        <div class="border-t border-gray-200 pt-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Add Comment</h3>
                            <form action="{{ route('add.comment') }}" method="POST">
                                @csrf
                                <input type="hidden" name="ticket_id" value="{{ $ticket->id }}">
                                <textarea name="comment" rows="4" 
                                          class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"
                                          placeholder="Write your comment here..." required></textarea>
                                <div class="mt-4 flex justify-between">
                                    <a href="{{ route('ticket.index') }}" 
                                       class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                                        Back to Tickets
                                    </a>
                                    <button type="submit" 
                                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                        Add Comment
                                    </button>
                                </div>
                            </form>
                        </div>
                    @endif

                    <!-- Ticket Actions -->
                    <div class="border-t border-gray-200 pt-6 mt-6">
                        <div class="flex gap-2">
                            @if($ticket->status == 'Open')
                                <form action="{{ route('close.ticket', $ticket) }}" method="POST">
                                    @csrf
                                    <button type="submit" 
                                            class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                                        Close Ticket
                                    </button>
                                </form>
                            @else
                                <form action="{{ route('open.ticket', $ticket) }}" method="POST">
                                    @csrf
                                    <button type="submit" 
                                            class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                        Reopen Ticket
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>