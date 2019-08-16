<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MakeCategoryPostTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /*
         * NOTICE!!
         * While referencing pivot table Laravel will use ALPHABETICAL order of join of table names
         * For example:
         * Category + Post = category_post
         * User + Attribute = attribute_user
         * Role + VeryInterestedPerson = role_very_interested_person
         *
         */
        Schema::create('category_post', function (Blueprint $table) {
            $table->bigInteger("category_id");
            $table->bigInteger("post_id");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('category_post');
    }
}
