<?php

namespace App\Http\Controllers\Fountain\User;

use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index()
    {
        return view('fountain.settings.index');
    }

    /**
     * update user name and email from client side.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //Get the logged in user
        $user = Auth::user();

        $this->validate($request, [
            'name'     => 'required|max:225',
            'email'    => 'required|unique:users,email,'.$user->id,
        ]);

        $user->name = $request->input('name');
        $user->email = $request->input('email');

        $user->save();

        return response()->json(['status' => 'success', 'reply' => 'Your contact information has been updated.']);
    }

    /**
     * update user avatar.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function changeAvatar(Request $request)
    {
        //Get the logged in user
        $user = Auth::user();

        $this->validate($request, [
            'avatar'     => 'max:500|mimes:jpeg,png|dimensions:max_width=512,max_height=512',
        ]);

        $user->avatar = $request->file('avatar')->store('avatars', 'public');

        $user->save();

        return response()->json(['status' => 'success', 'location' => $user->avatar]);
    }
}
