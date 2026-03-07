<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('sales_requests', function (Blueprint $table) {
            $table->id();
            $table->string('request_no')->unique();
            $table->string('customer_name');
            $table->text('notes')->nullable();
            $table->enum('status', ['submitted','approved','cancelled'])->default('submitted');
            $table->foreignId('created_by')->constrained('users');
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('sales_requests'); }
};
