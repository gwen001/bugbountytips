<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Tweet;
use Twitter;

class TweetGrabber extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tweet:grab {tweet?} {--nolimit} {--maxid=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Grab tweets from Twitter';

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
        } else {
            $n = $this->grab_history();
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
            'message' => isset($tweet->full_text) ? $tweet->full_text : $tweet->text
        ]);

        if( $r ) {
            echo $tweet->id_str." inserted\n";
            return true;
        } else {
            return false;
        }
    }


    public function grab_history()
    {
        echo "Grabbing all tweets\n";
        $nolimit = $this->option('nolimit');
        $max_id = $this->option('maxid') ? $this->option('maxid') : '';
        $loop = true;
        $n = 0;

        do
        {
            $t_tweets = json_decode( Twitter::getSearch(['max_id'=>$max_id, 'q'=>'#bugbountytips', 'count'=>100, 'format'=>'json', 'tweet_mode'=>'extended']) );
            echo count($t_tweets->statuses)." tweets retrieved\n";

            foreach( $t_tweets->statuses as $item )
            {
                if( isset($t_tweets->search_metadata) && isset($t_tweets->search_metadata->next_results) ) {
                    $m = preg_match( '/max_id=([0-9]+)&/', $t_tweets->search_metadata->next_results, $matches );
                    if( $m ) {
                        $max_id = $matches[1];
                    }
                }

                $text = isset($item->full_text) ? $item->full_text : $item->text;

                // if( strpos($text,'RT ') === 0 ) {
                if( isset($item->retweeted_status) ) {
                    echo $item->id_str." is a RT, skip\n";
                    continue;
                }

                $exist = Tweet::where( 'twitter_id', $item->id_str )->first();

                if( $exist && !$nolimit ) {
                    echo $item->id_str." seems to be the limit\n";
                    $loop = false;
                    break;
                }

                if( !$exist ) {
                    $r = Tweet::create([
                        'twitter_id' => $item->id_str,
                        'message' => isset($item->full_text) ? $item->full_text : $item->text,
                        'tweeted_at' => date( 'Y-m-d H:i:s', strtotime($item->created_at) ),
                    ]);

                    if( $r ) {
                        echo $item->id_str." inserted\n";
                        $n++;
                    }
                }
            }
        }
        while( $loop );

        return $n;
    }
}
