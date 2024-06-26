<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Country;
class CountryController extends Controller
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
        $list =Country::orderBy('position','ASC')->get();
        return view('admincp.country.form',compact('list'));
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
        $check = Country::where('slug', $data['slug'])->count();
        if($check > 0)
        {
            toastr()->error('Trùng dữ liệu, vui lòng kiểm tra lại');
            return redirect()->back();
        }
        else
        {
            $country = new Country();
            $country->title= $data['title'];
            $country->description=$data['description'];
            $country->status=$data['status'];
            $country->slug=$data['slug'];
            $country->save();
            toastr()->success('Dữ liệu đã được lưu!');
        }
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
        $country= Country::find($id);
        $list=Country::all();
        return view('admincp.country.form',compact('list','country'));
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
        $country = Country::find($id);
        $country->title= $data['title'];
        $country->description=$data['description'];
        $country->status=$data['status'];
        $country->slug=$data['slug'];
        $country->save();
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
        Country::find($id)->delete();
        return redirect()->back();
    }
    public function resorting(Request $request)
    {
        $data=$request->all();
        foreach($data['array_id'] as $key=>$value)
        {
            $country=Country::find($value);
            $country->position =$key;
            $country->save();
        }
    }
}
