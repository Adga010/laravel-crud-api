<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(table: 'student', callback: function (Blueprint $table) {
            $table->uuid('id')->primary(); // Define el id como UUID
            $table->string(column: 'name');
            $table->string(column: 'email')->unique();
            $table->integer(column: 'phone');
            $table->integer(column: 'age');
            $table->string(column: 'language');
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
        Schema::dropIfExists('student');
    }
};
