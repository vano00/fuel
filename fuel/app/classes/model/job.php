<?php
namespace Model;

/**
 * Describes a 't_job' table row by using the FuelPHP ORM.
 * The 't_job' table contains all the jobs
 *
 * @author ESL
 * @version 1.0
 */
class Job extends \Orm\Model
{

	/**
	 * @var string
	 * The name of the table. This name is specified because
	 * we do not follow fuelPHP convention for naming database tables
	 */
	protected static $_table_name = 't_job';

	/**
	 * @var array
	 * Describes the structure of the 't_map' table
	 */
	protected static $_properties = [
		'id',
		'title',
		'intro',
		'overview',
		'main_tasks',
		'profile',
		'we_offer',
		'place_of_work',
		'start_date',
		'type_of_contract',
		'activity_rate',
		'reference',
		'more_info',
		'open',
		'created_at',
		'updated_at'
	];

	/**
	 * @var array	defined observers
	 */
	protected static $_observers = array(
		'Orm\\Observer_CreatedAt' => array(
			'events' => array('before_insert'),
			'property' => 'created_at',
			'mysql_timestamp' => false,
		),
		'Orm\\Observer_UpdatedAt' => array(
			'events' => array('before_update'),
			'property' => 'updated_at',
			'mysql_timestamp' => false,
		)
	);

	/**
	 * @var array
	 * Defines the name of the Primary Key
	 */
	protected static $_primary_key = ['id'];

	/**
	 * @var array
	 * Describes sql relation who have primary key saved in many other rows
	 * of another table (which belong to this one), has many related objects
	 */
	protected static $_belongs_to = array(
		't_city' => array(
			'model_to' => '\Model\City',
			'key_from' => 'place_of_work',
			'key_to' => 'id',
			'cascade_save' => false,
			'cascade_delete' => false
		),
	);

	protected static $_many_many = array(
	    'users' => array(
	        'key_from' => 'id',
	        'key_through_from' => 'job_id', // column 1 from the table in between, should match a job.id
	        'table_through' => 't_favorite', // both models plural without prefix in alphabetical order
	        'key_through_to' => 'user_id', // column 2 from the table in between, should match a users.id
	        'model_to' => '\Auth\Model\Auth_User',
	        'key_to' => 'id',
	        'cascade_save' => false,
	        'cascade_delete' => false,
	    )
	);

	public static function validate($factory)
	{
		$val = \Validation::forge($factory);
		$val->add_field('title', 'Title', 'required|max_length[255]');
		$val->add_field('intro', 'Intro', 'required');
		$val->add_field('overview', 'Overview', 'required');
		$val->add_field('main_tasks', 'Main Tasks', 'required');
		$val->add_field('profile', 'Profile', 'required');
		$val->add_field('we_offer', 'We Offer', 'required');
		$val->add_field('place_of_work', 'Place Of Work', 'required');
		$val->add_field('start_date', 'Start Date', 'required|max_length[255]');
		$val->add_field('type_of_contract', 'Type Of Contract', 'required|max_length[255]');
		$val->add_field('activity_rate', 'Activity Rate', 'required|max_length[255]');
		$val->add_field('reference', 'Reference', 'max_length[255]');
		$val->add_field('more_info', 'More Info', 'required');
		$val->add_field('open', 'Open', 'required');

		return $val;
	}

}