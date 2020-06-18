<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Tweet;
use Twitter;

class TweetSingle extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tweet:single {tweet}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Grab a single tweet from Twitter';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $tweet_id = $this->argument('tweet');

        if( $tweet_id ) {
            $n = (int)$this->grab_single( $tweet_id );
        }

        echo $n." tweets inserted\n";
    }


    public function grab_single( $tweet_id )
    {
        echo "Grabbing a single tweet: ".$tweet_id."\n";
        $exist = Tweet::where( 'twitter_id', $tweet_id )->first();

        if( $exist ) {
            echo $tweet_id." found in the current database\n";
            return 0;
        }

        $tweet = Twitter::getTweet( $tweet_id );

        $r = Tweet::create([
            'twitter_id' => $tweet->id_str,
            'message' => isset($tweet->full_text) ? $tweet->full_text : $tweet->text,
            'tweeted_at' => date( 'Y-m-d H:i:s', strtotime($tweet->created_at) ),
        ]);

        if( $r ) {
            echo $tweet->id_str." inserted\n";
            return true;
        } else {
            return false;
        }
    }
}
