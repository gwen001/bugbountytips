<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTweetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::create('tweets', function (Blueprint $table) {
        //     $table->id();
        //     $table->string('twitter_id', 32);
        //     $table->text('message');
        //     $table->text('keywords');
        //     $table->boolean('ignore');
        //     $table->timestamps();
        // });

        // Schema::table('tweets', function (Blueprint $table) {
        //     $table->text('keywords')->nullable()->change();
        //     $table->boolean('ignore')->default(false)->change();
        // });

        // Schema::table('tweets', function (Blueprint $table) {
        //     $table->dropColumn('keywords');
        // });

        Schema::table('tweets', function (Blueprint $table) {
            $table->timestamp('tweeted_at',0)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tweets');
    }
}
