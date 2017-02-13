<?php

namespace Hanson\Speedy\Http\Controllers;

use Speedy;
use Illuminate\Http\Request;

class UserController extends BaseController
{

    protected $permissionName = 'user';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = Speedy::getModelInstance('user')->paginate(20);

        return view('vendor.speedy.admin.user.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Speedy::getModelInstance('role')->all();

        return view('vendor.speedy.admin.user.edit', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = $this->mustValidate('user.store');

        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user = Speedy::getModelInstance('user')->create([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => bcrypt($request->get('password')),
            'role_id' => $request->get('role_id')
        ]);

        return $user ? redirect()->route('admin.user.index') : redirect()->back()->withErrors(trans('view.admin.user.create_user_failed'))->withInput();
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
        $user = Speedy::getModelInstance('user')->find($id);

        $roles = Speedy::getModelInstance('role')->all();

        return view('vendor.speedy.admin.user.edit', compact('user', 'roles'));
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
        $validator = $this->mustValidate('user.update', false, 'email', $id);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $payload = $request->all();

        $data = ['name' => $payload['name'], 'email' => $payload['email'], 'role_id' => $payload['role_id']];

        if($payload['password']){
            $data = array_merge($data, ['password' => bcrypt($payload['password'])]);
        }

        $result = Speedy::getModelInstance('user')->find($id)->update($data);

        return $result ? redirect()->route('admin.user.index') : redirect()->back()->withErrors(trans('view.admin.user.edit_user_failed'))->withInput();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $result = Speedy::getModelInstance('user')->destroy($id);
        return $result ? redirect()->route('admin.user.index') : redirect()->back()->withErrors(trans('view.admin.user.delete_user_failed'))->withInput();
    }
}
