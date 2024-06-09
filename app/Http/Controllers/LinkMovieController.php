<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movie;
use App\Models\Category;
use App\Models\Country;
use App\Models\Genre;
use App\Models\Movie_Genre;
use App\Models\Episode;
use App\Models\LinkMovie;

class LinkMovieController extends Controller
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
        $list =LinkMovie::all();
        return view('admincp.linkmovie.form',compact('list'));
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
        $linkmovie = new LinkMovie();
        $linkmovie->title= $data['title'];
        $linkmovie->description=$data['description'];
        $linkmovie->status=$data['status'];
        $linkmovie->save();
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
        $linkmovie= LinkMovie::find($id);
        $list =LinkMovie::all();
        return view('admincp.linkmovie.form',compact('list','linkmovie'));
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
        $linkmovie = LinkMovie::find($id);
        $linkmovie->title= $data['title'];
        $linkmovie->description=$data['description'];
        $linkmovie->status=$data['status'];
        $linkmovie->save();
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
        LinkMovie::find($id)->delete();
        toastr()->success('Dữ liệu đã được lưu!');
        
        return redirect()->back();
    }
}
