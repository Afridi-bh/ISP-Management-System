<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Ticket;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    public function index()
    {
        // Admin can see all tickets (from both users and customers)
        return view('tickets.index');
    }

    public function create()
    {
        return view('tickets.create');
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
        
        // Associate with admin user
        $ticket->ticketable()->associate(auth()->user());
        $ticket->save();

        return redirect()->route('ticket.index')
            ->with('success', 'Ticket created successfully!');
    }

    public function show(Ticket $ticket)
    {
        // Load comments with both user and customer relationships
        $comments = Comment::where('ticket_id', $ticket->id)
            ->with(['user', 'customer'])
            ->get();

        return view('tickets.show', compact('ticket', 'comments'));
    }
}