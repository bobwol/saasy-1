<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTenantTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tenants', function($table)
		{
		    $table->increments('id');
		    $table->softDeletes();
		    $table->timestamps();
		    $table->string('version', 		100);
		    $table->string('name', 			255);
		    $table->string('database_host', 100);
		    $table->string('database_name', 100);
		    $table->string('database_user', 100);
		    $table->string('database_pass', 100);
		    $table->enum('status', 			array(
										    	'active',
										    	'suspended-billing',
										    	'suspended-other',
										    	'trial-end'
										    )
		    );
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		//
		Schema::drop('tenants');
	}

}
