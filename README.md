<h1 align="center">bugbountytips</h1>

<h4 align="center">Single page webapp to perform regexp search over GitHub search.</h4>

<p align="center">
    <img src="https://img.shields.io/badge/php-%3E=7.2.5-blue" alt="php badge">
    <img src="https://img.shields.io/badge/license-MIT-green" alt="MIT license badge">
    <a href="https://twitter.com/intent/tweet?text=https%3a%2f%2fgithub.com%2fgwen001%2fbugbountytips%2f" target="_blank"><img src="https://img.shields.io/twitter/url?style=social&url=https%3A%2F%2Fgithub.com%2Fgwen001%2Fbugbountytips" alt="twitter badge"></a>
</p>

<!-- <p align="center">
    <img src="https://img.shields.io/github/stars/gwen001/bugbountytips?style=social" alt="github stars badge">
    <img src="https://img.shields.io/github/watchers/gwen001/bugbountytips?style=social" alt="github watchers badge">
    <img src="https://img.shields.io/github/forks/gwen001/bugbountytips?style=social" alt="github forks badge">
</p> -->

---

## Description

[#bugbountytips](http://bugbountytips.me) is a single page website made with love, by hackers for hackers.
It's supposed to help to find useful tips on Twitter trought the hashtag [#bugbountytips](https://twitter.com/search?q=%23bugbountytips&src=typed_query&f=live).
This webservice is my contribution to the security industry, if you like it, you can support my work.

## Install

```
git clone https://github.com/gwen001/bugbountytips
cd bugbountytips
composer update && composer install
```

Edit `.env` file:
```
APP_NAME=bugbountytips
APP_ENV=local
APP_KEY=base64:HMpa3cPt6HTJKRuV5asjrD/vj2P1w8mE71i7LPPG/TI=
APP_DEBUG=true
APP_URL=http://xxx.example.com

APP_ADMIN_LOGIN=admin
APP_ADMIN_PASS=admin

DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=bugbountytips
DB_USERNAME=root
DB_PASSWORD=root

# from twitter developers platform
TWITTER_CONSUMER_KEY=
TWITTER_CONSUMER_SECRET=
TWITTER_ACCESS_TOKEN=
TWITTER_ACCESS_TOKEN_SECRET=
```

Migrate database:
```
php artisan migrate:install
php artisan db:seed
```

Run the app:
```
npm install
npm run dev
```

## Note

Since the hashtag has been spammed with so many shit, the project has been abandoned.  

---

<img src="https://raw.githubusercontent.com/gwen001/bugbountytips/master/preview.png">

---

Feel free to [open an issue](/../../issues/) if you have any problem with the script.  
