<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TransactionTableGivingIssues extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('transactions', function (Blueprint $table) {
            Schema::table('transactions', function (Blueprint $table) {
                $table->enum('payment_type',['Repayment','Registration','Monthly Dues','Form'])->default("Registration");
            });
            DB::table('transactions')->update(['payment_type' => DB::raw('payment_types')]);
            Schema::table('transactions', function (Blueprint $table) {
                // Step 4: Drop the original column
                $table->dropColumn('payment_types');
            });
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('transactions', function (Blueprint $table) {
            //
        });
    }
}
