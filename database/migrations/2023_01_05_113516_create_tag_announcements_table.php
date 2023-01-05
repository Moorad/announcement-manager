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
		Schema::create('tag_announcements', function (Blueprint $table) {
			$table->primary(['tag_id', 'announcement_id']);
			$table->bigInteger('tag_id')->unsigned();
			$table->bigInteger('announcement_id')->unsigned();
			$table->timestamps();

			$table->foreign('tag_id')->references('id')->on('tags')
				->onDelete('cascade')->onUpdate('cascade');

			$table->foreign('announcement_id')->references('id')->on('announcements')
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
		Schema::dropIfExists('tag_announcements');
	}
};
