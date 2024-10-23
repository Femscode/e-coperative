<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFewColumnsToCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->string('mode')->nullable();
            $table->decimal('reg_fee',18,2)->default(0);
            $table->decimal('dues',18,2)->default(0);
            $table->decimal('loan_form_amount',18,2)->default(0);
            $table->decimal('default_charge',18,2)->default(0);
            $table->string('month')->nullable();
            $table->string('min_loan_range')->nullable();
            $table->string('max_loan_range')->nullable();
            $table->string('loan_month_repayment')->nullable();
            $table->text('note')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('companies', function (Blueprint $table) {
            //
        });
    }
}
