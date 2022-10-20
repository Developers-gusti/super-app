<?php

namespace Modules\Settings\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Artesaos\SEOTools\Facades\SEOMeta;
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
        return view('settings::user.index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('settings::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        //
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
