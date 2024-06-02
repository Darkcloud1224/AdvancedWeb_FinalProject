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
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="volunteers-tab" data-toggle="tab" href="#volunteers" role="tab"
                    aria-controls="volunteers" aria-selected="true">Volunteers</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="members-tab" data-toggle="tab" href="#members" role="tab"
                    aria-controls="members" aria-selected="false">Members</a>
            </li>
        </ul>

        <div class="tab-content mt-3" id="myTabContent">
            <div class="tab-pane fade show active" id="volunteers" role="tabpanel" aria-labelledby="volunteers-tab">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header">Volunteers</div>
                            <div class="card-body">
                                <a href="{{ route('supervisor.volunteers.create') }}" class="btn btn-primary mb-3">Add Volunteer</a>
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>IC Number</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($volunteers as $volunteer)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $volunteer->name }}</td>
                                                <td>{{ $volunteer->email }}</td>
                                                <td>{{ $volunteer->ic_no }}</td>
                                                <td>
                                                    <a href="{{ route('supervisor.volunteers.edit', $volunteer->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                                    <form action="{{ route('supervisor.volunteers.destroy', $volunteer->id) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this volunteer?')">Delete</button>
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

            <div class="tab-pane fade" id="members" role="tabpanel" aria-labelledby="members-tab">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header">Members</div>
                            <div class="card-body">
                                <a href="{{ route('supervisor.members.create') }}" class="btn btn-primary mb-3">Add Member</a>
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>IC Number</th>
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
                                                <td>
                                                    <a href="{{ route('supervisor.members.edit', $member->id) }}" class="btn btn-sm btn-primary">Edit</a>
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
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#myTab a').on('click', function (e) {
                e.preventDefault();
                $(this).tab('show');
            });
        });
    </script>
@endsection
