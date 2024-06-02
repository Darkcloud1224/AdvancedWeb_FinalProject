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

    /* Tab Styles */
    .nav-tabs .nav-link {
        color: #45f3ff;
        border: none;
        border-bottom: 2px solid transparent;
    }
    .nav-tabs .nav-link.active {
        border-color: #45f3ff;
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

    /* Modal Styles */
    .modal-content {
        background: #1c1c1c;
        color: #fff;
    }
    .modal-header {
        border-bottom: 1px solid #333;
        background: #1c1c1c;
        color: #45f3ff;
    }
    .modal-body {
        padding: 1.25rem;
    }
    .modal-footer {
        border-top: 1px solid #333;
        background: #1c1c1c;
    }
</style>
    <div class="container">
        <ul class="nav nav-tabs" id="volunteerTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="members-tab" data-toggle="tab" href="#members" role="tab"
                    aria-controls="members" aria-selected="true">Members</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="books-tab" data-toggle="tab" href="#books" role="tab"
                    aria-controls="books" aria-selected="false">Books</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="borrowings-tab" data-toggle="tab" href="#borrowings" role="tab"
                    aria-controls="borrowings" aria-selected="false">Borrowings</a>
            </li>
        </ul>

        <div class="tab-content mt-3" id="volunteerTabContent">
            <div class="tab-pane fade show active" id="members" role="tabpanel" aria-labelledby="members-tab">
                <div class="row justify-content-center">
                    <div class="col-md-10">
                        <div class="card">
                            <div class="card-header">Members</div>
                            <div class="card-body">
                                <a href="{{ route('members.create') }}" class="btn btn-primary mb-3">Add Member</a>
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>IC Number</th>
                                            <th>Contact Number</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($members as $member)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $member->name }}</td>
                                                <td>{{ $member->email }}</td>
                                                <td>{{ $member->ic_number }}</td>
                                                <td>{{ $member->contact }}</td>
                                                <td>
                                                    <a href="{{ route('members.edit', $member->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                                    <button class="btn btn-sm btn-info" data-toggle="modal" data-target="#viewMemberModal" data-id="{{ $member->id }}">View</button>
                                                    <form id="deleteForm{{ $member->id }}" action="{{ route('members.destroy', $member->id) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this volunteer?')">Delete</button>
                                                        @if($member->borrowings()->count() > 0)
                                                            <div class="form-check mt-2">
                                                                <input type="checkbox" name="delete_borrowings" id="delete_borrowings" class="form-check-input">
                                                                <label for="delete_borrowings" class="form-check-label">Delete Borrowings</label>
                                                            </div>
                                                        @endif
                                                    </form>
                                                                                                    
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="tab-pane fade" id="books" role="tabpanel" aria-labelledby="books-tab">
                <div class="row justify-content-center">
                    <div class="col-md-10">
                        <div class="card">
                            <div class="card-header">Books</div>
                            <div class="card-body">
                                <a href="{{ route('books.create') }}" class="btn btn-primary mb-3">Add Book</a>
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Title</th>
                                            <th>Author</th>
                                            <th>Publisher</th>
                                            <th>Publisher Year</th>
                                            <th>Category</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($books as $book)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $book->title }}</td>
                                                <td>{{ $book->author }}</td>
                                                <td>{{ $book->publisher }}</td>
                                                <td>{{ $book->published_year }}</td>
                                                <td>{{ $book->category }}</td>
                                                <td>
                                                    <a href="{{ route('books.edit', $book->id) }}"
                                                        class="btn btn-sm btn-primary">Edit</a>
                                                        <form id="deleteBookForm" action="{{ route('books.destroy', $book->id) }}" method="POST" class="d-inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this book?')">Delete</button>
                                                            @if($book->borrowings()->count() > 0)
                                                                <div class="form-check mt-2">
                                                                    <input type="checkbox" name="delete_borrowings" id="delete_borrowings" class="form-check-input">
                                                                    <label for="delete_borrowings" class="form-check-label">Delete Borrowings</label>
                                                                </div>
                                                            @endif
                                                        </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="tab-pane fade" id="borrowings" role="tabpanel" aria-labelledby="borrowings-tab">
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
                                            <th>No</th>
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
                                                    <td>{{ $borrowing->book_title }}</td>
                                                    <td>{{ $borrowing->member_name }}</td>
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
            </div>
        </div>

        <div class="modal fade" id="viewMemberModal" tabindex="-1" role="dialog" aria-labelledby="viewMemberModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="viewMemberModalLabel">Member Details</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p><strong>Name:</strong> <span id="memberName"></span></p>
                        <p><strong>Email:</strong> <span id="memberEmail"></span></p>
                        <p><strong>IC Number:</strong> <span id="memberICNumber"></span></p>
                        <hr>
                        <h5>Borrowing History</h5>
                        <ul id="borrowingHistory"></ul>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    
        <script>
            $(document).ready(function() {
                $('#volunteerTab a').on('click', function (e) {
                    e.preventDefault();
                    $(this).tab('show');
                });
            });
    
            document.getElementById('toggleSearchBtn').addEventListener('click', function() {
                var searchForm = document.getElementById('searchForm');
                searchForm.style.display = searchForm.style.display === 'none' ? 'block' : 'none';
            });

            $('#viewMemberModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var memberId = button.data('id');

            $.ajax({
                url: '/members/' + memberId,
                method: 'GET',
                success: function(data) {
                    $('#memberName').text(data.member.name);
                    $('#memberEmail').text(data.member.email);
                    $('#memberICNumber').text(data.member.ic_number);
                    $('#borrowingHistory').empty();
                    data.borrowings.forEach(function(borrowing) {
                        $('#borrowingHistory').append('<li>' + borrowing.book.title + ' (Borrowed on: ' + borrowing.borrowing_date + ')</li>');
                    });
                }
            });
        });
        </script>
    @endsection
