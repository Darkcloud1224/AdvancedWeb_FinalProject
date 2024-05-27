@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">Borrowings</div>

                    <div class="card-body">

                        <a href="{{ route('borrowings.create') }}" class="btn btn-primary mb-3">Add Borrowing</a>

                        @if(session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif

                        <div class="mb-3">
                            <button class="btn btn-primary" id="toggleSearchBtn">Search</button>
                        </div>

                        <div id="searchForm" style="display: none;">
                            <form action="{{ route('borrowings.search') }}" method="GET">
                                <div class="form-group">
                                    <label for="searchBy">Search By:</label>
                                    <select name="searchBy" id="searchBy" class="form-control">
                                        <option value="book_id">Book ID</option>
                                        <option value="ic_number">Borrower's IC Number</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="searchTerm">Search Term:</label>
                                    <input type="text" name="searchTerm" id="searchTerm" class="form-control" placeholder="Enter search term" required>
                                </div>
                                <button type="submit" class="btn btn-primary">Search</button>
                            </form>
                        </div>

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
                                        <td>{{ $borrowing->member->name }}</td>
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

    <script>
        document.getElementById('toggleSearchBtn').addEventListener('click', function() {
            var searchForm = document.getElementById('searchForm');
            searchForm.style.display = searchForm.style.display === 'none' ? 'block' : 'none';
        });
    </script>
@endsection
