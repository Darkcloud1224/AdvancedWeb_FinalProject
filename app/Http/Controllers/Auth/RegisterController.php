<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    use RegistersUsers;

    protected $redirectTo = '/home';

    public function __construct()
    {
        $this->middleware('guest');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'ic_number' => ['required', 'string', 'unique:members,ic_number'],
            'address' => ['required', 'string', 'max:255'],
            'contact' => ['required', 'string', 'max:15'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:members,email', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    protected function create(array $data)
    {
        // Create the member
        $member = Member::create([
            'name' => $data['name'],
            'ic_number' => $data['ic_number'],
            'address' => $data['address'],
            'contact' => $data['contact'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        // Create the user
        $user = User::create([
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'roles' => 'member',
        ]);

        return $user;
    }
}
