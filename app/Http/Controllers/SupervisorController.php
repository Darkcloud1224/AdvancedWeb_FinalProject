<?php

namespace App\Http\Controllers;

use App\Models\Volunteer;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SupervisorController extends Controller
{
    public function index()
    {
        $volunteers = Volunteer::all();
        $members = Member::all();
        return view('supervisor.index', compact('volunteers', 'members'));
    }

    // CRUD functions for volunteers

    public function createVolunteer()
    {
        return view('supervisor.volunteer.create');
    }

    public function storeVolunteer(Request $request)
    {
        Volunteer::create([
            'name' => $request->name,
            'email' => $request->email,
            'ic_no' => $request->ic_no,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('supervisor.index')->with('success', 'New volunteer has been added successfully');
    }

    public function editVolunteer(Volunteer $volunteer)
    {
        return view('supervisor.index', compact('volunteer'));
    }

    public function updateVolunteer(Request $request, Volunteer $volunteer)
    {

        $data = $request->only(['name', 'email', 'ic_no']);
        if ($request->password) {
            $data['password'] = Hash::make($request->password);
        }

        $volunteer->update($data);

        return redirect()->route('supervisor.index')->with('success', 'Volunteer details have been updated successfully');
    }

    public function destroyVolunteer(Volunteer $volunteer)
    {
        $volunteer->delete();
        return redirect()->route('supervisor.index')->with('success', 'Volunteer has been deleted successfully');
    }

    // CRUD functions for members

    public function createMember()
    {
        return view('supervisor.member.create');
    }

    public function storeMember(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:members',
            'ic_number' => 'required|string|max:20',
            'address' => 'required|string|max:255',
            'contact' => 'required|string|max:15',
            'password' => 'required|string|min:8|confirmed',
        ]);

        Member::create([
            'name' => $request->name,
            'email' => $request->email,
            'ic_number' => $request->ic_number,
            'address' => $request->address,
            'contact' => $request->contact,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('supervisor.index')->with('success', 'New member has been added successfully');
    }

    public function editMember(Member $member)
    {
        return view('supervisor.edit_member', compact('member'));
    }

    public function updateMember(Request $request, Member $member)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:members,email,' . $member->id,
            'ic_number' => 'required|string|max:20',
            'address' => 'required|string|max:255',
            'contact' => 'required|string|max:15',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $data = $request->only(['name', 'email', 'ic_number', 'address', 'contact']);
        if ($request->password) {
            $data['password'] = Hash::make($request->password);
        }

        $member->update($data);

        return redirect()->route('supervisor.index')->with('success', 'Member details have been updated successfully');
    }

    public function destroyMember(Member $member)
    {
        $member->delete();
        return redirect()->route('supervisor.index')->with('success', 'Member has been deleted successfully');
    }
}
