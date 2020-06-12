<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


class AdminController extends Controller
{
    /**
     * Show admin dashboard
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return redirect()->route('tweets.index');
        // return $dataTable->render('back.dashboard');
    }
    // public function index(Request $request)
    // {
    //     $tweets = Tweet::all();

    //     return view('back.dashboard', ['tweets'=>$tweets] );
    // }
}
