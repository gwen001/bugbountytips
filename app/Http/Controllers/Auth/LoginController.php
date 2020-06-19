<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /**
     * Login
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        return view('auth.login');
    }

    /**
     * Login
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        // var_dump( crypt('pass',uniqid()) );

        $u = $_ENV['APP_ADMIN_LOGIN'];
        $p = $_ENV['APP_ADMIN_PASS'];

        if( hash_equals($u, crypt($request->login,$u)) && hash_equals($p, crypt($request->password,$p)) ) {
            $request->session()->put('admin', 1);
            return redirect()->route('tweets.index');
        } else {
            return redirect()->route('login');
        }
    }
}
