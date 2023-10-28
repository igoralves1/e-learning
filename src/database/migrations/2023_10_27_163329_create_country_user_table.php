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
        Schema::create('country_user', function (Blueprint $table) {
            $table->bigInteger('user_id')->unsigned()->nullable(false);
            $table->bigInteger('country_id')->unsigned()->nullable(false);
                        
            
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
                
                
            $table->foreign('country_id', 'fk_country_usr')
                ->references('id')
                ->on('countries')
                ->onDelete('cascade');    
                
            $table->primary(['user_id', 'country_id']);
            
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
        Schema::dropIfExists('country_user');
    }
};
