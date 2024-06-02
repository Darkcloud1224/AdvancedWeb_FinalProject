<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Borrowing;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;


class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $books = Book::all();
        return view('volunteer.dashboard', compact('books'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('books.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => [
                'required',
                'string',
                'max:255',
                Rule::unique('books')->where(function ($query) use ($request) {
                    return $query->where('author', $request->author)
                                 ->where('publisher', $request->publisher)
                                 ->where('published_year', $request->published_year);
                }),
            ],
            'author' => 'required|string|max:255',
            'publisher' => 'required|string|max:255',
            'published_year' => 'required|integer|min:1000|max:'.date('Y'),
            'category' => 'required|string|max:255',
        ]);
        $newBook = new Book;
        $newBook->title = $request->title;
        $newBook->author = $request->author;
        $newBook->publisher = $request->publisher;
        $newBook->published_year = $request->published_year;
        $newBook->category = $request->category;
        $newBook->save();

        return redirect()->route('volunteer.dashboard')->with('success', 'New book has been added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Book $book)
    {
        return view('books.show', compact('book'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Book $book)
    {
        return view('books.edit', compact('book'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Book $book)
    {
        $request->validate([
            'title' => [
                'required',
                'string',
                'max:255',
                Rule::unique('books')->ignore($book->id)->where(function ($query) use ($request) {
                    return $query->where('author', $request->author)
                                 ->where('publisher', $request->publisher)
                                 ->where('published_year', $request->published_year);
                }),
            ],
            'author' => 'required|string|max:255',
            'publisher' => 'required|string|max:255',
            'published_year' => 'required|integer|min:1000|max:'.date('Y'),
            'category' => 'required|string|max:255',
        ]);
        $book->title = $request->title;
        $book->author = $request->author;
        $book->publisher = $request->publisher;
        $book->published_year = $request->published_year;
        $book->category = $request->category;
        $book->save();

        return redirect()->route('volunteer.dashboard')->with('success', 'Book record has been updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book)
    {
        if ($book->borrowings->isNotEmpty()) {
            $confirmDelete = false;
            if (request()->has('delete_borrowings') && request()->input('delete_borrowings') === 'on') {
                $confirmDelete = true;
            } else {
                session()->flash('warning', 'Book has associated borrowings. Delete borrowings before deleting the book.');
            }

            if ($confirmDelete) {
                Borrowing::where('book_id', $book->id)->delete();
            }
        }
        
        $book->delete();

        return redirect()->route('volunteer.dashboard')->with('success', 'Book has been deleted successfully.');
    }
}
