<?php

namespace App\Http\Controllers;

use App\Helpers\Acl;
use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:'.Acl::OPERATION_R.'_'.Acl::PERMISSION_ENV_ROLES)->only('index','listDataTable');
        $this->middleware('permission:'.Acl::OPERATION_C.'_'.Acl::PERMISSION_ENV_ROLES)->only('create','store');
        $this->middleware('permission:'.Acl::OPERATION_U.'_'.Acl::PERMISSION_ENV_ROLES)->only('show','update');
        $this->middleware('permission:'.Acl::OPERATION_D.'_'.Acl::PERMISSION_ENV_ROLES)->only('delete');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('role.index');
    }

    public function listDataTable()
    {
        return datatables(Helper::roles())->toJson();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function create()
    {
        return view('role.create',['vars'=> \App\Models\Permission::getEnvPermissions()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        if($request->has('permissions') && count($request->permissions)){
            //Create role
            $role = Role::create(['name' => $request->name]);
            //Assign permissions
            $role->syncPermissions($request->permissions);
            //Redirect
            flash('Ruolo creato con successo.')->success();
            return redirect(route('roles.show', [$role->id]));
        } else {
            flash('Nessun permesso selezionato!')->warning();
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('role.show',[
            'role' => Role::find($id),
            'vars' => \App\Models\Permission::getEnvPermissions(),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Routing\Redirector
     */
    public function update(Request $request, $id)
    {
        $role = Role::find($id);
        if($role == null) return;

        $role->update(['name'=>$request->name]);

        if($request->has('permissions') && count($request->permissions) > 0){
            $role->syncPermissions($request->permissions);
        } else
            $role->syncPermissions([]);

        flash('Permessi aggiornati con successo.')->success();
        return redirect(route('roles.show', [$role->id]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
