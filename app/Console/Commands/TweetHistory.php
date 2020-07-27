<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Tweet;
use Twitter;
use TwitterAPIExchange;

class TweetHistory extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tweet:history {--from=} {--to=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Grab tweets from Twitter';

    /**
     * indexes
     *
     * @var integer
     */
    protected $i_env = 0;
    protected $i_consumer_key = 1;
    protected $i_consumer_secret = 2;
    protected $i_access_token = 3;
    protected $i_access_secret = 4;

    /**
     * Keyword to use for the search
     *
     * @var string
     */
    protected $keyword = 'bugbountytips';

    /**
     * Twitter credentials
     *
     * @var array
     */
    protected $credentials = [];

    /**
     * Twitter api url
     *
     * @var string
     */
    protected $api_url = 'https://api.twitter.com/1.1/tweets/search/fullarchive/__ENV__.json';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    protected function parse_credentials()
    {
        $t_credentials = [];

        for( $i=1 ; $i<=100 ; $i++ ) {
            $v = 'TWITTER_'.$i;
            if( isset($_ENV[$v]) ) {
                $t_credentials[] = explode( ',', $_ENV[$v] );
            }
        }

        return $t_credentials;
    }

    private function build_query( $t_params )
    {
        $tmp = [];

        foreach( $t_params as $k=>$v ) {
            $tmp[] = $k.'='.$v;
        }

        return implode('&',$tmp);
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        $from = $this->option('from') ? $this->option('from').'0000' : '201501010000';
        $to = $this->option('to') ? $this->option('to').'2359' : date('Ymd').'0000';

        $this->credentials = $this->parse_credentials();

        $n = $this->grab_history( $from, $to );

        echo $n." tweets inserted\n";
    }

    public function grab_history( $from, $to )
    {
        $total = 0;

        echo "Grabbing all tweets from ".$from." to ".$to."\n";

        $from_ts = strtotime( $from );
        $to_ts = strtotime( $to );
        var_dump($from_ts);
        var_dump($to_ts);

        $from_date = date( 'Y-m-d H:i:s', $from_ts );
        $from_year = date( 'Y', $from_ts );
        $from_month = date( 'm', $from_ts );
        $from_day = date( 'd', $from_ts );
        var_dump( $from_date );

        $to_date = date( 'Y-m-d H:i:s', $to_ts );
        $to_year = date( 'Y', $to_ts );
        $to_month = date( 'm', $to_ts );
        $to_day = date( 'd', $to_ts );
        var_dump( $to_date );

        $datetime1 = new \DateTime($from_date);
        $datetime2 = new \DateTime($to_date);
        $interval = $datetime1->diff($datetime2);
        // $interval->days++;
        echo $interval->days." days to grab\n";

        // Last archive: 20200716
        // First archive: 20190101
        // 202004280000 -> 202004282359 -> 20200428
        // 202001050000 -> 202001052359 -> 20200106
        // 201912240000 -> 201912242359 -> 20191225

        for( $day=0 ; $day<=$interval->days ; $day++ )
        // for( $day=1 ; $day<$interval->days ; $day++ )
        {
            // $current_date_start = date('YmdHi',mktime(0,0,0,$from_month,$from_day+$day,$from_year));
            // $current_date_end = date('YmdHi',mktime(23,59,0,$from_month,$from_day+$day,$from_year));
            $current_date_start = date('YmdHi',mktime(0,0,0,$to_month,$to_day-$day,$to_year));
            $current_date_end = date('YmdHi',mktime(23,59,0,$to_month,$to_day-$day,$to_year));
            echo $current_date_start. ' -> '.$current_date_end."\n";

            $n = $this->grab( $current_date_start, $current_date_end );
            $total += $n;
        }

        return $total;
    }

    protected function grab( $date_start, $date_end )
    {
        $run = true;
        $n_credentials = count( $this->credentials );
        $total = 0;
        $n = 0;

        $params = [
            'query' => $this->keyword,
            'fromDate' => $date_start,
            'toDate' => $date_end,
        ];
        // var_dump( $params );

        echo "Day: ".$date_start."\n";

        do
        {
            usleep( 1000000 );

            $rand = rand( 0, $n_credentials-1 );
            $creds = $this->credentials[ $rand ];
            $api_url = str_replace( '__ENV__', $creds[$this->i_env], $this->api_url );
            // var_dump( $api_url );

            $settings = [
                'consumer_key' => $creds[$this->i_consumer_key],
                'consumer_secret' => $creds[$this->i_consumer_secret],
                'oauth_access_token' => $creds[$this->i_access_token],
                'oauth_access_token_secret' => $creds[$this->i_access_secret],
            ];
            // var_dump( $settings );

            $query = $this->build_query( $params );
            // var_dump( $query );
            $twitter = new TwitterAPIExchange( $settings );
            $results = json_decode( $twitter->setGetfield($query)->buildOauth($api_url,'GET')->performRequest() );
            // var_dump( $results );
            // exit();

            if( isset($results->error) ) {
                var_dump( $results );
                if( stristr($results->error->message,'Please upgrade') ) {
                    $n_credentials--;
                    echo "Credentials removed: ".$creds[$this->i_consumer_key]." (".$n_credentials." remaining)\n";
                    unset( $this->credentials[$rand] );
                    sort( $this->credentials );

                }
                if( $n_credentials <= 0 ) {
                    var_dump( $results );
                    exit();
                }
                continue;
                // exit();
            }

            $n_results = count( $results->results );
            echo $n_results." n_results\n";

            if( $n_results )
            {
                foreach( $results->results as $item )
                {
                    $r = $this->insert_item( $item );

                    if( $r ) {
                        $n++;
                        $total++;
                    }
                }
            }

            if( isset($results->next) ) {
                $params['next'] = $results->next;
            } else {
                $run = false;
            }

            echo $n." tweets inserted in that loop\n";
        }
        while( $run );

        echo $total." tweets inserted for that day\n";

        return $n;
    }

    protected function insert_item( $item )
    {
        if( isset($item->retweeted_status) ) {
            echo $item->id_str." is a RT, skip\n";
            return false;
        }

        $exist = Tweet::where( 'twitter_id', $item->id_str )->first();

        if( $exist ) {
            return false;
        }

        $r = Tweet::create([
            'twitter_id' => $item->id_str,
            'message' => isset($item->full_text) ? $item->full_text : $item->text,
            'tweeted_at' => date( 'Y-m-d H:i:s', strtotime($item->created_at) ),
        ]);

        if( $r ) {
            echo $item->id_str." inserted\n";
            return true;
        } else {
            return false;
        }
    }


    //     $run = true;

    //     do
    //     {
    //         usleep( 1000000 );

    //         $settings = array( // FULL EnvFull
    //             'consumer_key' => $_ENV['TWITTER_CONSUMER_KEY'],
    //             'consumer_secret' => $_ENV['TWITTER_CONSUMER_SECRET'],
    //             'oauth_access_token' => $_ENV['TWITTER_ACCESS_TOKEN'],
    //             'oauth_access_token_secret' => $_ENV['TWITTER_ACCESS_TOKEN_SECRET'],
    //             );


    //         $getfield = $this->build_params( $t_params );
    //         $twitter = new TwitterAPIExchange($settings);
    //         $results = json_decode($twitter->setGetfield($getfield)->buildOauth($url,'GET')->performRequest(),$assoc = TRUE);

    //         if(array_key_exists("errors", $results) || array_key_exists("error", $results)) {
    //         var_dump( $results );
    //         exit();
    //         }

    //         var_dump( count($results['results']) );

    //         if( isset($results['next'])) {
    //             $t_params['next'] = $results['next'];
    //         } else {
    //             $run = false;
    //         }
    //     }
    //     while( $run );

    //     exit();


    //     $from_ts = strtotime( $from );
    //     $to_ts = strtotime( $to );
    //     var_dump($from_ts);
    //     var_dump($to_ts);

    //     $from_date = date( 'Y-m-d H:i:s', $from_ts );
    //     $from_year = date( 'Y', $from_ts );
    //     $from_month = date( 'm', $from_ts );
    //     $from_day = date( 'd', $from_ts );
    //     var_dump( $from_date );

    //     $to_date = date( 'Y-m-d H:i:s', $to_ts );
    //     var_dump( $to_date );

    //     $datetime1 = new \DateTime($from_date);
    //     $datetime2 = new \DateTime($to_date);
    //     $interval = $datetime1->diff($datetime2);
    //     var_dump( $interval->days );

    //     for( $day=0 ; $day<$interval->days ; $day++ )
    //     {
    //         $current_date_start = date('YmdHi',mktime(0,0,0,$from_month,$from_day+$day,$from_year));
    //         $current_date_end = date('YmdHi',mktime(23,59,0,$from_month,$from_day+$day,$from_year));
    //         echo $current_date_start. ' -> '.$current_date_end."\n";

    //         $search_params = [
    //             'q' => '#bugbountytips',
    //             'count' => 100,
    //             'format' => 'json',
    //             'fromDate' => $current_date_start,
    //             'toDate' => $current_date_end
    //         ];
    //         var_dump( $search_params );

    //         $t_tweets = json_decode( Twitter::getSearch($search_params) );
    //         echo count($t_tweets->statuses)." tweets retrieved\n";

    //         foreach( $t_tweets->statuses as $item )
    //         {
    //             // if( isset($t_tweets->search_metadata) && isset($t_tweets->search_metadata->next_results) ) {
    //             //     $m = preg_match( '/max_id=([0-9]+)&/', $t_tweets->search_metadata->next_results, $matches );
    //             //     if( $m ) {
    //             //         $max_id = $matches[1];
    //             //     }
    //             // }

    //             echo $item->id_str."\n";
    //             echo date( 'Y-m-d H:i:s', strtotime($item->created_at) )."\n";
    //             echo "\n";
    //             continue;

    //             // if( strpos($text,'RT ') === 0 ) {
    //             if( isset($item->retweeted_status) ) {
    //                 echo $item->id_str." is a RT, skip\n";
    //                 continue;
    //             }

    //             $exist = Tweet::where( 'twitter_id', $item->id_str )->first();

    //             if( !$exist ) {
    //                 $r = Tweet::create([
    //                     'twitter_id' => $item->id_str,
    //                     'message' => isset($item->full_text) ? $item->full_text : $item->text,
    //                     'tweeted_at' => date( 'Y-m-d H:i:s', strtotime($item->created_at) ),
    //                 ]);

    //                 if( $r ) {
    //                     echo $item->id_str." inserted\n";
    //                     $n++;
    //                 }
    //             }
    //         }
    //     }

    //     return $n;
    // }


    // public function grab_history_old()
    // {
    //     echo "Grabbing all tweets\n";
    //     $nolimit = $this->option('nolimit');
    //     $max_id = $this->option('maxid') ? $this->option('maxid') : '';
    //     $loop = true;
    //     $n = 0;

    //     do
    //     {
    //         usleep( 1000000 );

    //         $t_tweets = json_decode( Twitter::getSearch(['max_id'=>$max_id, 'q'=>'#bugbountytips', 'count'=>100, 'format'=>'json', 'tweet_mode'=>'extended']) );
    //         echo count($t_tweets->statuses)." tweets retrieved\n";

    //         foreach( $t_tweets->statuses as $item )
    //         {
    //             if( isset($t_tweets->search_metadata) && isset($t_tweets->search_metadata->next_results) ) {
    //                 $m = preg_match( '/max_id=([0-9]+)&/', $t_tweets->search_metadata->next_results, $matches );
    //                 if( $m ) {
    //                     $max_id = $matches[1];
    //                 }
    //             }

    //             $text = isset($item->full_text) ? $item->full_text : $item->text;

    //             // if( strpos($text,'RT ') === 0 ) {
    //             if( isset($item->retweeted_status) ) {
    //                 echo $item->id_str." is a RT, skip\n";
    //                 continue;
    //             }

    //             $exist = Tweet::where( 'twitter_id', $item->id_str )->first();

    //             if( $exist && !$nolimit ) {
    //                 echo $item->id_str." seems to be the limit\n";
    //                 $loop = false;
    //                 break;
    //             }

    //             if( !$exist ) {
    //                 $r = Tweet::create([
    //                     'twitter_id' => $item->id_str,
    //                     'message' => isset($item->full_text) ? $item->full_text : $item->text,
    //                     'tweeted_at' => date( 'Y-m-d H:i:s', strtotime($item->created_at) ),
    //                 ]);

    //                 if( $r ) {
    //                     echo $item->id_str." inserted\n";
    //                     $n++;
    //                 }
    //             }
    //         }
    //     }
    //     while( $loop );

    //     return $n;
    // }
}
