<?php

namespace Hanson\Speedy\Http\Controllers;

use Speedy;
use Illuminate\Http\Request;

class RoleController extends BaseController
{

    protected $permissionName = 'role';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Speedy::getModelInstance('role')->paginate(20);

        return view('vendor.speedy.admin.role.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Speedy::getModelInstance('role')->all();

        $permissions = Speedy::getModelInstance('permission')->all();

        return view('vendor.speedy.admin.role.edit', compact('roles', 'permissions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = $this->mustValidate('role.store');

        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $role = Speedy::getModelInstance('role')->create([
            'name' => $request->get('name'),
            'display_name' => $request->get('display_name'),
        ]);

        if($request->get('permission_id')){
            foreach ($request->get('permission_id') as $permissionId) {
                Speedy::getModelInstance('permission_role')->create(['permission_id' => $permissionId, 'role_id' => $role->id]);
            }
        }

        return redirect()->route('admin.role.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $role = Speedy::getModelInstance('role')->find($id);

        $permissions = Speedy::getModelInstance('permission')->all();

        return view('vendor.speedy.admin.role.edit', compact('role', 'permissions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = $this->mustValidate('role.update', false, 'name', $id);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $role = Speedy::getModelInstance('role')->find($id);
        $role->update(['name' => $request->get('name'), 'display_name' => $request->get('display_name')]);

        if($request->get('permission_id')){
            foreach ($request->get('permission_id') as $permissionId) {
                Speedy::getModelInstance('permission_role')->firstOrCreate(['permission_id' => $permissionId, 'role_id' => $role->id]);
            }
        }

        return redirect()->route('admin.role.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $result = Speedy::getModelInstance('role')->destroy($id);

        return $result ? redirect()->route('admin.role.index') : redirect()->back()->withErrors(trans('view.admin.role.delete_role_failed'))->withInput();
    }
}
