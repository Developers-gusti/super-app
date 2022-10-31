<?php

namespace Modules\Settings\Http\Controllers;

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

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function __construct()
    {
        $this->middleware('can:read_role')->only('index');
    }
    public function index(Request $request)
    {
        SEOMeta::setTitle(Lang::get('label.menu.role'));
        if ($request->ajax()) {
            $data = Role::orderBy('id','desc')->get();
            return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function($row){
                $user = Auth::user();
                $btn = '';
                if ($user->hasPermissionTo('update_role')) {
                    $btn .= '<button type="button" class="btn btn-sm btn-icon btn-active-light-primary editData" data-id="'.$row->id.'"><i class="bi bi-pencil-square"></i></button>';
                }
                if ($user->hasPermissionTo('delete_role')) {
                    $btn .= '<button type="button" class="btn btn-sm btn-icon btn-active-light-danger deleteData" data-id="'.$row->id.'" data-name="'.$row->name.'"><i class="bi bi-trash"></i></button>';
                }
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
        };
        return view('settings::role.index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        SEOMeta::setTitle(Lang::get('settings::label.role.create_role'));
        $user_permission = Permission::where('name','LIKE','%user%')->get();
        $role_permission = Permission::where('name','LIKE','%role%')->get();
        $permission_permission = Permission::where('name','LIKE','%permission%')->get();
        return view('settings::role.create')->with(['user'=>$user_permission,'role'=>$role_permission,'permission'=>$permission_permission]);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $rule = [
            'name'=>'required|unique:roles',
            'permission_name'=>'required',
        ];
        $message = Lang::get('messages.success.new_data');
        $validator = Validator::make($request->all(),$rule);
        if ($validator->passes()) {
            $role = Role::create([
                'name'=>$request->name,
                'guard_name'=>'web'
            ]);
            $permission = $request->input('permission_name');
            foreach ($permission as $value) {
                $role->givePermissionTo($value);
            }
            return Response::json(['result' =>true, 'message' =>$message]);
        }else{
            return Response::json(['result'=>false, 'message'=>$validator->errors()]);
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
        //
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
}
