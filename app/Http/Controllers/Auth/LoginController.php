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
        // var_dump( $u );
        // var_dump( $p );
        // var_dump( $request->login );
        // var_dump( $request->password );
        // var_dump( crypt($request->login,$u) );
        // var_dump( hash_equals($u, crypt($request->login,$u)) );
        // var_dump( crypt($request->password,$p) );
        // var_dump( hash_equals($p, crypt($request->password,$p)) );
        // exit();

        if( hash_equals($u,$request->login) && hash_equals($p,$request->password) ) {
            $request->session()->put('admin', 1);
            return redirect()->route('tweets.index');
        } else {
            return redirect()->route('login');
        }
    }
}
