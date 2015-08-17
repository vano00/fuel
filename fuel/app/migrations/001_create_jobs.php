<?php

namespace Fuel\Migrations;

class Create_jobs
{
	public function up()
	{
		\DBUtil::create_table('jobs', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true, 'unsigned' => true),
			'title' => array('constraint' => 255, 'type' => 'varchar'),
			'intro' => array('type' => 'text'),
			'overview' => array('type' => 'text'),
			'main_tasks' => array('type' => 'text'),
			'profile' => array('type' => 'text'),
			'we_offer' => array('type' => 'text'),
			'place_of_work' => array('constraint' => 255, 'type' => 'varchar'),
			'start_date' => array('constraint' => 255, 'type' => 'varchar'),
			'type_of_contract' => array('constraint' => 255, 'type' => 'varchar'),
			'activity_rate' => array('constraint' => 255, 'type' => 'varchar'),
			'reference' => array('constraint' => 255, 'type' => 'varchar'),
			'more_info' => array('type' => 'text'),
			'open' => array('type' => 'bool'),
			'created_at' => array('constraint' => 11, 'type' => 'int', 'null' => true),
			'updated_at' => array('constraint' => 11, 'type' => 'int', 'null' => true),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('jobs');
	}
}