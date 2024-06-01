<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $members = Member::all();
        return view('members.index', compact('members'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('members.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:members',
            'ic_number' => 'required|string|min:12|max:12|unique:members,ic_number',
            'address' => 'required|string|max:255',
            'contact' => 'required|string|max:15',
            'password' => 'required|string|min:8|confirmed',
        ], [
            'ic_number.unique' => 'The IC number has already been taken.',
            'ic_number.max' => 'The IC number must be exactly 12 characters long.',
            'ic_number.min' => 'The IC number must be exactly 12 characters long.',
        ]);

        $newMember = new Member;
        $newMember->name = $request->name;
        $newMember->ic_number = $request->ic_number;
        $newMember->address = $request->address;
        $newMember->contact = $request->contact;
        $newMember->email = $request->email;
        $newMember->password = Hash::make($request->password);
        $newMember->save();

        User::create([
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'roles' => 'member',
        ]);

        return redirect()->route('volunteer.dashboard')->with('success', 'New member has been added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Member $member)
    {
        $borrowings = $member->borrowings()->with('book')->get();
        return response()->json([
            'member' => $member,
            'borrowings' => $borrowings
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Member $member)
    {
        return view('members.edit', compact('member'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Member $member)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:members,email,' . $member->id,
            'ic_number' => 'required|string|min:12|max:12|unique:members,ic_number,' . $member->id,
            'address' => 'required|string|max:255',
            'contact' => 'required|string|max:15',
            'password' => 'nullable|string|min:8|confirmed',
        ], [
            'ic_number.unique' => 'The IC number has already been taken.',
            'ic_number.max' => 'The IC number must be exactly 12 characters long.',
            'ic_number.min' => 'The IC number must be exactly 12 characters long.',
        ]);

        $member->name = $request->name;
        $member->ic_number = $request->ic_number;
        $member->address = $request->address;
        $member->contact = $request->contact;
        $member->email = $request->email;
        $member->password = Hash::make($request->password);
        $member->save();

        $user = User::where('email', $member->email)->first();
        if ($user) {
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->save();
        }

        return redirect()->route('volunteer.dashboard')->with('success', 'Member record has been updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Member $member)
    {
        $user = User::where('email', $member->email)->first();
        if ($user) {
            $user->delete();
        }

        $member->delete();
        return redirect()->route('volunteer.dashboard')->with('success', 'Member record has been deleted successfully.');
    }
}
