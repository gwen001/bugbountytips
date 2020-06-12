<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Tweet;

class TweetsController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->get('q');
        $page = $request->get('p');
        $limit = 20;
        $skip = $page * $limit;

        if( $query ) {
            $tweets = Tweet::where('message', 'like', "%{$query}%")->where('ignore', '=', '0')->skip($skip)->take($limit)->get();
        } else {
            $tweets = Tweet::where('ignore', '=', '0')->skip($skip)->take($limit)->get();
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
