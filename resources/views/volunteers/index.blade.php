@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Volunteers</div>

                    <div class="card-body">
                        <a href="{{ route('volunteers.create') }}" class="btn btn-primary mb-3">Add Volunteer</a>

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
                                            <a href="{{ route('volunteers.edit', $volunteer->id) }}"
                                                class="btn btn-sm btn-primary">Edit</a>
                                            <form action="{{ route('volunteers.destroy', $volunteer->id) }}"
                                                method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger"
                                                    onclick="return confirm('Are you sure you want to delete this volunteer?')">Delete</button>
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
@endsection
