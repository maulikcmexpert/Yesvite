<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DataTables\TransactionDataTable;
use Yajra\DataTables\DataTables;


class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request,TransactionDataTable $DataTable)
    {

        // dd(decrypt($request['user_id']));
        $title = 'Coin Transaction';
        $page = 'admin.transaction.list';
        // $js = 'admin.user.userjs';
        return $DataTable->render('admin.includes.layout', compact('title', 'page'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = 'Coin Transaction';
        $page = 'admin.transaction.add';
                // $js = 'admin.user.userjs';
                return view('admin.includes.layout', compact(
                    'title',
                    'page'
                ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        // $js = 'admin.user.userjs';  
        
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
