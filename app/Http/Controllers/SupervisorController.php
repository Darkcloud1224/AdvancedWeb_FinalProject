<?php

namespace App\Http\Controllers;

use App\Models\Volunteer;
use App\Models\Member;
use App\Models\User;
use Illuminate\Validation\ValidationException;
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


    public function createVolunteer()
    {
        return view('supervisor.volunteer.create');
    }

    public function storeVolunteer(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:volunteers',
            'ic_no' => 'required|string|min:12|max:12|unique:volunteers,ic_no',
            'password' => 'required|string|min:8|confirmed',
        ], [
            'ic_no.unique' => 'The IC number has already been taken.',
            'ic_no.max' => 'The IC number must be exactly 12 characters long.',
            'ic_no.min' => 'The IC number must be exactly 12 characters long.',
        ]);

        $newVolunteer = new Volunteer;
        $newVolunteer->name = $request->name;
        $newVolunteer->email = $request->email;
        $newVolunteer->ic_no = $request->ic_no;
        $newVolunteer->password = Hash::make($request->password); 
        $newVolunteer->save();

        User::create([
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'roles' => 'volunteer',
        ]);

        return redirect()->route('supervisor.index')->with('success', 'New volunteer has been added successfully');
    }

    public function editVolunteer(Volunteer $volunteer)
    {
        return view('supervisor.volunteer.edit', compact('volunteer'));
    }


public function updateVolunteer(Request $request, Volunteer $volunteer)
{
    try {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:volunteers,email,' . $volunteer->id,
            'ic_no' => 'required|string|min:12|max:12|unique:volunteers,ic_no,' . $volunteer->id,
            'password' => 'nullable|string|min:8',
        ], [
            'ic_no.unique' => 'The IC number has already been taken.',
            'ic_no.max' => 'The IC number must be exactly 12 characters long.',
            'ic_no.min' => 'The IC number must be exactly 12 characters long.',
        ]);
        

        $volunteer->name = $request->name;
        $volunteer->email = $request->email;
        $volunteer->ic_no = $request->ic_no;
        if ($request->filled('password')) {
            $volunteer->password = Hash::make($request->password); 
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

        return redirect()->route('supervisor.index')->with('success', 'Volunteer details have been updated successfully');
    } catch (ValidationException $exception) {
        if ($exception->errors()['ic_no'][0] === 'The ic no must not be greater than 20 characters.') {
            return redirect()->back()->withErrors(['ic_no' => 'The IC number is too long. Please make sure it is not more than 20 characters.']);
        } else {
            throw $exception; // Re-throw the exception if it's not related to the IC number length
        }
    }
}



    public function destroyVolunteer(Volunteer $volunteer)
    {
        $volunteer->delete();
        return redirect()->route('supervisor.index')->with('success', 'Volunteer has been deleted successfully');
    }


    public function createMember()
    {
        return view('supervisor.member.create');
    }

    public function storeMember(Request $request)
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

        return redirect()->route('supervisor.index')->with('success', 'New member has been added successfully');
    }

    public function editMember(Member $member)
    {
        return view('supervisor.member.edit', compact('member'));
    }

    public function updateMember(Request $request, Member $member)
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

        return redirect()->route('supervisor.index')->with('success', 'Member details have been updated successfully');
    }

    public function destroyMember(Member $member)
    {
        $member->delete();
        return redirect()->route('supervisor.index')->with('success', 'Member has been deleted successfully');
    }
}
