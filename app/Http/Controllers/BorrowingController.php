<?php

namespace App\Http\Controllers;

use App\Models\Borrowing;
use App\Models\Book;
use App\Models\Member;
use Illuminate\Http\Request;

class BorrowingController extends Controller
{
    public function index()
    {
        $borrowings = Borrowing::with('book', 'member')->get();
        return view('borrowings.index', compact('borrowings'));
    }

    public function create()
    {
        $books = Book::where('is_available', true)->get();
        $members = Member::all();
        return view('borrowings.create', compact('books', 'members'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'book_id' => 'required|exists:books,id',
            'member_id' => 'required|exists:members,id',
            'borrowing_date' => 'required|date',
        ]);

        $borrowing = Borrowing::create($request->all());

        $book = Book::find($request->book_id);
        $book->is_available = false;
        $book->save();

        return redirect()->route('volunteer.dashboard')->with('success', 'Borrowing added successfully.');
    }

    public function edit(Borrowing $borrowing)
    {
        $books = Book::all();
        $members = Member::all();
        return view('borrowings.edit', compact('borrowing', 'books', 'members'));
    }

    public function update(Request $request, Borrowing $borrowing)
    {
        $request->validate([
            'book_id' => 'required|exists:books,id',
            'member_id' => 'required|exists:members,id',
            'borrowing_date' => 'required|date',
            'returning_date' => 'nullable|date|after:borrowing_date',
        ], [
            'returning_date.after' => 'Returning date must be after the borrowing date.',
        ]);

        $borrowing->update($request->all());

        if ($request->returning_date) {
            $book = Book::find($request->book_id);
            $book->is_available = true;
            $book->save();
        }

        return redirect()->route('volunteer.dashboard')->with('success', 'Borrowing updated successfully.');
    }

    public function destroy(Borrowing $borrowing)
    {
        $borrowing->delete();
        return redirect()->route('volunteer.dashboard')->with('success', 'Borrowing deleted successfully.');
    }

    public function search(Request $request)
    {
        $searchBy = $request->input('searchBy');
        $searchTerm = $request->input('searchTerm');

        $borrowings = Borrowing::query()
            ->when($searchBy === 'book_id', function ($query) use ($searchTerm) {
                $query->where('book_id', $searchTerm);
            })
            ->when($searchBy === 'ic_number', function ($query) use ($searchTerm) {
                $query->whereHas('member', function ($query) use ($searchTerm) {
                    $query->where('ic_number', $searchTerm);
                });
            })
            ->with('book', 'member')
            ->get();

        if ($borrowings->isEmpty()) {
            return redirect()->route('volunteer.dashboard')->with('error', 'No borrowing record found for the given criteria.');
        } else {
            return view('borrowings.index', compact('borrowings'));
        }
    }

    public function show(Borrowing $borrowing)
    {
        return view('borrowings.show', compact('borrowing'));
    }
}
