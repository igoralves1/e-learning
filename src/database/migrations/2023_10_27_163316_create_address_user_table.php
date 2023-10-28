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
        Schema::create('address_user', function (Blueprint $table) {
            $table->bigInteger('user_id')                ->unsigned()->nullable(false);
            $table->bigInteger('address_id')   ->unsigned()->nullable(false);
                        
            
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
                
                
            $table->foreign('address_id', 'fk_adrrs_usr')
                ->references('id')
                ->on('addresses')
                ->onDelete('cascade');    
                
            $table->primary(['user_id', 'address_id']);
            
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
        Schema::dropIfExists('address_user');
    }
};
