<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableInstituteAssignedClassSubjectAddColumnSyllabus extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('institute_assigned_class_subject', function (Blueprint $table) {
            $table->string('syllabus')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('institute_assigned_class_subject', function (Blueprint $table) {
            $table->dropColumn('syllabus');
        });
    }
}
