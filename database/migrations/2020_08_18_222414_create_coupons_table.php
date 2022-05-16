<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCouponsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('coupons', function (Blueprint $table) {
      $table->bigIncrements('id');
      $table->timestamps();
      $table->morphs('applicable');
      $table->string('code')->unique();
      $table->float('discount_in_rs');
      $table->timestamp('start_date')->nullable();
      $table->timestamp('end_date')->nullable();
      $table->enum('status', [0, 1])->default(0);
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('coupons');
  }
}
