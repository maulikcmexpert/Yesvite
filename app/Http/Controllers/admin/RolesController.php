<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;

use App\Models\Admin;

class RolesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = 'Roles';

        $page = 'admin.roles.list';

        $js = 'admin.roles.rolejs';

        return view('admin.includes.layout', compact('title', 'page', 'js'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
        $title = 'Add Role';

        $page = 'admin.roles.add';

        $js = 'admin.roles.rolejs';

        return view('admin.includes.layout', compact('title', 'page', 'js'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {

        DB::beginTransaction();



        $storerole = new Admin;
        $storerole->name=$request->name;
        $storerole->email=$request->email;
        $storerole->password= Hash::make($request->password);;
        $storerole->is_admin='0';
        
        $storerole->save();


        DB::commit();
        return redirect()->route('roles.index')->with('success', 'Role Added successfully !');
    } catch (QueryException $e) {

        DB::rollBack();

        Log::error('Database query error' . $e->getMessage());

        return redirect()->route('roles.create')->with('danger', 'Role not added' . $e->getMessage());
    }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
