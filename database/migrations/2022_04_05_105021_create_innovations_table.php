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
        Schema::create('innovations', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->string('name');
            $table->string('abbreviation');
            $table->string('pays');
            $table->date('date_fondation')->nullable();
            $table->text('description')->nullable();
            $table->string('personne_contact')->nullable();
            $table->string('telephone')->nullable();
            $table->string('email_innovation')->nullable();
            $table->string('site_web')->nullable();
            $table->string('facebook')->nullable();
            $table->string('twitter')->nullable();
            $table->string('instagram')->nullable();
            $table->string('linkedin')->nullable();
            $table->string('longitude');
            $table->string('latitude');
            $table->text('siege');
            $table->boolean('active')->default(false);
            $table->text('reference')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('innovations');
    }
};
