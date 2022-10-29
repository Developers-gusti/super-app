<?php

namespace Modules\Settings\Http\Controllers;

use App\Models\Permissions;
use App\Models\User;
use Artesaos\SEOTools\Facades\SEOMeta;
use Auth;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\Facades\DataTables;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function __construct()
    {
        $this->middleware('can:read_permission')->only('index');
    }
    public function index(Request $request)
    {
        SEOMeta::setTitle(Lang::get('label.menu.permission'));
        $role = Role::orderBy('name','asc')->get();
        if ($request->ajax()) {
            $data = Permission::latest();
            return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function($row){
                $user = Auth::user();
                $btn = '';
                if ($user->hasPermissionTo('update_permission')) {
                    $btn .= '<button type="button" class="btn btn-sm btn-icon btn-active-light-primary editData" data-id="'.$row->id.'"><i class="bi bi-pencil-square"></i></button>';
                }
                if ($user->hasPermissionTo('delete_permission')) {
                    $btn .= '<button type="button" class="btn btn-sm btn-icon btn-active-light-danger deleteData" data-id="'.$row->id.'" data-name="'.$row->name.'"><i class="bi bi-trash"></i></button>';
                }
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
        }
        return view('settings::permission.index')->with(['role'=>$role]);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('settings::permission.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        if (isset($request->id)) {
            $rule = [
                'role'=>'required',
            ];
            $message = Lang::get('messages.success.edit_data',['title'=>$request->name]);
        }else{
            $rule = [
                'name'=>'required|unique:permissions',
                'role'=>'required',
            ];
            $message = Lang::get('messages.success.new_data');
        }

        $validator = Validator::make($request->all(),$rule);
        if ($validator->passes()) {
            $permission = Permission::updateOrCreate(['id'=>$request->id],[
                'name' => $request->name,
                'guard_name'=>'web'
            ]);
            $role = $request->input('role');
            foreach ($role as $value) {
                $data_role = Role::find($value);
                $data_role->givePermissionTo($request->name);
                if (isset($request->id)) {
                    $all_roles_except_value = Role::whereNotIn('id', $role)->get()->pluck('name')->toArray();
                    if (count($all_roles_except_value) != 0) {
                        foreach ($all_roles_except_value as $rolename) {
                            $permission->removeRole($rolename);
                        }
                    }
                }
            }
            return Response::json(['result'=>true,'message'=>$message]);
        }else{
            return Response::json(['result'=>false,'message'=>$validator->errors()]);
        }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('settings::permission.show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $permission = Permission::find($id);
        $roles = User::permission($permission->name)->get();
        foreach ($roles as $key => $value) {
            $item[] = [
                'id' =>$value['roles'][0]['id'],
                'name'=> $value['roles'][0]['name']
            ];
        }
        return Response::json(['permission'=>$permission,'roles'=>$item]);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        $permission  = Permission::find($id);
        $role = Role::all()->pluck('name');
        foreach ($role as $value) {
            $permission->removeRole($value);
        }
        $permission->delete();
        return Response::json();
    }
}
