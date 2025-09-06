<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Author;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    public function index()
    {
        return view('admin.user_pages.users_page');
    }
    public function addUser()
    {
        return view('admin.user_pages.add_user_form');
    }
    public function datatable(Request $request)
    {
        $query = User::query();

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

        return DataTables::of($query)
            ->editColumn('status', fn($row) => $row->status
                ? '<span class="badge badge-success">Enabled</span>'
                : '<span class="badge badge-danger">Disabled</span>'
            )
            ->editColumn('profile_photo', fn($row) => "<img src='" . e($row->userImageUrl()) . "' width='100' class='img-rounded' />")
            ->addColumn('email', fn($row) => $row->email)
            ->addColumn('name', fn($row) => $row->name)
            ->addColumn('phone', fn($row) => $row->phone)
            ->editColumn('created_at', fn($row) => $row->created_at?->format('d/m/Y H:i:s'))
            ->editColumn('actions', fn($row) => view('admin.user_pages.partials.actions', compact('row')))
            ->rawColumns(['profile_photo', 'actions', 'status'])
            ->toJson();
    }
    public function storeUser()
    {
        $data = request()->validate([
            'name' => ['required', 'string', 'min:5', 'max:50'],
            'email' => ['required', 'email', 'unique:users,email'],
            'phone' => ['required', 'string', 'max:20'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'first-photo' => ['nullable', 'file', 'mimes:jpeg,png,jpg', 'max:1000']
        ]);
        $data['password'] = Hash::make($data['password']);
        $data['status'] = 1;
        $data['created_at'] = now();
        $newUser = new User();
        $newUser->fill($data)->save();
        //saving photo
        if (request()->hasFile('first-photo')) { //if has file
            $photo = request()->file('first-photo'); //save file to $photo
            //helper methode
            $this->savePhoto($photo, $newUser, 'profile_photo');
        }
        session()->put('system_message', 'User Added Successfully');
        return redirect()->route('admin_users_page');
    }

    public function savePhoto($photo, $user, $field)
    {
        // Generate unique filename
        $photoName = $user->id . '_' . $field . '_' . uniqid() . '.' . $photo->getClientOriginalExtension();

        // Delete old photo if exists
        if ($user->$field) {
            $oldPath = 'photo/user' . $user->$field;
            if (Storage::disk('public')->exists($oldPath)) {
                Storage::disk('public')->delete($oldPath);
            }
        }

        // Save new photo to storage
        $path = $photo->storeAs('photo/user', $photoName, 'public');

        // Update DB
        $user->$field = basename($path);
        $user->save();
    }

    public function deletePhoto($user, $field)
    {
        if (!$user->$field) return false;

        $path = 'photo/user' . $user->$field;
        if (Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }

        $user->$field = null;
        $user->save();

        return true;
    }
    public function editUser($id)
    {
        $userForEdit = User::where('id', $id)->firstOrFail();
        return view('admin.user_pages.edit_user_page', compact(
            'userForEdit'
        ));
    }
    public function storeEditedUser(User $userForEdit, Request $request)
    {
        $data = request()->validate([
            'name' => ['required', 'string', 'min:5', 'max:50'],
            'email' => ['required', 'email'],
            'phone' => ['required', 'string', 'max:20'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'first-photo' => ['nullable', 'file', 'mimes:jpeg,png,jpg', 'max:1000']
        ]);
        $data['password'] = Hash::make($data['password']);
        $data['status'] = 1;
        $data['updated_at'] = now();
        $userForEdit->fill($data)->save();
        //saving photo
        if ($request->hasFile('first-photo')) {
            $this->deletePhoto($userForEdit, 'profile_photo');
            $this->savePhoto($request->file('first-photo'), $userForEdit, 'profile_photo');
        }
        if ($request->has('delete_photo1') && $request->delete_photo1) {
            $this->deletePhoto($userForEdit, 'profile_photo');
            /*if ($authorForEdit->profile_photo) {
                Storage::disk('public')->delete('photo/author' . $authorForEdit->profile_photo);
                $authorForEdit->profile_photo = null;
                $authorForEdit->save();
            }*/
        }
        session()->put('system_message', 'User Data Edited Successfully');
        return redirect()->route('admin_users_page');
    }
    public function disableUser()
    {
        $data = request()->validate([
            'user_for_disable_id' => ['required', 'numeric', 'exists:users,id'],
        ]);
        $user = User::findOrFail($data['user_for_disable_id']);
        $user->status = 0;
        $user->save();
        return response()->json(['success' => 'User Disabled Successfully']);
    }
    public function enableUser()
    {
        $data = request()->validate([
            'user_for_enable_id' => ['required', 'numeric', 'exists:users,id'],
        ]);
        $user = User::findOrFail($data['user_for_enable_id']);
        $user->status = 1;
        $user->save();
        return response()->json(['success' => 'User Enabled Successfully']);
    }
}
