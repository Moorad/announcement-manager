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
		Schema::create('announcements', function (Blueprint $table) {
			$table->id();
			$table->bigInteger('user_id')->unsigned();
			$table->bigInteger('org_id')->unsigned();
			$table->string('title');
			$table->string('text');
			$table->string('attached_image')->nullable();
			$table->bigInteger('last_edited_by')->unsigned()->nullable();
			$table->timestamps();

			$table->foreign('user_id')->references('id')->on('users')
				->onDelete('cascade')->onUpdate('cascade');

			$table->foreign('org_id')->references('id')->on('organisations')
				->onDelete('cascade')->onUpdate('cascade');

			$table->foreign('last_edited_by')->references('id')->on('users')
				->onDelete('set null')->onUpdate('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('announcements');
	}
};
