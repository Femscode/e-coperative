<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangePaymentType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->enum('payment_types',['Repayment','Registration','Monthly Dues','Form'])->default("Registration");
        });
        DB::table('transactions')->update(['payment_types' => DB::raw('payment_type')]);
        Schema::table('transactions', function (Blueprint $table) {
            // Step 4: Drop the original column
            $table->dropColumn('payment_type');
        });
        Schema::table('transactions', function (Blueprint $table) {
            $table->renameColumn('payment_types', 'payment_type');
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
