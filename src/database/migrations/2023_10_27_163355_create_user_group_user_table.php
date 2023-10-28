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
        Schema::create('user_group_user', function (Blueprint $table) {
            $table->bigInteger('user_id')->unsigned()->nullable(false);
            $table->bigInteger('user_group_id')->unsigned()->nullable(false);
            
            
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
            
            $table->foreign('user_group_id','usr_grp_usr')
                ->references('id')
                ->on('user_groups')
                ->onDelete('cascade');
                
            $table->primary(['user_id', 'user_group_id']);
            
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
        Schema::dropIfExists('user_group_user');
    }
};
