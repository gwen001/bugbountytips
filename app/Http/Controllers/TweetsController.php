<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Tweet;

class TweetsController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->get('q');

        if( $q ) {
            $tweets = Tweet::where('message', 'like', "%{$q}%")->get();
        } else {
            $tweets = Tweet::all();
        }

        return response($tweets->jsonSerialize(), Response::HTTP_OK);
    }

    public function update(Request $request, $id)
    {
        // $tweet = Tweet::findOrFail($id);
        // $tweet->keywords = $request->keywords;
        // // $tweet->keywords = $request->keywords;
        // // $tweet->keywords = $request->keywords;
        // $tweet->save();

        // return response(null, Response::HTTP_OK);
    }

    public function destroy($id)
    {
        // Tweet::destroy($id);

        // return response(null, Response::HTTP_OK);
    }
}
