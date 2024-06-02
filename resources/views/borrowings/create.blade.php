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
                    <div class="card-header">Add Borrowing</div>

                    <div class="card-body">
                        <form action="{{ route('borrowings.store') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="book_id">Book</label>
                                <select name="book_id" id="book_id" class="form-control" required>
                                    @foreach ($books as $book)
                                        <option value="{{ $book->id }}">{{ $book->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="member_id">Borrower</label>
                                <select name="member_id" id="member_id" class="form-control" required>
                                    @foreach ($members as $member)
                                        <option value="{{ $member->id }}">{{ $member->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="borrowing_date">Borrowing Date</label>
                                <input type="date" name="borrowing_date" id="borrowing_date" class="form-control" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Add Borrowing</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
