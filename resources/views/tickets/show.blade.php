@extends('layouts.app')

@section('content')
<div class="row">
    <!-- Left Column: Ticket Details -->
    <div class="col-md-8 mb-4">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-header bg-white border-bottom py-3 d-flex justify-content-between align-items-start">
                <div>
                    <h4 class="mb-1 fw-bold">{{ $ticket->subject }}</h4>
                    <span class="text-muted small">{{ $ticket->ticket_no }} &bull; Submitted by {{ $ticket->user->name }} on {{ $ticket->created_at->format('d M Y, H:i') }}</span>
                </div>
                @php
                    $badgeClass = 'bg-secondary';
                    if($ticket->status == 'Open') $badgeClass = 'bg-primary';
                    if($ticket->status == 'On Progress') $badgeClass = 'bg-warning text-dark';
                    if($ticket->status == 'Resolved') $badgeClass = 'bg-success';
                @endphp
                <span class="badge {{ $badgeClass }}">{{ $ticket->status }}</span>
            </div>
            
            <div class="card-body p-4">
                <h6 class="text-muted fw-bold mb-3 text-uppercase">Description</h6>
                <div class="bg-light p-3 rounded mb-4 border">
                    {!! nl2br(e($ticket->description)) !!}
                </div>

                @if(Auth::user()->role === 'support')
                <hr class="my-4">
                <h5 class="fw-bold mb-3">Update Status</h5>
                <form method="POST" action="{{ route('tickets.updateStatus', $ticket) }}">
                    @csrf
                    @method('PATCH')
                    <div class="mb-3">
                        <label class="form-label fw-semibold">New Status</label>
                        <select name="status" class="form-select w-50" required>
                            <option value="Open" {{ $ticket->status == 'Open' ? 'selected' : '' }}>Open</option>
                            <option value="On Progress" {{ $ticket->status == 'On Progress' ? 'selected' : '' }}>On Progress</option>
                            <option value="Resolved" {{ $ticket->status == 'Resolved' ? 'selected' : '' }}>Resolved</option>
                            <option value="Closed" {{ $ticket->status == 'Closed' ? 'selected' : '' }}>Closed</option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-semibold">Update Note / Response</label>
                        <textarea name="note" class="form-control" rows="3" placeholder="Add a note (e.g., 'Sedang dicek ke user')" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary fw-semibold">Update Ticket</button>
                </form>
                @endif
            </div>
        </div>
    </div>

    <!-- Right Column: History/Logs -->
    <div class="col-md-4 mb-4">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-header bg-white border-bottom py-3">
                <h5 class="mb-0 fw-bold">Ticket History</h5>
            </div>
            <div class="card-body p-4">
                <div class="timeline position-relative ps-3" style="border-left: 2px solid #dee2e6;">
                    @foreach($ticket->logs->sortByDesc('created_at') as $log)
                    <div class="mb-4 position-relative">
                        <div class="position-absolute" style="left: -1.45rem; top: 0.25rem; width: 0.75rem; height: 0.75rem; border-radius: 50%; background-color: #0d6efd;"></div>
                        <div class="small mb-1">
                            <strong>{{ $log->user->name }}</strong> 
                            @if($log->action === 'created')
                                created this ticket
                            @else
                                changed status from <span class="badge bg-secondary">{{ $log->status_from }}</span> to <span class="badge bg-primary">{{ $log->status_to }}</span>
                            @endif
                            <br>
                            <span class="text-muted" style="font-size: 0.8rem;">{{ $log->created_at->diffForHumans() }}</span>
                        </div>
                        @if($log->note)
                            <div class="bg-light p-2 rounded small mt-2 border-start border-primary border-3">
                                {{ $log->note }}
                            </div>
                        @endif
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
