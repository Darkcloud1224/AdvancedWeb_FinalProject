@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Edit Volunteer</div>

                    <div class="card-body">
                        <form action="{{ route('supervisor.volunteers.update', $volunteer->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" name="name" id="name" class="form-control"
                                    value="{{ $volunteer->name }}" required>
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" name="email" id="email" class="form-control"
                                    value="{{ $volunteer->email }}" required>
                            </div>
                            <div class="form-group">
                                <label for="ic_no">IC Number</label>
                                <input type="text" name="ic_no" id="ic_no" class="form-control"
                                    value="{{ $volunteer->ic_no }}" required>
                            </div>
                            
                            <button type="submit" class="btn btn-primary">Update Volunteer</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
