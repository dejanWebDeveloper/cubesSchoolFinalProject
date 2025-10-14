<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\Admin\IndexRepository;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    protected $dashboard;

    public function __construct(IndexRepository $dashboard)
    {
        $this->dashboard = $dashboard;
    }

    public function index()
    {
        $dashboard = $this->dashboard->getDashboardStats();
        return view('admin.index_page.index_page', compact('dashboard'));
    }
    /**
     * Display a listing of the resource.
     */

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
