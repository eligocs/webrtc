<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableInstituteAssignedClassStudentAddColumnCouponIdForeingKey extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('institute_assigned_class_student', function (Blueprint $table) {
      $table->enum('coupon_applied', [0, 1])->default(0);
      $table->unsignedBigInteger('coupon_id')->nullable();
      $table->foreign('coupon_id')->references('id')->on('coupons');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::table('institute_assigned_class_student', function (Blueprint $table) {
      $table->dropColumn('coupon_applied');
      $table->dropForeign(['coupon_id']);
    });
  }
}
