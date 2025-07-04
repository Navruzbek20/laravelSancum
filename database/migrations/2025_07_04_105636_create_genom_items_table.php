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
        Schema::create('genom_items', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('gemon_id');
            $table->bigInteger('locus_id');
            $table->double('a1');
            $table->double('a2');
            $table->double('a3');
            $table->double('a4');
            $table->double('a5');
            $table->double('a6');
            $table->double('a7');
            $table->double('a8');
            $table->double('a9');
            $table->boolean('status')->default(0);
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
        Schema::dropIfExists('genom_items');
    }
};
