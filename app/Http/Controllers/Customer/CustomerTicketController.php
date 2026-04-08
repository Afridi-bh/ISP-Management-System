<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Ticket;
use Illuminate\Http\Request;

class CustomerTicketController extends Controller
{
    public function index()
    {
        $tickets = auth('customer')->user()->tickets()->latest()->paginate(10);
        
        return view('customer.tickets.index', compact('tickets'));
    }

    public function create()
    {
        return view('customer.tickets.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
            'priority' => 'required|in:Low,Medium,High,Urgent',
        ]);

        $ticket = new Ticket();
        $ticket->subject = $validated['subject'];
        $ticket->message = $validated['message'];
        $ticket->priority = $validated['priority'];
        $ticket->status = 'Open';
        $ticket->number = $ticket->generateRandomNumber();
        
        // Associate with customer using polymorphic relationship
        $ticket->ticketable()->associate(auth('customer')->user());
        $ticket->save();

        return redirect()->route('customer.tickets.index')
            ->with('success', 'Ticket created successfully! Ticket #' . $ticket->number);
    }

    public function show(Ticket $ticket)
    {
        // Ensure customer can only view their own tickets
        if ($ticket->ticketable_id !== auth('customer')->id() || 
            $ticket->ticketable_type !== 'App\\Models\\Customer') {
            abort(403, 'Unauthorized access to this ticket.');
        }

        $comments = $ticket->comments()->with('user', 'customer')->latest()->get();

        return view('customer.tickets.show', compact('ticket', 'comments'));
    }
}