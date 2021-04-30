<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

use App\Services\RoleService;

class RoleController extends Controller
{

    protected $roleService;

    public function __construct(RoleService $roleService)
    {
        $this->roleService = $roleService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = $this->roleService->findAll();

        return view('roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('roles.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => ['required', 'unique:roles', 'max:255'],
            'can_manage_users' => ['nullable'],
            'can_manage_roles' => ['nullable'],
            'can_manage_functions' => ['nullable'],
        ]);

        $role = $this->roleService->store($validatedData);

        return redirect('/roles')->with('success', 'Role with name "' . $role->title . '" has succesfully been created!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        return view('roles.show', compact('role'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        return view('roles.edit', compact('role'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Role $role)
    {
        $validatedData = $request->validate([
            'title' => ['required', Rule::unique('roles')->ignore($role->id), 'max:255'],
            'can_manage_users' => ['nullable'],
            'can_manage_roles' => ['nullable'],
            'can_manage_functions' => ['nullable'],
        ]);

        $this->roleService->update($validatedData, $role);

        return redirect('/roles')->with('success', 'Role with name "' . $role->title . '" has succesfully been updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        $this->roleService->delete($role);

        return redirect('/roles')->with('success', 'Role with name "' . $role->title . '" has succesfully been deleted!');
    }
}
