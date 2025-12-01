<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable();           // implicit default handling
            $table->foreign('user_id')->references('id')->on('users');
            //$table->foreignId('user_id')->nullable()->constrained();   // second way
        });
    }
};
