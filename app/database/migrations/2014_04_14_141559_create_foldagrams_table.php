<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFoldagramsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create('foldagrams', function(Blueprint $table){
			$table->increments('id');
			$table->text('message');
			$table->string('image', 255);
			$table->boolean('status', array('0', '1'))->default(0);
			$table->integer('user_id');
			
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
        Schema::dropIfExists('foldagrams');
	}

}