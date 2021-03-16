<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('description');
            $table->unsignedBigInteger('author_id');
            $table->unsignedBigInteger('team_id')->nullable();
            $table->timestamps();
        });

        Schema::table('projects', function (Blueprint $table){
            $table->foreign('author_id')
                ->references('id')->on('users')->onDelete('cascade');
            $table->foreign('team_id')
                ->references('id')->on('teams')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropForeign(['author_id']);
            $table->dropForeign(['team_id']);
            $table->dropColumn('author_id');
            $table->dropColumn('team_id');
        });

        Schema::dropIfExists('projects');
    }
}
