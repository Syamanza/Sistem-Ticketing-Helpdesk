@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="h3 mb-0">Tickets Dashboard</h2>
    @if(Auth::user()->role === 'user')
        <a href="{{ route('tickets.create') }}" class="btn btn-primary fw-semibold">Submit New Ticket</a>
    @endif
</div>

@if(Auth::user()->role === 'support')
<div class="card shadow-sm border-0 mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('tickets.index') }}" class="row g-3 align-items-end">
            <div class="col-md-3">
                <label class="form-label fw-semibold">Status</label>
                <select name="status" class="form-select">
                    <option value="">All Status</option>
                    <option value="Open" {{ request('status') == 'Open' ? 'selected' : '' }}>Open</option>
                    <option value="On Progress" {{ request('status') == 'On Progress' ? 'selected' : '' }}>On Progress</option>
                    <option value="Resolved" {{ request('status') == 'Resolved' ? 'selected' : '' }}>Resolved</option>
                    <option value="Closed" {{ request('status') == 'Closed' ? 'selected' : '' }}>Closed</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label fw-semibold">Category</label>
                <select name="category_id" class="form-select">
                    <option value="">All Categories</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label fw-semibold">Date</label>
                <input type="date" name="date" class="form-control" value="{{ request('date') }}">
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-secondary w-100">Filter</button>
            </div>
        </form>
    </div>
</div>
@endif

<div class="card shadow-sm border-0">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>Ticket No</th>
                    <th>Subject</th>
                    <th>Category</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($tickets as $ticket)
                <tr>
                    <td>
                        <strong>{{ $ticket->ticket_no }}</strong><br>
                        <small class="text-muted">By {{ $ticket->user->name }}</small>
                    </td>
                    <td>{{ $ticket->subject }}</td>
                    <td>{{ $ticket->category->name }}</td>
                    <td>
                        @php
                            $badgeClass = 'bg-secondary';
                            if($ticket->status == 'Open') $badgeClass = 'bg-primary';
                            if($ticket->status == 'On Progress') $badgeClass = 'bg-warning text-dark';
                            if($ticket->status == 'Resolved') $badgeClass = 'bg-success';
                        @endphp
                        <span class="badge {{ $badgeClass }}">{{ $ticket->status }}</span>
                    </td>
                    <td>{{ $ticket->created_at->format('d M Y, H:i') }}</td>
                    <td>
                        <a href="{{ route('tickets.show', $ticket) }}" class="btn btn-sm btn-outline-primary">View Details</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center text-muted py-4">No tickets found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
