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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('project_name')->index();
            $table->string('support_email')->nullable();
            $table->string('tawk_to')->nullable();
            $table->string('presale_contract_address')->nullable();
            $table->boolean('is_min_max_active')->default(0);
            $table->decimal('min_purchase_amount')->nullable();
            $table->decimal('max_purchase_amount')->nullable();
            $table->integer('token_decimals')->nullable();
            $table->string('token_contract_address')->nullable();
            $table->string('logo')->nullable();
            $table->dateTime('presale_start_date')->nullable();
            $table->dateTime('presale_end_date')->nullable();
            $table->boolean('token_locking')->default(0);
            $table->longText('description')->nullable();
            $table->boolean('sale_active')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('settings');
    }
};
