<?php

use App\Enums\PaymentMethodEnum;
use App\Enums\PaymentProviderEnum;
use App\Enums\PaymentStatusEnum;
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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->enum('provider', array_column(PaymentProviderEnum::cases(), 'value'));
            $table->enum('status', array_column(PaymentStatusEnum::cases(), 'value'));
            $table->enum('method', array_column(PaymentMethodEnum::cases(), 'value'));
            $table->integer('amount');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
