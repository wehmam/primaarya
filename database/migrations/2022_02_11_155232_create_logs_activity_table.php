<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogsActivityTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('log_activity', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger("case_id")->nullable();
            $table->string("title");
            $table->string("type");
            $table->string("email");
            $table->string("activity");
            $table->string("ip_address");
            $table->text("location");
            $table->string("custom_logs")->default("");
            $table->timestamps();
        });

        Schema::create("cases", function (Blueprint $table) {
            $table->id();
            $table->string("session");
            $table->string("case_name");
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
        Schema::dropIfExists('log_activity');
        Schema::dropIfExists('cases');
    }
}
