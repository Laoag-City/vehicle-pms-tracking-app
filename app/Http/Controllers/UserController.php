<?php

namespace App\Http\Controllers;

use App\Services\OfficeService;
use App\Services\RoleService;
use App\Services\UserService;
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
            'roles' => $roles
        ]);
    }
}
