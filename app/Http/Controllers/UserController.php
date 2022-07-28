<?php

namespace App\Http\Controllers;

use App\Helpers\Acl;
use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\Company;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PHPUnit\TextUI\Help;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:'.Acl::OPERATION_R.'_'.Acl::PERMISSION_ENV_USERS)->only('index','listDataTable');
        $this->middleware('permission:'.Acl::OPERATION_C.'_'.Acl::PERMISSION_ENV_USERS)->only('create','store');
        $this->middleware('permission:'.Acl::OPERATION_U.'_'.Acl::PERMISSION_ENV_USERS)->only('show','update');
        $this->middleware('permission:'.Acl::OPERATION_D.'_'.Acl::PERMISSION_ENV_USERS)->only('delete');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index()
    {
        return view('user.index');
    }

    public function listDataTable()
    {
        return datatables(User::with('roles')->where('id', '<>', 1)->get())->toJson();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Helper::roles();
        return view('user.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Routing\Redirector
     */
    public function store(UserRequest $request)
    {
        $fields = [
            'name' => $request->name,
            'lastname' => $request->lastname,
            'username' => $request->username,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ];

        $user = User::query()->create($fields);

        $user->syncRoles($request->role);

        if($user)
            flash('Operazione completata con successo.')->success();
        else
            flash('Si è verificato un errore...')->error();

        return redirect(route('users.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);
        $roles = Helper::roles();
        return view('user.show', compact('user', 'roles'));
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
    public function update(UserRequest $request, $id)
    {
        $user = User::find($id);

        if($user !== null) {

            $fields = [
                'name' => $request->name,
                'lastname' =>$request->lastname,
                'username' => $request->username,
                'email' => $request->email,
            ];

            if($request->has('password') && !is_null($request->password))
                $fields['password'] = bcrypt($request->password);

            $user->update($fields);

            $user->syncRoles($request->role);

            if($user)
                flash('Operazione completata con successo.')->success();
            else
                flash('Si è verificato un errore...')->error();

        }

        return redirect(route('users.index'));
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

    public function delete(Request $request){

        foreach ($request->ids as $id) {

            $user = User::find($id);
            if($user == null) continue;

            //Delete
            $user->delete();

        }

        return response()->json(['success' => true]);

    }

}
