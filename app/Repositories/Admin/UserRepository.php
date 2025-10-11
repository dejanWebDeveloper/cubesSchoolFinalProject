<?php

namespace App\Repositories\Admin;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserRepository
{
    public function dataTableUsers($request)
    {
        $query = User::query();
        //search entry on the page
        if ($request->name) {
            $query->where('name', 'like', "%{$request->name}%");
        }
        if ($request->email) {
            $query->where('email', 'like', "%{$request->email}%");
        }
        if ($request->phone) {
            $query->where('phone', 'like', "%{$request->phone}%");
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        return $query;
    }
    public function saveUser($data)
    {
        $data['password'] = Hash::make($data['password']);
        $data['status'] = 1;
        $data['created_at'] = now();
        $user = new User();
        $user->fill($data)->save();
        return $user;
    }
    public function saveEditedUser($request)
    {
        Auth::user()->name = $request->name;
        Auth::user()->phone = $request->phone;
        Auth::user()->updated_at = now();
        Auth::user()->save();
    }
    public function saveNewPassword($data, $request)
    {
        if (!Hash::check($request->old_password, auth()->user()->password)) {
            return back()->withErrors(['old_password' => 'The old password is incorrect.']);
        }
        $data['password'] = Hash::make($data['password']);
        $data['updated_at'] = now();
        $userForEdit = Auth::user();
        $userForEdit->fill($data)->save();
    }
    public function disableOneUser($data)
    {
        $user = User::findOrFail($data['user_for_disable_id']);
        $user->status = 0;
        $user->save();
    }
    public function enableOneUser($data)
    {
        $user = User::findOrFail($data['user_for_enable_id']);
        $user->status = 1;
        $user->save();
    }
    public function resetOldPassword($data)
    {
        $userForResetPassword = User::where('email', $data['email'])->firstOrFail();
        $data['password'] = Hash::make($data['password']);
        $data['updated_at'] = now();
        $userForResetPassword->fill($data)->save();
    }
}
