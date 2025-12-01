<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
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
        Schema::dropIfExists('posts');
/*
        Schema::table('posts', function (Blueprint $table) {
            $table->dropColumn('description');
        });
*/
    }
};

/*
    1) once columns created, cant change anything in it
    2) can add new columns by creating new migration
    3) migrations are executed once

    php artisan migrate:fresh                           // drop all tables and create them again
    php artisan make:migration create_posts_table       // create new migration
    php artisan migrate:rollback                        // rollback last migration
*/
