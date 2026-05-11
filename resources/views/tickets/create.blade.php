@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white border-bottom py-3 d-flex justify-content-between align-items-center">
                <h4 class="mb-0 fw-bold">Submit New Ticket</h4>
                <a href="{{ route('tickets.index') }}" class="btn btn-sm btn-outline-secondary">Back</a>
            </div>

            <div class="card-body p-4">
                <form method="POST" action="{{ route('tickets.store') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Category</label>
                        <select name="category_id" class="form-select" required>
                            <option value="">Select Category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Subject</label>
                        <input type="text" name="subject" class="form-control" placeholder="Brief description of the issue" required>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold">Description / Detail</label>
                        <textarea name="description" class="form-control" rows="6" placeholder="Provide detailed information..." required></textarea>
                    </div>

                    <div class="text-end">
                        <button type="submit" class="btn btn-primary px-4 fw-semibold">Submit Ticket</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
