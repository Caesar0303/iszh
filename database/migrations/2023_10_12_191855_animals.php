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
        Schema::create('animals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('owner_id');
            $table->foreignId('region');
            $table->foreignId('city');
            $table->string('type');
            $table->string('breed');
            $table->string('image');
            $table->string('gender');
            $table->date('date_of_birth');
            $table->string('direction')->nullable();
            $table->string('reason_for_staging')->nullable();
            $table->date('date_for_registration')->nullable();
            $table->string('identification_method')->nullable();
            $table->string('note');
            $table->integer('price');
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
        Schema::dropIfExists('animals');
    }
};
