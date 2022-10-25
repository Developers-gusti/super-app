<?php

namespace Modules\Settings\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Artesaos\SEOTools\Facades\SEOMeta;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;
use Str;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function __construct()
    {
        $this->middleware('can:read_user')->only('index');
    }
    public function index(Request $request)
    {
        SEOMeta::setTitle('User');
        $role = Role::all();
        if ($request->ajax()) {
            $data = User::latest();
            return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function($row){
                $btn = '<button type="button" class="btn btn-sm btn-icon btn-active-light-primary"><i class="bi bi-pencil-square"></i></button>';
                $btn .= '<button type="button" class="btn btn-sm btn-icon btn-active-light-danger"><i class="bi bi-trash"></i></button>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);

        }
        return view('settings::user.index')->with(['role'=>$role]);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create($request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'remember_token'=>Str::random(16)
        ]);
        $user->assignRole($request->role);
        return true;
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $rule = $this->_validation($request->all());
        $validator = Validator::make($request->all(),$rule);
        if ($validator->passes()) {
            if (!isset($request->id) && isset($request->password) ) {
                $this->create($request->all());
            } else if (isset($request->id) && !isset($request->password) ) {
               $this->update($request->id,$request->all());
            } else if (isset($request->id) && isset($request->password) ) {
                $rule = [
                    'email'=>'required|email',
                    'password'=>'required|min:6|max:12|password_confirmation',
                ];
            }
            return Response::json(['result' => true, 'message' => 'Success'], 200);
        }else{
            return Response::json(['result' => false, 'errors' => $validator->errors()],422);
        }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('settings::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('settings::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        $user = User::find($id)->update([
            'name' => $request->name,
        ]);
        $user->syncRoles($request->role);
        return true;
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }
    public function changePassoword(Request $request,$id)
    {
        $user = User::find($id)->update([
            'password' => Hash::make($request->password)
        ]);
        return true;
    }
    public function _validation($request) 
    {
        //insert new data
        if (!isset($request->id) && isset($request->password) ) {
            $rule = [
                'name'=>'required',
                'email'=>'required|email|unique:users',
                'password'=>'required|min:6|max:12|password_confirmation',
                'role'=>'required',
            ];
        }
        //Update Data
        if (isset($request->id) && !isset($request->password) ) {
            $rule = [
                'name'=>'required',
                'email'=>'required|email',
                'role'=>'required',
            ];
        }
        //Change Password
        if (isset($request->id) && isset($request->password) ) {
            $rule = [
                'email'=>'required|email',
                'password'=>'required|min:6|max:12|password_confirmation',
            ];
        }
        return $rule;  
    }
}
