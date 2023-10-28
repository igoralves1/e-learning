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
        Schema::create('faxes', function (Blueprint $table) {
            $table->bigIncrements('id')->autoIncrement();
            $table->index(['id']);
            
            $table->bigInteger('address_id')->unsigned()->nullable(false);
            
            $table->char('number', 20)->nullable(false);
            $table->text('note')->nullable();
            
            $table->foreign('address_id')
                ->references('id')
                ->on('addresses')
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
        Schema::dropIfExists('faxes');
    }
};
