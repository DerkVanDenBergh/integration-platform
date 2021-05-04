<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Gate;

use App\Services\UserService;
use App\Services\RoleService;

class UserController extends Controller
{

    protected $userService;
    protected $roleService;

    public function __construct(UserService $userService, RoleService $roleService)
    {
        $this->userService = $userService;
        $this->roleService = $roleService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Gate::authorize('manage_users');

        $users = $this->userService->findAll();

        return view('models.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        Gate::authorize('manage_users');

        $roles = $this->roleService->findAll();

        return view('models.users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Gate::authorize('manage_users');

        $validatedData = $request->validate([
            'name' => ['required', 'max:255'],
            'email' => ['required', 'unique:users', 'max:255'],
            'role_id' => ['required'],
        ]);

        $user = $this->userService->store($validatedData);

        return redirect('/users')->with('success', 'User with name "' . $user->name . '" has succesfully been created!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        Gate::authorize('manage_users');

        $user = $this->userService->findById($id);
        $roles = $this->roleService->findAll();

        return view('models.users.show', compact('user', 'roles'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        Gate::authorize('manage_users');

        $user = $this->userService->findById($id);
        $roles = $this->roleService->findAll();

        return view('models.users.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        Gate::authorize('manage_users');

        $validatedData = $request->validate([
            'name' => ['required', 'max:255'],
            'email' => ['required', Rule::unique('users')->ignore($id), 'max:255'],
            'role_id' => ['required'],
        ]);

        $user = $this->userService->findById($id);

        $this->userService->update($validatedData, $user);

        return redirect('/users')->with('success', 'User with name "' . $user->name . '" has succesfully been updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Gate::authorize('manage_users');
        
        $user = $this->roleService->findById($id);

        $this->userService->delete($user);

        return redirect('/users')->with('success', 'User with name "' . $user->name . '" has succesfully been deleted!');
    }
}
