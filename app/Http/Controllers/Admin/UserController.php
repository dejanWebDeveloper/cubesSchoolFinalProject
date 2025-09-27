<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Laravel\Facades\Image;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    public function index()
    {
        return view('admin.user_pages.users_page');
    }
    public function userProfile()
    {
        $user = auth()->user();
        return view('admin.user_pages.user_profile', compact('user'));
    }
    public function addUser()
    {
        return view('admin.user_pages.add_user_form');
    }
    public function datatable(Request $request)
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
            'profile_photo' => ['nullable', 'file', 'mimes:jpeg,png,jpg', 'max:1000']
        ]);
        $data['password'] = Hash::make($data['password']);
        $data['status'] = 1;
        $data['created_at'] = now();
        $newUser = new User();
        $newUser->fill($data)->save();
        //saving photo
        if (request()->hasFile('profile_photo')) { //if has file
            $photo = request()->file('profile_photo'); //save file to $photo
            //helper methode
            $this->savePhoto($photo, $newUser, 'profile_photo');
        }
        session()->put('system_message', 'User Added Successfully');
        return redirect()->route('admin_users_page');
    }
    public function savePhoto($photo, $user, $field)
    {
        // Generate unique filename
        $photoName = $user->id . '_' . $field . '_' . Str::uuid();
        $relativePath = 'photo/user/' . $photoName;
        // Delete old photo if exists
        if (!empty($user->$field)) {
            $oldPath = 'photo/user/' . $user->$field;
            if (Storage::disk('public')->exists($oldPath)) {
                Storage::disk('public')->delete($oldPath);
            }
        }
        // Read + crop + resize + encode
        $image = Image::read($photo)
            ->cover(256, 256)
            ->toJpeg(90);
        // Save new photo to storage
        Storage::disk('public')->put($relativePath, (string) $image);
        // Update DB (store only filename if you prefer)
        $user->$field = $photoName;
        $user->save();
    }

    public function deletePhoto($user, $field)
    {
        if (!$user->$field) return false;
        $path = 'photo/user/' . $user->$field;
        if (Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
        $user->$field = null;
        $user->save();
        return true;
    }
    public function editUser()
    {
        return view('admin.user_pages.edit_user_page');
    }
    public function editUserPassword()
    {
        return view('admin.user_pages.user_change_password');
    }
    public function storeEditedUser(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'min:5', 'max:50'],
            'phone' => ['required', 'string', 'max:20'],
            'profile_photo' => ['nullable', 'file', 'mimes:jpeg,png,jpg', 'max:1000']
        ]);
        //problem with fill() because this methode don't change password
        Auth::user()->name = $request->name;
        Auth::user()->phone = $request->phone;
        Auth::user()->updated_at = now();
        Auth::user()->save();
        //saving photo
        if ($request->hasFile('profile_photo')) {
            $this->deletePhoto(Auth::user(), 'profile_photo');
            $this->savePhoto($request->file('profile_photo'), Auth::user(), 'profile_photo');
        }
        if ($request->has('delete_photo1') && $request->delete_photo1) {
            $this->deletePhoto(Auth::user(), 'profile_photo');
        }
        session()->put('system_message', 'User Data Edited Successfully');
        return redirect()->route('admin_users_page');
    }
    public function storeEditedUserPassword(Request $request)
    {
        $data = $request->validate([
            'old_password' => ['required'],
            'password' => ['required', 'string', 'min:8', 'confirmed']
        ]);
        if (!Hash::check($request->old_password, auth()->user()->password)) {
            return back()->withErrors(['old_password' => 'The old password is incorrect.']);
        }
        $data['password'] = Hash::make($data['password']);
        $data['updated_at'] = now();
        $userForEdit = Auth::user();
        $userForEdit->fill($data)->save();

        session()->put('system_message', 'User Password Edited Successfully');
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
    public function resetPasswordPage()
    {
        return view('admin.user_pages.reset_password_page');
    }
    public function resetUserPassword()
    {
        $data = request()->validate([
            'email' => ['required', 'email', 'exists:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
        $userForResetPassword = User::where('email', $data['email'])->firstOrFail();
        $data['password'] = Hash::make($data['password']);
        $data['updated_at'] = now();
        $userForResetPassword->fill($data)->save();
        return redirect()->route('admin_index_page');
    }
}
