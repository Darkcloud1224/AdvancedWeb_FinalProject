@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Edit Borrowing</div>

                    <div class="card-body">
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
