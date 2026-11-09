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
        Schema::create('payments', function (Blueprint $table) {
    $table->id();
    $table->foreignId('tenancy_id')->constrained()->onDelete('cascade');
    $table->decimal('amount', 10, 2);
    $table->string('mpesa_reference')->unique();
    $table->string('month_paid_for');
    $table->enum('status', ['pending', 'confirmed', 'rejected'])->default('pending');
    $table->foreignId('confirmed_by')->nullable()->constrained('users')->nullOnDelete();
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
