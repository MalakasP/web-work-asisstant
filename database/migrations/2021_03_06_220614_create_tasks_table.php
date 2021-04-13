<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('description')->nullable();
            $table->date('date_till_done');
            $table->string('status');
            $table->string('priority');
            $table->unsignedBigInteger('project_id')->nullable();
            $table->unsignedBigInteger('reporter_id');
            $table->unsignedBigInteger('assignee_id');
            $table->timestamps();
        });

        Schema::table('tasks', function (Blueprint $table){
            $table->foreign('project_id')
                ->references('id')->on('projects')->onDelete('cascade');
            $table->foreign('reporter_id')
                ->references('id')->on('users')->onDelete('cascade');
            $table->foreign('assignee_id')
                ->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->dropForeign(['project_id']);
            $table->dropForeign(['reporter_id']);
            $table->dropForeign(['assignee_id']);
            $table->dropColumn('project_id');
            $table->dropColumn('reporter_id');
            $table->dropColumn('assignee_id');
        });

        Schema::dropIfExists('tasks');
    }
}
