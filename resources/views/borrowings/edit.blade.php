@extends('layouts.app')

@section('content')
<style>
    /* Global Styles */
    * {
        padding: 0;
        margin: 0;
        box-sizing: border-box;
        font-family: sans-serif;
    }
    body {
        background: #23242a;
        color: #fff;
    }
    .card {
        background: #28292d;
        color: #fff;
        margin-top: 20px;
    }
    .card-header {
        background: #1c1c1c;
        border-bottom: 1px solid #333;
        color: #45f3ff;
    }
    .card-body {
        padding: 1.25rem;
    }
    .btn-primary {
        background-color: #3bb3f2;
        border-color: #3bb3f2;
    }
    .btn-primary:hover {
        background-color: #45f3ff;
        border-color: #45f3ff;
    }
    .form-group label {
        color: #45f3ff;
    }
    .form-control {
        background-color: #1c1c1c;
        color: #fff;
        border-color: #444;
    }
    .form-control:focus {
        background-color: #1c1c1c;
        color: #fff;
        border-color: #45f3ff;
        box-shadow: 0 0 0 0.2rem rgba(69, 243, 255, 0.25);
    }
</style>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Edit Borrowing</div>

                    <div class="card-body">
                        @if ($errors->any())
                            <div id="toast-container">
                                @foreach ($errors->all() as $error)
                                    <div class="toast">{{ $error }}</div>
                                @endforeach
                            </div>
                            <script>
                                document.addEventListener('DOMContentLoaded', function() {
                                    const toasts = document.querySelectorAll('.toast');
                                    toasts.forEach((toast, index) => {
                                        toast.style.top = `${index * 60}px`; // Adjust this value to increase/decrease spacing between toasts
                                        setTimeout(() => {
                                            toast.classList.add('show');
                                            setTimeout(() => {
                                                toast.classList.remove('show');
                                            }, 8000); // Hide after 8 seconds
                                        }, index * 500); // Staggered appearance
                                    });
                                });
                            </script>
                        @endif
                        <form action="{{ route('borrowings.update', $borrowing->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="book_id">Book</label>
                                <select name="book_id" id="book_id" class="form-control" required>
                                    @foreach ($books as $book)
                                        <option value="{{ $book->id }}"
                                            {{ $book->id == $borrowing->book_id ? 'selected' : '' }}>{{ $book->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="member_id">Borrower</label>
                                <select name="member_id" id="member_id" class="form-control" required>
                                    @foreach ($members as $member)
                                        <option value="{{ $member->id }}"
                                            {{ $member->id == $borrowing->member_id ? 'selected' : '' }}>{{ $member->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="borrowing_date">Borrowing Date</label>
                                <input type="date" name="borrowing_date" id="borrowing_date" class="form-control"
                                    value="{{ $borrowing->borrowing_date }}" required>
                            </div>
                            <div class="form-group">
                                <label for="returning_date">Returning Date</label>
                                <input type="date" name="returning_date" id="returning_date" class="form-control"
                                    value="{{ $borrowing->returning_date }}">
                            </div>
                            <button type="submit" class="btn btn-primary">Update Borrowing</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
