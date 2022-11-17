<?php

use Illuminate\Database\Seeder;
use App\Tweet;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UserSeeder::class);
        // factory(Tweet::class, 10)->create();

        $t_tweets = [
            [
                'twitter_id' => '1591410557185294337',
                'tweeted_at' => '2022-11-12',
                'message' => 'What differentiates a pro from a beginner? Being able to stumble across something that isn\'t quite yet a vulnerability and escalating it! 📈  That\'s exactly what @Sazouki_  did when he turned a boring self-XSS into an actual XSS! 💪  #bugbounty #bugbountytips 👇',
            ],
            [
                'twitter_id' => '1592811142405312512',
                'tweeted_at' => '2022-11-16',
                'message' => 'WordPress Sensitive Endpoint 🪲 #bugbountytips #bugbounty #security #infosec',
            ],
            [
                'twitter_id' => '1592600862198988800',
                'tweeted_at' => '2022-11-15',
                'message' => 'Top 6 tools GraphQL Injection :⚙️💻 #infosecurity #cybersecurity #GraphQL #bugbountytips',
            ],
            [
                'twitter_id' => '1591516973045014528',
                'tweeted_at' => '2022-11-12',
                'message' => 'Yet another Account Takeover technique.  Seperator: email=victim@mail.com,hacker@mail.com email=victim@mail.com%20hacker@mail.com email=victim@mail.com|hacker@mail.com  Array: {"email":["victim@mail.com","hacker@mail.com"]}   #infosec #bugbountytips #cybersec',
            ],
            [
                'twitter_id' => '1592749037979336704',
                'tweeted_at' => '2022-11-16',
                'message' => 'Katana - URL Crawler by @pdiscoveryio   katana -u http://test.com -headless -jc -aff -kf -c 50 -fs dn  Link to GitHub: https://github.com/projectdiscovery/katana  I absolutely love this new tool! Helps speed up my process of mapping an attack surface 🔥  #bugbounty #bugbountytips',
            ],
            [
                'twitter_id' => '1592749536975675392',
                'tweeted_at' => '2022-11-16',
                'message' => '#bugbountytips  Private Program  Suddomains scanned with : https://github.com/cihanmehmet/sub.sh  Founded new subdomain http ://clients.xxxx.xxx  -> ApacheTomcat 1 - Dirs scanned founded dir : /files/ 2- PUT method tested and worked. 3 - Shell Uploaded.  Bounty : $XXX  #bugbounty #infosec',
            ],
            [
                'twitter_id' => '1591165393888059393',
                'tweeted_at' => '2022-11-11',
                'message' => '#BugBounty #bugbountytips #bugbountytip Easy and cool P1  If you found In Js File - Github -Etc..  [Okta Credentials] Client_ID & Client_SECRET  Step1 Base64-encode the client ID and Secret  1/2',
            ],
            [
                'twitter_id' => '1592418693203779586',
                'tweeted_at' => '2022-11-15',
                'message' => 'file upload vulnerability attack cheat sheet Download link: https://bit.ly/3tt8Ier #bugbounty #bugbountytips #infosec',
            ],
            [
                'twitter_id' => '1591491686609608704',
                'tweeted_at' => '2022-11-12',
                'message' => 'Top story: @Aacle_ : \'If a web application allow you to upload a .zip file, zip:// is an interesting PHP wrapper to turn a LFI into a RCE #BugBounty #BugBountyTips #InfoSec More on this🧵 :👇 \' , see more https://tweetedtimes.com/v/16476?s=tnp',
            ],
            [
                'twitter_id' => '1591135605622476801',
                'tweeted_at' => '2022-11-11',
                'message' => 'Bypasses for LFI, Auth bypass : #bugbountytips #cybersecuritytips #infosecurity',
            ],
        ];

        foreach( $t_tweets as $tweet ) {
            Tweet::create( $tweet );
        }
    }
}
