<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MakeTaggablesPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /*
            tag_id - integer
            taggable_id - integer
            taggable_type - string
         */
        Schema::create(
            'taggables',
            function (Blueprint $table) {
                $table->bigInteger('tag_id');
                $table->bigInteger('taggable_id');
                $table->string("taggable_type");
                $table->timestamps();
            }
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('taggables');
    }
}
