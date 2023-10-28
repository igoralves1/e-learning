<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('cities', function (Blueprint $table) {
            $table->bigIncrements('id')->autoIncrement();
            $table->index(['id']);
            
            $table->bigInteger('province_id')  ->unsigned()->nullable(false);
            
            $table->char('name', 50)          ->nullable(false);
            $table->char('geocode', 50)       ->nullable();
            $table->decimal('lat', 10,8)      ->nullable();
            $table->decimal('long', 11,8)     ->nullable();
            
            $table->foreign('province_id')
                ->references('id')
                ->on('provinces')
                ->onDelete('cascade');
            
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
            $table->softDeletes()->nullable()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cities');
    }
};
