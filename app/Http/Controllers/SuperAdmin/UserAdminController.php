<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Helpers\Acl;
use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\User;
use Illuminate\Http\Request;

class UserAdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index()
    {
        return view('superadmin.user.index');
    }

    public function listDataTable()
    {
        return datatables(User::query()->whereHas('roles', function ($query){
            $query->where('name','<>',Acl::ROLE_SUPERADMIN);
        }))->toJson();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function create()
    {
        return view('superadmin.user.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $fields = [
            'name' => $request->name,
            'lastname' => $request->lastname,
            'username' => $request->username,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ];

        $user = User::query()->create($fields);

        $user->assignRole(Acl::ROLE_ADMIN);

        if($user)
            flash('Operazione completata con successo.')->success();
        else
            flash('Si è verificato un errore...')->error();

        return redirect(route('superadmin.users.index'));
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
        return view('superadmin.user.show', compact('user'));
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

            $user->assignRole(Acl::ROLE_ADMIN);

            if($user)
                flash('Operazione completata con successo.')->success();
            else
                flash('Si è verificato un errore...')->error();

        }

        return redirect(route('superadmin.users.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
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
