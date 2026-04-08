<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class AddComment extends Controller
{
    public function __invoke(Request $request)
    {
        $validated = $request->validate([
            'ticket_id' => 'required|exists:tickets,id',
            'comment' => 'required|string',
        ]);

        $comment = new Comment();
        $comment->ticket_id = $validated['ticket_id'];
        $comment->comment = $validated['comment'];
        
        // Check if it's a customer or admin user
        if (auth('customer')->check()) {
            $comment->customer_id = auth('customer')->id();
            $redirectRoute = 'customer.tickets.show';
        } else {
            $comment->user_id = auth()->id();
            $redirectRoute = 'ticket.show';
        }
        
        $comment->save();

        return redirect()->route($redirectRoute, $comment->ticket_id)
            ->with('success', 'Comment added successfully!');
    }
}