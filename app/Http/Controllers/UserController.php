<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddNewUserRequest;
use App\Http\Requests\EditUserRequest;
use App\Models\User;
use App\Services\OfficeService;
use App\Services\RoleService;
use App\Services\UserService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UserController extends Controller
{
    public function __construct(private UserService $userService, private OfficeService $officeService, private RoleService $roleService)
    {
        
    }
    
    public function showUserDashboard(): View
    {
        $users = $this->userService->users();
        $offices = $this->officeService->offices();
        $roles = $this->roleService->roles();

        return view('user-dashboard', [
            'users' => $users,
            'offices' => $offices,
            'roles' => $roles,
            'modalId' => 'removeUserModal'
        ]);
    }

    public function addNewUser(AddNewUserRequest $request): RedirectResponse
    {
        $added = $this->userService->new($request->validated());

        abort_if(!$added, 500);

        return back()->with('success', 'User added successfully!');;
    }

    public function showEditUser(User $user): View
    {
        $offices = $this->officeService->offices();
        $roles = $this->roleService->roles();

        return view('edit-user', [
            'user' => $user,
            'offices' => $offices,
            'roles' => $roles,
        ]);
    }

    public function updateUser(EditUserRequest $request, User $user): RedirectResponse
    {
        $updated = $this->userService->edit($user, $request->validated());

        abort_if(!$updated, 500);

        return back()->with('success', 'User info updated successfully!');
    }

    public function deleteUser(User $user): RedirectResponse
    {
        $deleted = $this->userService->delete($user);

        abort_if(!$deleted, 500);

        return redirect(route('users'));
    }
}
