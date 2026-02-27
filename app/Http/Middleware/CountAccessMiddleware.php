<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;      
use Illuminate\Support\Facades\Session;

class CountAccessMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // Chỉ đếm đối với các yêu cầu GET (trang web thực)
        if ($request->isMethod('get')) {
            
            // Nếu session 'visited' chưa tồn tại
            if (!Session::has('visited_web')) {
                
                // Tăng giá trị cột access trong bảng truycap tại id = 1
                DB::table('truycap')->where('id', 1)->increment('access');

                // Gán session để lần sau họ load trang sẽ không đếm nữa (trong phiên làm việc đó)
                Session::put('visited_web', true);
            }
        }

        return $next($request);
    }
}
