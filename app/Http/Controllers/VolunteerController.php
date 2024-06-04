<?php

namespace App\Http\Controllers;

use App\Models\Volunteer;
use App\Models\User;
use App\Models\Member;
use App\Models\Book;
use App\Models\Borrowing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class VolunteerController extends Controller
{
    public function dashboard()
    {
        $members = Member::all();
        $books = Book::all();
        $borrowings = Borrowing::with(['member', 'book'])->get();

        return view('volunteers.landing', compact('members', 'books', 'borrowings'));
    }

    public function index()
    {
        $volunteers = Volunteer::all();
        return view('volunteers.landing', compact('volunteers'));
    }

    public function create()
    {
        return view('volunteers.create');
    }

    public function store(Request $request)
    {

        $newVolunteer = new Volunteer;
        $newVolunteer->name = $request->name;
        $newVolunteer->email = $request->email;
        $newVolunteer->ic_no = $request->ic_no;
        $newVolunteer->password = Hash::make($request->password); 
        $newVolunteer->save();

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'roles' => 'volunteer',
        ]);

        return redirect()->route('volunteers.index')->with('success', 'New Volunteer has been added successfully');
    }

    public function show(Volunteer $volunteer)
    {
        return view('volunteers.show', compact('volunteer'));
    }

    public function edit(Volunteer $volunteer)
    {
        return view('volunteers.edit', compact('volunteer'));
    }

    public function update(Request $request, Volunteer $volunteer)
    {
        $volunteer->name = $request->name;
        $volunteer->email = $request->email;
        $volunteer->ic_no = $request->ic_no;
        if ($request->filled('password')) {
            $volunteer->password = Hash::make($request->password); // Encrypt password
        }
        $volunteer->save();

        $user = User::where('email', $volunteer->email)->first();
        if ($user) {
            $user->email = $request->email;
            if ($request->filled('password')) {
                $user->password = Hash::make($request->password);
            }
            $user->save();
        }

        return redirect()->route('volunteers.index')->with('success', 'Volunteer record has been updated successfully');
    }

    public function destroy(Volunteer $volunteer)
    {
        $user = User::where('email', $volunteer->email)->first();
        if ($user) {
            $user->delete();
        }

        $volunteer->delete();
        return redirect()->route('volunteers.index')->with('success', 'Volunteer record has been deleted successfully.');
    }
}
