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
        Schema::create('resources', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('className');
            $table->string('description');
            $table->string('type')->nullable();
            // raw data
            $table->json('producedIn')->nullable();
            $table->integer('speed');
            $table->mediumInteger('stackSize')->nullable();
            $table->boolean('liquid')->default(false);
            $table->mediumInteger('energyValue')->nullable();
            $table->mediumInteger('radioactiveDecay')->nullable();
            $table->smallInteger('sinkPoints')->nullable();
            $table->json('pingColor')->nullable();
            $table->json('fluidColor')->nullable();
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
        Schema::dropIfExists('resources');
    }
};
