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
                    <div class="card-header">Edit Volunteer</div>

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
