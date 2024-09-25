<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('cart_items', function (Blueprint $table) {
            $table->decimal('total', 10, 2)->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('cart_items', function (Blueprint $table) {
            $table->dropColumn('total');
        });
    }
    
};
