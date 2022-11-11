<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View as ViewType;

class UserV1Controller extends Controller
{

    public function index(Request $request): ViewType
    {
        $users = User::query()
            ->search($request->get('search'))
            ->with('transactions')
            ->paginate();

        return view('admin.users.index', ['users' => $users]);
    }

    public function show(User $user)
    {
        $user->load(['kyc']);

        return view('admin.users.show', ['user' => $user]);
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', ['user' => $user]);
    }

    public function update(UserRequest $request, User $user)
    {
        $validateData = $request->validated();

        $user->update($validateData);

        return redirect()
            ->route('admin.users.index')
            ->with(['success' => "You have update user \" $user->name \" successfully !"]);
    }

    public function transactions(User $user)
    {
         $user->load(['kyc', 'transactions', 'transactions.payableToken']);

        return view('admin.users.transactions', ['user' => $user]);
    }
}
