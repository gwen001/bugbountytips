#!/bin/bash

cd /var/www/html/bugbountytips ; php artisan tweet:history --to $(($(date +%Y%m%d)-1)) --from $(($(date +%Y%m%d)-1))
