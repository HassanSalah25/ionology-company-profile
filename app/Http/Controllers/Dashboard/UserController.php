<?php

namespace App\Http\Controllers\Dashboard;

use App\Enum\UserType;
use App\Http\Controllers\Controller;
use App\Repositories\Eloquent\EloquentUserRepository;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Enum;

class UserController extends Controller
{
    //
    protected $userRepository;

    public function __construct(EloquentUserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function index(Request $request)
    {
        // Retrieve filtered users from the repository
        $data['users'] = $this->userRepository->filter($request->only(['name', 'email']));
        $data['title'] = 'All Users';
        $data['parentPageTitle'] = 'Users';
        return view('dashboard.users.index',$data);
    }

    public function create()
    {
        $data['title'] = 'New User';
        $data['parentPageTitle'] = 'Users';
        return view('dashboard.users.create',$data);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed|string|min:8',
            'user_type' => ['required',new Enum(UserType::class)],
            'role_id' => ['required']
        ]);

        $data['password'] = bcrypt($data['password']);

        $user = $this->userRepository->create($data);

        return redirect()->route('dashboard.users.index')->with('success', 'User created successfully.');
    }


    public function edit($id)
    {
        $data['user'] = $this->userRepository->find($id);

        $data['title'] = 'Update User';
        $data['parentPageTitle'] = 'Users';
        return view('dashboard.users.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'user_type' => ['required',new Enum(UserType::class)],
            'role_id' => ['required']
        ]);

        $user = $this->userRepository->find($id);

        // Update user attributes
        $user->update($data);

        return redirect()->route('dashboard.users.index')->with('success', 'User updated successfully.');
    }

    public function destroy($id)
    {
        $this->userRepository->delete($id);

        return response()->json([
            'status' => 'success',
            'message' => 'User deleted successfully'
        ], 200);
    }

    public function updatePassword(Request $request, $id)
    {
        $data = $request->validate([
            'password' => 'required|confirmed|min:8|string'
        ]);

        $data['password'] = bcrypt($data['password']);

        $user = $this->userRepository->find($id);

        // Update user attributes
        $user->update($data);

        return redirect()->route('dashboard.users.index')->with('success', 'User updated successfully.');
    }


}
