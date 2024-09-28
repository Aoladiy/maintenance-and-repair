<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('components', function (Blueprint $table) {
            //main characteristics
            $table->id();
            $table->string('name');
            $table->string('vendor_code')->nullable();
            $table->integer('amount')->nullable();
            $table->bigInteger('all_alerts_number')->nullable();
            $table->timestamps();

            //foreign keys
            $table->unsignedBigInteger('node_id')->index();
            $table->unsignedBigInteger('unit_id')->index()->default(1);

            $table->foreign('node_id')->references('id')->on('nodes')->restrictOnDelete();
            $table->foreign('unit_id')->references('id')->on('units')->restrictOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('components');
    }
};
