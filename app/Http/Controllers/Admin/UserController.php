<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\Admin\UserRepository;
use App\Services\PhotoService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    protected $users;
    protected $photoService;

    public function __construct(UserRepository $users, PhotoService $photoService)
    {
        $this->users = $users;
        $this->photoService = $photoService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.user_pages.users_page');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.user_pages.add_user_form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = request()->validate([
            'name' => ['required', 'string', 'min:5', 'max:50'],
            'email' => ['required', 'email', 'unique:users,email'],
            'phone' => ['required', 'string', 'max:20'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'profile_photo' => ['nullable', 'file', 'mimes:jpeg,png,jpg', 'max:1000']
        ]);
        $newUser = $this->users->saveUser($data);
        //saving photo
        if (request()->hasFile('profile_photo')) { //if has file
            $photo = request()->file('profile_photo'); //save file to $photo
            //helper methode
            $this->photoService->saveUserPhoto($photo, $newUser, 'profile_photo');
        }
        session()->put('system_message', 'User Added Successfully');
        return redirect()->route('admin.users.index');
    }

    /**
     * Display the specified resource.
     */
    public function userProfile()
    {
        $user = auth()->user();
        return view('admin.user_pages.user_profile', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit()
    {
        $user = Auth::user();
        return view('admin.user_pages.edit_user_page', compact('user'));
    }


    public function editUserPassword()
    {
        return view('admin.user_pages.user_change_password');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'min:5', 'max:50'],
            'phone' => ['required', 'string', 'max:20'],
            'profile_photo' => ['nullable', 'file', 'mimes:jpeg,png,jpg', 'max:1000']
        ]);
        //problem with fill() because this methode don't change password
        $this->users->saveEditedUser($request);
        //saving photo
        if ($request->hasFile('profile_photo')) {
            $this->photoService->deleteUserPhoto(Auth::user(), 'profile_photo');
            $this->photoService->saveUserPhoto($request->file('profile_photo'), Auth::user(), 'profile_photo');
        }
        if ($request->has('delete_photo1') && $request->delete_photo1) {
            $this->photoService->deleteUserPhoto(Auth::user(), 'profile_photo');
        }
        session()->put('system_message', 'User Data Edited Successfully');
        return redirect()->route('admin.users.index');
    }

    public function storeEditedUserPassword(Request $request)
    {
        $data = $request->validate([
            'old_password' => ['required'],
            'password' => ['required', 'string', 'min:8', 'confirmed']
        ]);
        $this->users->saveNewPassword($data, $request);
        if (!$this->users->saveNewPassword($data, $request)) {
            return back()->withErrors(['old_password' => 'The old password is incorrect.']);
        }
        session()->put('system_message', 'User Password Edited Successfully');
        return redirect()->route('admin.users.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function show($id)
    {
        // Ne radi ništa, samo da ruta postoji
    }

    public function disableUser()
    {
        $data = request()->validate([
            'user_for_disable_id' => ['required', 'numeric', 'exists:users,id'],
        ]);
        $this->users->disableOneUser($data);
        return response()->json(['success' => 'User Disabled Successfully']);
    }

    public function enableUser()
    {
        $data = request()->validate([
            'user_for_enable_id' => ['required', 'numeric', 'exists:users,id'],
        ]);
        $this->users->enableOneUser($data);
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
        $this->users->resetOldPassword($data);
        return redirect()->route('admin.index.index');
    }

    public function datatable(Request $request)
    {
        $query = $this->users->dataTableUsers($request);
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
}
