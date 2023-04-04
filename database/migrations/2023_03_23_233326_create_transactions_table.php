<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('mother_name');
            $table->string('father_name');
            $table->string('family_name');
            $table->integer('phone1');
            $table->string('village_number');
            $table->integer('national_identification_number');//الرقم الوطني
            $table->string('front_face_of_identity');
            $table->string('back_face_of_identity');
            $table->string('attached_image')->nullable();
            $table->string('user_image');
            $table->integer('region_id')->unsigned();
            $table->foreign('region_id')->references('id')->on('regions')->onDelete('cascade');
            $table->integer('province_id')->unsigned();
            $table->foreign('province_id')->references('id')->on('provinces')->onDelete('cascade');
            $table->integer('transactiontype_id')->unsigned();
            $table->foreign('transactiontype_id')->references('id')->on('transactiontypes')->onDelete('cascade');
            $table->smallInteger('region_consent')->default(0);
            $table->smallInteger('provinces_consent')->default(0);
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('notes')->nullable()->default('لا يوجد اي ملاحظات') ;
            $table->softDeletes(); 
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
        Schema::dropIfExists('transactions');
    }
};
