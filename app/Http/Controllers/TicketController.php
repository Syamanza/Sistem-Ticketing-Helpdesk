<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Ticket;
use App\Models\TicketLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TicketController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $query = Ticket::with(['category', 'user']);

        if ($user->role === 'user') {
            $query->where('user_id', $user->id);
        }

        // Filters for IT Support
        if ($user->role === 'support') {
            if ($request->filled('status')) {
                $query->where('status', $request->status);
            }
            if ($request->filled('category_id')) {
                $query->where('category_id', $request->category_id);
            }
            if ($request->filled('date')) {
                $query->whereDate('created_at', $request->date);
            }
        }

        $tickets = $query->orderBy('created_at', 'desc')->get();
        $categories = Category::all();

        return view('tickets.index', compact('tickets', 'categories'));
    }

    public function create()
    {
        if (Auth::user()->role !== 'user') {
            return redirect()->route('tickets.index')->with('error', 'Only users can create tickets.');
        }

        $categories = Category::all();
        return view('tickets.create', compact('categories'));
    }

    public function store(Request $request)
    {
        if (Auth::user()->role !== 'user') {
            return abort(403);
        }

        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'subject' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $ticket = Ticket::create([
            'ticket_no' => 'TICK-' . strtoupper(uniqid()),
            'user_id' => Auth::id(),
            'category_id' => $request->category_id,
            'subject' => $request->subject,
            'description' => $request->description,
            'status' => 'Open',
        ]);

        TicketLog::create([
            'ticket_id' => $ticket->id,
            'user_id' => Auth::id(),
            'action' => 'created',
            'status_from' => null,
            'status_to' => 'Open',
            'note' => 'Ticket successfully submitted by user.',
        ]);

        return redirect()->route('tickets.index')->with('success', 'Ticket created successfully.');
    }

    public function show(Ticket $ticket)
    {
        $user = Auth::user();
        if ($user->role === 'user' && $ticket->user_id !== $user->id) {
            return abort(403);
        }

        $ticket->load(['logs.user', 'category', 'user']);
        return view('tickets.show', compact('ticket'));
    }

    public function updateStatus(Request $request, Ticket $ticket)
    {
        if (Auth::user()->role !== 'support') {
            return abort(403);
        }

        $request->validate([
            'status' => 'required|in:Open,On Progress,Resolved,Closed',
            'note' => 'required|string',
        ]);

        $oldStatus = $ticket->status;
        $newStatus = $request->status;

        $ticket->update(['status' => $newStatus]);

        TicketLog::create([
            'ticket_id' => $ticket->id,
            'user_id' => Auth::id(),
            'action' => 'status_updated',
            'status_from' => $oldStatus,
            'status_to' => $newStatus,
            'note' => $request->note,
        ]);

        return redirect()->route('tickets.show', $ticket)->with('success', 'Status updated successfully.');
    }
}
