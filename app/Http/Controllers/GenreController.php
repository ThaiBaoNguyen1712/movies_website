<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Genre;
class genreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $list =Genre::orderBy('position','ASC')->get();
        return view('admincp.genre.form',compact('list'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data=$request->all();
        $genre = new Genre();
        $genre->title= $data['title'];
        $genre->description=$data['description'];
        $genre->status=$data['status'];
        $genre->slug=$data['slug'];
        $genre->save();
        toastr()->success('Dữ liệu đã được lưu!');

        return redirect()->back();
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
        $genre= Genre::find($id);
        $list=Genre::all();
        return view('admincp.genre.form',compact('list','genre'));
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
        $data=$request->all();
        $genre = Genre::find($id);
        $genre->title= $data['title'];
        $genre->description=$data['description'];
        $genre->status=$data['status'];
        $genre->slug=$data['slug'];
        $genre->save();
        toastr()->success('Dữ liệu đã được lưu!');

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        genre::find($id)->delete();
        toastr()->success('Dữ liệu đã được lưu!');

        return redirect()->back();
    }
    public function resorting(Request $request)
    {
        $data=$request->all();
        foreach($data['array_id'] as $key=>$value)
        {
            $genre=Genre::find($value);
            $genre->position =$key;
            $genre->save();
        }
    }
}
