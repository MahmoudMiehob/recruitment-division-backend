<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('userinformations', function (Blueprint $table) {
            $table->increments('id');
            $table->string('mother_name');
            $table->string('father_name');
            $table->string('family_name');
            $table->integer('phone1');
            $table->integer('phone2')->nullable();
            $table->integer('village_number');
            $table->integer('enlistment_statue_id')->unsigned();
            $table->foreign('enlistment_statue_id')->references('id')->on('enlistment_statues')->onDelete('cascade');
            $table->integer('region_id')->unsigned();
            $table->foreign('region_id')->references('id')->on('regions')->onDelete('cascade');
            $table->integer('national_identification_number');//الرقم الوطني
            $table->string('image');
            $table->integer('user_id')->unsigned()->uniqid();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->default(DB::raw('NULL ON UPDATE CURRENT_TIMESTAMP'))->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('userinformations');
    }
};
