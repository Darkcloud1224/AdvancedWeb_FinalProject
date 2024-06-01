@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Edit Member</div>

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
                        <form action="{{ route('supervisor.members.update', $member->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" name="name" id="name" class="form-control"
                                    value="{{ $member->name }}" required>
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" name="email" id="email" class="form-control" 
                                    value="{{ $member->email }}"required>
                            </div>  
                            <div class="form-group">
                                <label for="ic_number">IC Number</label>
                                <input type="text" name="ic_number" id="ic_number" class="form-control"
                                    value="{{ $member->ic_number }}" required>
                            </div>
                            <div class="form-group">
                                <label for="address">Address</label>
                                <textarea name="address" id="address" class="form-control" rows="3"
                                    required>{{ $member->address }}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="contact">Contact</label>
                                <input type="text" name="contact" id="contact" class="form-control"
                                    value="{{ $member->contact }}" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Update Member</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
