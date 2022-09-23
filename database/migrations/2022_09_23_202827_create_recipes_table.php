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
        Schema::create('recipes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('resource_id')->comment('The produced resource')->constrained('resources')->cascadeOnDelete();
            $table->string('rate')->comment('Rate of production per minute');
            $table->integer('amount')->comment('Amount of resource produced');
            // raw data
            $table->mediumInteger('time');
            $table->mediumInteger('manualTimeMultiplier')->default(1);
            $table->string('className')->nullable();
            $table->json('categories')->nullable();
            $table->boolean('alternate')->default(false);
            $table->boolean('forBuilding')->default(false);
            $table->boolean('inMachine')->default(false);
            $table->boolean('inHand')->default(false);
            $table->boolean('inWorkshop')->default(false);
            $table->json('producedIn')->nullable();
            $table->json('ingredients')->nullable();
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
        Schema::dropIfExists('recipes');
    }
};
