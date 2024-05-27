@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Add Book</div>

                    <div class="card-body">
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
                                    <option value="fiction">Fiction</option>
                                    <option value="non-fiction">Non-Fiction</option>
                                    <option value="biography">Biography</option>
                                    <option value="science">Science</option>
                                    <option value="novel">Novel</option>
                                    <option value="religion">Religion</option>
                                    <option value="academic">Academic</option>
                                    <option value="children">Children</option>
                                    <option value="general_readings">General Readings</option>
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
