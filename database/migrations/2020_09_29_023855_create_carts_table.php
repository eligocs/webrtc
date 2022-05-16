<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCartsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('carts', function (Blueprint $table) {
      $table->bigIncrements('id');
      $table->timestamps();
      $table->integer('institute_assigned_class_id');
      $table->foreign('institute_assigned_class_id')->references('id')->on('institute_assigned_class');
      $table->unsignedBigInteger('student_id');
      $table->foreign('student_id')->references('id')->on('students');
      $table->enum('coupon_applied', [0, 1])->default(0);
      $table->unsignedBigInteger('coupon_id')->nullable();
      $table->foreign('coupon_id')->references('id')->on('coupons');
      $table->longText('form_data')->nullable();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('carts');
  }
}
