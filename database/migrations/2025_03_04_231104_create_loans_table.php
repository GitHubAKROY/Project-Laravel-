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
        Schema::create('loans', function (Blueprint $table) {
            $table->id();
            $table->string('loan_id', 30)->nullable();
			$table->bigInteger('loan_product_id')->unsigned();
			$table->bigInteger('borrower_id')->unsigned();
            $table->unsignedBigInteger('debit_account_id')->nullable();
			$table->date('first_payment_date');
			$table->date('release_date')->nullable();
			$table->bigInteger('currency_id');
			$table->decimal('applied_amount', 10, 2);
			$table->decimal('total_payable', 10, 2)->nullable();
			$table->decimal('total_paid', 10, 2)->nullable();
			$table->decimal('late_payment_penalties', 10, 2);
			$table->text('attachment')->nullable();
			$table->text('description')->nullable();
			$table->text('remarks')->nullable();
			$table->integer('status')->default(0);
            $table->string('disburse_method')->default('cash');
			$table->date('approved_date')->nullable();
			$table->bigInteger('approved_user_id')->nullable();
			$table->bigInteger('created_user_id')->nullable();
			$table->bigInteger('updated_user_id')->nullable();
			$table->bigInteger('branch_id')->nullable();
            $table->text('custom_fields')->nullable();
            $table->foreignId('tenant_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loans');
    }
};
