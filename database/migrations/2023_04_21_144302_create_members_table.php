<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->string('phone');
            $table->string('company_id')->nullable();
            $table->string('address')->nullable();
            $table->string('photo')->nullable();
            $table->date('registered_at')->nullable();
            $table->text('bio')->nullable();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('coop-id')->nullable();
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
        Schema::dropIfExists('members');
    }
}
