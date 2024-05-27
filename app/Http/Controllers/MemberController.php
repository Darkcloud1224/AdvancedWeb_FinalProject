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

        return redirect()->route('members.index')->with('success', 'New member has been added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Member $member)
    {
        return view('members.show', compact('member'));
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

        return redirect()->route('members.index')->with('success', 'Member record has been updated successfully');
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
        return redirect()->route('members.index')->with('success', 'Member record has been deleted successfully.');
    }
}
