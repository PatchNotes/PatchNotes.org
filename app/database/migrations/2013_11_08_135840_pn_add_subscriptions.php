<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class PnAddSubscriptions extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('subscription_levels', function (Blueprint $table) {
			$table->integer('level')->unsigned()->unique();
			$table->string('name');

			$table->timestamps();
		});

		$levels = array(
			10 => "Newsletter",
			50 => "Product Updates",
			100 => "Service Changes"
		);
		foreach ($levels as $level => $name) {
			SubscriptionLevel::create(compact('level', 'name'));
		}


		Schema::create('notification_levels', function (Blueprint $table) {
			$table->integer('level')->unsigned()->unique();
			$table->string('name');

			$table->timestamps();
		});

		$levels = array(
			0 => "Immediate",
			24 => "Daily Digest",
			168 => "Weekly Digest"
		);
		foreach ($levels as $level => $name) {
			NotificationLevel::create(compact('level', 'name'));
		}

		Schema::create('subscriptions', function (Blueprint $table) {
			$table->increments('id');

			$table->integer('user_id')->unsigned();
			$table->integer('project_id')->unsigned()->nullable();
			$table->integer('subscription_level')->unsigned();
			$table->integer('notification_level')->unsigned();

			$table->foreign('user_id')->references('id')->on('users');
			$table->foreign('project_id')->references('id')->on('projects');
			$table->foreign('subscription_level')->references('level')->on('subscription_levels');
			$table->foreign('notification_level')->references('level')->on('notification_levels');

			$table->timestamps();
			$table->softDeletes();
		});

	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::drop('subscription_levels');
		Schema::drop('notification_levels');
		Schema::drop('subscriptions');
	}
}
