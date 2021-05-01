<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Task;

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
            $table->unsignedBigInteger('status_id');
            $table->unsignedBigInteger('priority_id');
            $table->unsignedBigInteger('project_id')->nullable();
            $table->unsignedBigInteger('reporter_id');
            $table->unsignedBigInteger('assignee_id');
            $table->timestamps();
        });

        Schema::table('tasks', function (Blueprint $table){
            $table->foreign('status_id')
            ->references('id')->on('task_statuses')->onDelete('cascade');
            $table->foreign('priority_id')
            ->references('id')->on('task_priorities')->onDelete('cascade');
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
            $table->dropForeign(['status_id']);
            $table->dropForeign(['priority_id']);
            $table->dropForeign(['project_id']);
            $table->dropForeign(['reporter_id']);
            $table->dropForeign(['assignee_id']);
            $table->dropColumn('status_id');
            $table->dropColumn('priority_id');
            $table->dropColumn('project_id');
            $table->dropColumn('reporter_id');
            $table->dropColumn('assignee_id');
        });

        Schema::dropIfExists('tasks');
    }
}
