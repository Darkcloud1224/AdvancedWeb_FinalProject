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
    }
    .container {
        margin-top: 20px;
    }

    /* Card Styles */
    .card {
        background: #28292d;
        color: #fff;
    }
    .card-header {
        background: #1c1c1c;
        border-bottom: 1px solid #333;
        color: #45f3ff;
    }
    .card-body {
        padding: 1.25rem;
    }
    .btn:hover {
        background-color: #3bb3f2;
    }

    /* Table Styles */
    .table {
        background: #000;
        color: #45f3ff;
    }
    .table th {
        border-color: #333;
        color: #45f3ff;
    }
    .table td {
        border-color: #444;
        color: #45f3ff;
    }
    .table th,
    .table td {
        padding: 0.75rem;
    }

</style>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">Borrowings</div>

                    <div class="card-body">
                        <a href="{{ url()->previous() }}" class="btn btn-primary mb-3">Back</a>

                        <table class="table mt-3">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Book Title</th>
                                    <th>Borrower Name</th>
                                    <th>Borrowing Date</th>
                                    <th>Returning Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($borrowings as $borrowing)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $borrowing->book->title }}</td>
                                        <td>{{ $borrowing->member ? $borrowing->member->name : 'N/A' }}</td>
                                        <td>{{ $borrowing->borrowing_date }}</td>
                                        <td>{{ $borrowing->returning_date }}</td>
                                        <td>
                                            <a href="{{ route('borrowings.edit', $borrowing->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                            <form action="{{ route('borrowings.destroy', $borrowing->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this borrowing?')">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6">No borrowings found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
