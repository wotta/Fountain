<?php

namespace App\Http\Controllers\Fountain\Admin;

use App\Http\Requests\Fountain\Admin\CreateUserRequest;
use App\Http\Requests\Fountain\Admin\UpdateUserRequest;
use App\User;
use Auth;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Artisan;

class UsersController extends Controller
{
    use SendsPasswordResetEmails;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();

        return view('fountain.admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('fountain.admin.users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateUserRequest|Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateUserRequest $request)
    {
        Artisan::call('fountain:make-user', [
            'email' => $request->email, '--name' => $request->name
        ]);

        $this->sendResetLinkEmail($request);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param User $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return view('fountain.admin.users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateUserRequest $request
     * @param User $user
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $user->update($request->all());

        return redirect()->route('fountain.admin.users.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->back();
    }

    /**
     * Unsubscribe the user from a plan.
     *
     * @param User $user
     * @param $plan
     * @return \Illuminate\Http\RedirectResponse
     */
    public function unsubscribe(User $user, $plan)
    {
        $user->subscription($plan)->cancel();

        return redirect()->back();
    }
    /**
     * Login as the selected user.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function login($id)
    {
        $user = User::find($id);

        Auth::login($user);

        return redirect()->route('home');
    }
}
