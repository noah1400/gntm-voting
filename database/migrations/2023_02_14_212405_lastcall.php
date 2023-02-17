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
        Schema::create('lastcall', function (Blueprint $table) {
            $table->id();
            $table->string('type'); // 'create', 'increase'
            $table->string('affected');  // if type is 'create' then this is the activity_id of the new activity
                                                        // if type is 'increase' then this is the activity_id of the activity to increase
            $table->timestamps();

            $table->foreignId('model_id')->nullable()->constrained('top_models')->cascadeOnDelete();
            $table->foreignId('activity_id')->nullable()->constrained('activities')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lastcall');
    }
};
