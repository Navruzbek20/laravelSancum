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
        Schema::create('persons', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('code_id');
            $table->string('surname');
            $table->string('name');
            $table->string('ful_name');
            $table->enum('work_type', ['Tirik inson', 'Biomaterial']);
            $table->date('birth_date')->nullable();
            $table->bigInteger('province_id')->nullable();
            $table->enum('sex', ['Erkak', 'Ayol'])->nullable();
            $table->enum('citizenship', ['O‘zbekiston', 'Rossiya','Qozogiston','Qirgiziston'])->nullable();
            $table->enum('nationality', ['o‘zbek', 'qozoq', 'qirg‘iz', 'tojik', 'rus', 'tatar', 'ukrain', 'boshqa'])->nullable();
            $table->string('address')->nullable();
            $table->string('p_number')->nullable();
            $table->string('document')->nullable();
            $table->string('category')->nullable();
            $table->enum('name_object', ['Jinoyat ishi', 'Oila ichi mojaro', 'Shaxsni aniqlash','Hukum qilingan shaxs','Tanib olinmagan murda (tana qoldiqlari, qisimlari', 'Boshqa'])->nullable();
            $table->boolean('active')->default(false);
            $table->bigInteger('district_id')->nullable();
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
        Schema::dropIfExists('persons');
    }
};
