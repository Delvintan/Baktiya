<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('sales_request_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sales_request_id')->constrained()->cascadeOnDelete();
            $table->string('item_name');
            $table->text('description')->nullable();
            $table->integer('qty');
            $table->string('unit')->default('pcs');
            $table->decimal('est_price', 15, 2)->default(0);
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('sales_request_items'); }
};
