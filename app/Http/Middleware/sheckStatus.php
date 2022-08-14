<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\Auth;

use Closure;
use Illuminate\Http\Request;
use App\Models\User;

class sheckStatus
{


    public function handle(Request $request, Closure $next)
    {
     // dd($request->user()->Status);
        if($request->user()->Status === 'مفعل'){
            return $next($request);
        }else{
            session()->flash('non','تم ايقاف حسابك من قبل مدير النظام');
            return redirect()->back();
        }

    }
}
