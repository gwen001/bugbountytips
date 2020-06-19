<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DataTables\TweetsDataTable;
use App\Http\Requests\TweetRequest;
use App\Tweet;


class TweetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(TweetsDataTable $dataTable)
    {
        return $dataTable->render('back.tweets');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // return view('back.tweets.form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TweetRequest $request)
    {
        \Artisan::queue('tweet:grab', ['tweet'=>$request->twitter_id]);
        return redirect()->route('tweets.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Tweet  $tweet
     * @return \Illuminate\Http\Response
     */
    public function show(Tweet $tweet)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Tweet  $tweet
     * @return \Illuminate\Http\Response
     */
    public function edit(Tweet $tweet)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Tweet  $tweet
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $tweet = Tweet::findOrFail( $request->id );
        $tweet->message = $request->message;
        $tweet->save();

        return redirect(route('tweets.index'));
    }

    public function ignore($id)
    {
        $tweet = Tweet::findOrFail($id);
        $tweet->ignore = 1;
        $tweet->save();

        return redirect(route('tweets.index'));
    }

    public function unignore($id)
    {
        $tweet = Tweet::findOrFail($id);
        $tweet->ignore = 0;
        $tweet->save();

        return redirect(route('tweets.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Tweet  $tweet
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tweet $tweet)
    {
        $tweet->delete();
        return redirect(route('tweets.index'));
    }
}
