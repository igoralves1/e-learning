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
        Schema::create('languages', function (Blueprint $table) {
            $table->bigIncrements('id')->autoIncrement();
            $table->index(['id']);
            
            $table->bigInteger('country_id')       ->unsigned()->nullable(false);
            
            $table->char('family', 200)     ->nullable(false);
            $table->char('iso_name', 200)   ->nullable(false);
            $table->char('native_name', 200)->nullable(false);
            $table->char('iso_639_1', 10)   ->nullable();
            $table->char('iso_639_2T', 10)  ->nullable();
            $table->char('iso_639_2B', 10)  ->nullable();
            $table->char('iso_639_3', 10)   ->nullable();
            $table->char('tag', 10)         ->nullable();
            $table->text('note')                  ->nullable();
            
            $table->foreign('country_id')
                ->references('id')
                ->on('countries')
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
        Schema::dropIfExists('languages');
    }
};
