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
		Schema::create('user_organisations', function (Blueprint $table) {
			$table->primary(['user_id', 'org_id']);
			$table->bigInteger('user_id')->unsigned();
			$table->bigInteger('org_id')->unsigned();
			$table->enum('role', ["member", "announcer"])->default('member');
			$table->timestamps();

			$table->foreign('user_id')->references('id')->on('users')
				->onDelete('cascade')->onUpdate('cascade');

			$table->foreign('org_id')->references('id')->on('organisations')
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
		Schema::dropIfExists('user_organisations');
	}
};
