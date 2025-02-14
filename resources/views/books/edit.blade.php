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
                    <div class="card-header">Edit Book</div>

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
                                        toast.style.top = `${index * 60}px`; 
                                        setTimeout(() => {
                                            toast.classList.add('show');
                                            setTimeout(() => {
                                                toast.classList.remove('show');
                                            }, 8000); 
                                        }, index * 500); 
                                    });
                                });
                            </script>
                        @endif
                        <form action="{{ route('books.update', $book->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="title">Title</label>
                                <input type="text" name="title" id="title" class="form-control"
                                    value="{{ $book->title }}" required>
                            </div>
                            <div class="form-group">
                                <label for="author">Author</label>
                                <input type="text" name="author" id="author" class="form-control"
                                    value="{{ $book->author }}" required>
                            </div>
                            <div class="form-group">
                                <label for="publisher">Publisher</label>
                                <input type="text" name="publisher" id="publisher" class="form-control"
                                    value="{{ $book->publisher }}" required>
                            </div>
                            <div class="form-group">
                                <label for="published_year">Published Year</label>
                                <input type="number" name="published_year" id="published_year" class="form-control"
                                    value="{{ $book->published_year }}" required>
                            </div>
                            <div class="form-group">
                                <label for="category">Category</label>
                                <select name="category" id="category" class="form-control" required>
                                    <option value="" disabled>Select Category</option>
                                    <option value="Biography" {{ $book->category === 'Biography' ? 'selected' : '' }}>Biography</option>
                                    <option value="Science" {{ $book->category === 'Science' ? 'selected' : '' }}>Science</option>
                                    <option value="Novel" {{ $book->category === 'Novel' ? 'selected' : '' }}>Novel</option>
                                    <option value="Religion" {{ $book->category === 'Religion' ? 'selected' : '' }}>Religion</option>
                                    <option value="Academic" {{ $book->category === 'Academic' ? 'selected' : '' }}>Academic</option>
                                    <option value="Children" {{ $book->category === 'Children' ? 'selected' : '' }}>Children</option>
                                    <option value="General_Readings" {{ $book->category === 'General_Readings' ? 'selected' : '' }}>General Readings</option>
                                </select>
                            </div>
                            
                            <button type="submit" class="btn btn-primary">Update Book</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
