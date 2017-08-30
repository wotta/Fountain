<?php

namespace App\Http\Controllers\Fountain\User;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;

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
            'password' => 'required|min:6',
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
