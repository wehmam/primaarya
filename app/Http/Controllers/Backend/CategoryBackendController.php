<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CategoryBackendController extends Controller
{
    protected $catRepo;

    public function __construct() {
        $this->catRepo = new \App\Repository\CategoryRepository();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $category = $this->catRepo->getCategory();
        return view("backend.pages.category.index", compact("category"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("backend.pages.category.form");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $response = $this->catRepo->saveCategory($request);
        alertNotify($response['status'], $response['data'], $request);
        if(!$response['status']) {
            return redirect()->back()->withInput();
        }
        return redirect(url("/backend/category"));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = $this->catRepo->findCategory($id);
        return view("backend.pages.category.form", compact("category"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $response = $this->catRepo->updateCategory($request, $id);
        alertNotify($response['status'], $response['data'], $request);
        if(!$response['status']) {
            return redirect()->back()->withInput();
        }
        return redirect(url("/backend/category"));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $request)
    {
        $response = $this->catRepo->destroyData($id);
        return redirect()->back();
    }
}
