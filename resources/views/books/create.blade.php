@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Add Book</div>

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
                        <form action="{{ route('books.store') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="title">Title</label>
                                <input type="text" name="title" id="title" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="author">Author</label>
                                <input type="text" name="author" id="author" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="publisher">Publisher</label>
                                <input type="text" name="publisher" id="publisher" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="published_year">Published Year</label>
                                <input type="number" name="published_year" id="published_year" class="form-control" required min="1000" max="{{ date('Y') }}" step="1">
                            </div>
                            <div class="form-group">
                                <label for="category">Category</label>
                                <select name="category" id="category" class="form-control" required>
                                    <option value="" disabled selected>Select Category</option>
                                    <option value="Biography">Biography</option>
                                    <option value="Science">Science</option>
                                    <option value="Novel">Novel</option>
                                    <option value="Religion">Religion</option>
                                    <option value="Academic">Academic</option>
                                    <option value="Children">Children</option>
                                    <option value="General_Readings">General Readings</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">Add Book</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
