<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMemberLoansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('member_loans', function (Blueprint $table) {
            $table->id();
            $table->string('user_id');
            $table->string('plan_id');
            $table->date('applied_date');
            $table->decimal('total_applied',18,2);
            $table->decimal('monthly_return',18,2);
            $table->decimal('total_refund',18,2)->default(0);
            $table->decimal('total_left',18,2);
            $table->enum('status',['Awaiting','Ongoing','Completed'])->default("Awaiting");
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
        Schema::dropIfExists('member_loans');
    }
}
