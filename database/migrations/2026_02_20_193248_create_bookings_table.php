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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained()->onDelete('cascade');
            $table->foreignId('hall_id')->constrained()->onDelete('cascade');
            $table->date('event_date');// تاريخ المناسبة 
            $table->decimal('total_price', 10,2);//اجمالي العقد
            $table->decimal('paid_amount', 10,2)->default(0);// المدفوع
            $table->decimal('remaining_amount', 10,2)->default(0);// المتبقي
            $table->enum('status', ['منتهي','مؤكد', 'ملغي', 'عربون'] )->default('عربون');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
