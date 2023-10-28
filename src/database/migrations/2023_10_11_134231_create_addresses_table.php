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
        Schema::create('addresses', function (Blueprint $table) {
            $table->bigIncrements('id')->autoIncrement();
            $table->index(['id']);
            
            $table->bigInteger('city_id')           ->unsigned()->nullable(false);
            $table->bigInteger('address_type_id')   ->unsigned()->nullable(false);
            
            $table->char('nb_civic', 50)      ->nullable();
            $table->char('nb_room', 50)       ->nullable();
            $table->char('nb_office', 50)     ->nullable();
            $table->char('name', 50)          ->nullable();
            $table->char('street', 100)       ->nullable();
            $table->char('zip', 20)           ->nullable();
            $table->char('complement', 200)   ->nullable();
            $table->text('description')             ->nullable();
            $table->decimal('lat', 10,8) ->nullable();
            $table->decimal('long', 11,8)->nullable();
            
            $table->foreign('city_id')
                ->references('id')
                ->on('cities')
                ->onDelete('cascade');
            
            $table->foreign('address_type_id')
                ->references('id')
                ->on('address_types')
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
        Schema::dropIfExists('addresses');
    }
};
