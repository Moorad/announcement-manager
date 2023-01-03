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
		Schema::create('votes', function (Blueprint $table) {
			$table->id();
			$table->morphs('votable');
			$table->bigInteger('user_id')->unsigned();

			// This should be 1 or -1 for upvote or and downvote respectively
			$table->integer('vote_val');
			$table->timestamps();
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
