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
		Schema::create('comments', function (Blueprint $table) {
			$table->id();
			$table->bigInteger('announcement_id')->unsigned();
			$table->bigInteger('user_id')->unsigned();
			$table->string('content');
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
		Schema::dropIfExists('comments');
	}
};
