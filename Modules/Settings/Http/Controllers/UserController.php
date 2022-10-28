<?php

namespace Modules\Settings\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Artesaos\SEOTools\Facades\SEOMeta;
use Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Lang;
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
        $this->middleware('can:create_user')->only(['create', 'store']);
        $this->middleware('can:update_user')->only(['update', 'store','changePassoword']);
        $this->middleware('can:delete_user')->only(['destroy']);
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
                $btn = '<button type="button" class="btn btn-sm btn-icon btn-active-light-primary editData"  data-id="'.$row->id.'"><i class="bi bi-pencil-square"></i></button>';
                $btn .= '<button type="button" class="btn btn-sm btn-icon btn-active-light-danger deleteData" data-id="'.$row->id.'" data-name="'.$row->name.'"><i class="bi bi-trash"></i></button>';
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
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
            'remember_token'=>Str::random(16)
        ]);
        $user->assignRole($request['role']);
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
            if ($request->id==null && $request->password!=null ) {
                $this->create($request->all());
                $message = Lang::get('messages.notification.new_user',['attribute'=>$request->name]);
            } else if (isset($request->id) && !isset($request->password) ) {
               $this->update($request->all(),$request->id);
               $message = Lang::get('messages.success.edit_data',['title'=>Lang::get('label.menu.user').' '.$request->name]);
            } else if (isset($request->id) && isset($request->password) ) {
               $this->changePassoword($request->id,$request->password);
               $message = Lang::get('messages.notification.new_user',['attribute'=>$request->name]);

            }
            return Response::json(['result' => true, 'message' => $message], 200);
        }else{
            return Response::json(['result' => false, 'message' => $validator->errors()],200);
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
        $user = User::find($id);
        $roles = $user->getRoleNames();
        return Response::json(['user'=>$user,'roles'=>$roles]);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update($request, $id)
    {
        $user = User::find($id);
        $user->syncRoles($request['role']);
        $user->update([
            'name' => $request['name'],
        ]);
        return true;
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        User::find($id)->delete();
        return Response::json(['result'=>true]);
    }
    public function changePassoword($id,$password)
    {
        User::find($id)->update([
            'password' => Hash::make($password)
        ]);
        return true;
    }
    public function updateProfile(Request $request)
    {
        $rule = [
            'name'=>'required',
            'email'=>'required|email',
            'role'=>'required',
        ];
        $validator = Validator::make($request->all(),$rule);
        if ($validator->passes()) {
            User::find(auth()->user()->id)->update([
                'name' => $request->name,
            ]);
           return Response::json(['result'=>true,'message'=>Lang::get('messages.success.edit_data',['title'=>Lang::get('label.username')])],200);
        }else{
            return Response::json(['result' => false,'message' => $validator->errors()],200);
        }

    }
    public function _validation($request)
    {
        //insert new data
        if (!isset($request['id']) && isset($request['password'])) {
            $rule = [
                'name'=>'required',
                'email'=>'required|email|unique:users',
                'password'=>'required|min:6|max:12|confirmed',
                'role'=>'required',
            ];
        }
        //Update Data
        if (isset($request['id']) && !isset($request['password']) ) {
            $rule = [
                'name'=>'required',
                'email'=>'required|email',
                'role'=>'required',
            ];
        }
        //Change Password
        if (isset($request['id']) && isset($request['password']) ) {
            $rule = [
                'email'=>'required|email',
                'password'=>'required|min:6|max:12|confirmed',
            ];
        }
        return $rule;
    }
    public function profile()
    {
       return view('layouts.profile');
    }
    public function selfChangePassword(Request $request)
    {
        $rule = [
            'current_password'=>'required|min:6|max:12',
            'password'=>'required|min:6|max:12|confirmed'
        ];
        $validator = Validator::make($request->all(),$rule);
        if($validator->passes()){
            if(!Hash::check($request->current_password,auth()->user()->password)){
                return Response::json(['result' => false,'message' =>['current_password'=>[Lang::get('validation.current_password')]]],200);
            }else{
                $this->changePassoword(auth()->user()->id,$request->password);
            }
            return Response::json(['result'=>true,'message'=>Lang::get('messages.success.edit_data',['title'=>Lang::get('label.password')])],200);
        }else{
            return Response::json(['result' => false,'message' => $validator->errors()],200);
        }
    }
}
