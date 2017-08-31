<?php

namespace App\Http\Controllers\Fountain\User;

use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SecurityController extends Controller
{
    public function password()
    {
        return view('fountain.settings.security');
    }

    public function changePassword(Request $request)
    {
        $this->validate($request, [
            'current_password' => 'required',
            'password'         => 'required|min:6',
        ]);

        $user = Auth::user();

        if (Hash::check($request->input('current_password'), $user->password)) {
            $user->password = bcrypt($request->input('password'));

            $user->save();

            return redirect()->route('fountain.settings.password')->with('status', 'Your password has been updated.');
        }

        return redirect()->route('fountain.settings.password')->with('status', 'Your password could not be updated.');
    }
}
