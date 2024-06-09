<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movie;
use App\Models\Episode;
use App\Models\LinkMovie;

use Carbon\Carbon;

class EpisodeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $linkmovie = LinkMovie::orderBy('id','DESC')->pluck('title','id');
        $list_server =LinkMovie::orderBy('id','DESC')->get();
        $list_episode= Episode::with('movie')->orderBy('movie_id','DESC')->get();
        // return response()->json($list_episode);

        return view('admincp.episode.index',compact('list_episode','linkmovie','list_server'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $linkmovie = LinkMovie::orderBy('id','DESC')->pluck('title','id');
        $list_server =LinkMovie::orderBy('id','DESC')->get();
        $list_movie= Movie::orderBy('id','DESC')->pluck('title','id');
        return view('admincp.episode.form',compact('list_movie','linkmovie','list_server'));
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
        $episode_check =Episode::where('episode',$data['episode'])->where('movie_id',$data['movie_id'])->where('server',$data['server'])->count();
        if($episode_check >0)
        {
            toastr()->error('Đã có lỗi, vui lòng kiểm tra lại dữ liệu.');
            return redirect()->back();
        }
        else{
            $ep = new Episode();
            $ep->movie_id= $data['movie_id'];
            $ep->link=$data['link'];
            $ep->episode=$data['episode'];
            $ep->server=$data['server'];
            $ep->created_at= Carbon::now('Asia/Ho_Chi_Minh');
            $ep->updated_at= Carbon::now('Asia/Ho_Chi_Minh');
        $ep->save();
        toastr()->success('Dữ liệu đã được lưu!');
        }
      

        return redirect()->back();
    }
    public function add_episode($id)
    {
        $linkmovie = LinkMovie::orderBy('id','DESC')->pluck('title','id');
        $episode= Movie::with('episode')->Find($id);
        $list_server =LinkMovie::orderBy('id','DESC')->get();
        $list_episode = Episode::with('movie')->where('movie_id',$id)->orderBy('episode','DESC')->get();
    
        return view('admincp.episode.add_episode',compact('list_episode','episode','linkmovie','list_server'));
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
        $list_movie= Movie::orderBy('id','DESC')->pluck('title','id');
          $linkmovie = LinkMovie::orderBy('id','DESC')->pluck('title','id');
        $episode = Episode::Find($id);
        return view('admincp.episode.form',compact('episode','list_movie','linkmovie'));
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
        $ep= Episode::Find($id);
        // $episode_check =Episode::where('episode',$data['episode'])->where('movie_id',$data['movie_id'])->where('server',$data['server'])->count();
        // if($episode_check >0)
        // {
        //     toastr()->error('Đã có lỗi, vui lòng kiểm tra lại dữ liệu.');
        //     return redirect()->back();
        // }
        $ep->movie_id= $data['movie_id'];
        $ep->link=$data['link'];
        $ep->episode=$data['episode'];
        $ep->server=$data['server'];
        $ep->created_at= Carbon::now('Asia/Ho_Chi_Minh');
        $ep->updated_at= Carbon::now('Asia/Ho_Chi_Minh');
        $ep->save();
        toastr()->success('Dữ liệu đã được lưu!');

        return redirect()->to('add-episode/'.$ep->movie_id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $episode = Episode::Find($id)->delete();
        return redirect()->back();
    }
    public function select_movie()
    {
        $id= $_GET['id'];
        $movie = Movie::with('episode')->find($id);
        $output='  <option value="" class="text-center">---Chọn tập phim---</option>';
        if($movie->thuocphim=='phimbo')
        {
          
        for($i=1;$i<=$movie->sotap;$i++)
        {
            $episode = $movie->episode->where('episode', $i)->first(); // Get the episode by number
            if ($episode && $episode->link != null)
            {
            $checkexist = '(Đã thêm)';
            $output.=' <option class="text-center" value="'.$i.'">'.$i.' ' .$checkexist. '</option>';
            }
            else
            {
                $output.=' <option class="text-center" style="font-weight: bold; value="'.$i.'">'.$i.'</option>';

            }
        }
        }
        else{
            $output.='<option value="HD">HD</option>
            <option value="FullHD">FullHD</option>
            <option value="Cam">Cam</option>
            <option value="HDCam">HDCam</option>';
        }
        echo $output;
    }
}
