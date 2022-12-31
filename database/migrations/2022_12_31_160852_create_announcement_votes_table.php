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
		Schema::create('announcement_votes', function (Blueprint $table) {
			$table->primary(['announcement_id', 'user_id']);
			$table->bigInteger('announcement_id')->unsigned();
			$table->bigInteger('user_id')->unsigned();

			// This should be 1 or -1 for upvote or and downvote respectively
			$table->integer('vote_val');
			$table->timestamps();

			$table->foreign('announcement_id')->references('id')->on('announcements')
				->onDelete('cascade')->onUpdate('cascade');

			$table->foreign('user_id')->references('id')->on('users')
				->onDelete('cascade')->onUpdate('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('announcement_votes');
	}
};
