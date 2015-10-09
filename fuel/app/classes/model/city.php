<?php
namespace Model;

/**
 * Describes a 't_city' table row by using the FuelPHP ORM.
 * The 't_city' table contains all the cities
 *
 * @author ESL
 * @version 1.0
 */
class City extends \Orm\Model
{

	/**
	 * @var strings
	 * The name of the database connection
	 */
	protected static $_connection = 'default';

	/**
	 * @var string
	 * The name of the table. This name is specified because
	 * we do not follow fuelPHP convention for naming database tables
	 */
	protected static $_table_name = 't_city';

	/**
	 * @var array
	 * Describes the structure of the 't_city' table
	 */
	protected static $_properties = [
		'id',
		'name',
		'country_id',
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

	protected static $_conditions = array(
        'order_by' => array('name' => 'asc')
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

	protected static $_has_many = [
		't_job' => [
			'model_to' => '\Model\Job',
			'key_from' => 'id',
			'key_to' => 'place_of_work',
			'cascade_save' => false,
			'cascade_delete' => false
		]
	];

	protected static $_belongs_to = array(
		't_country' => array(
			'model_to' => '\Model\Country',
			'key_from' => 'country_id',
			'key_to' => 'id',
			'cascade_save' => false,
			'cascade_delete' => false
		)
	);

	public static function validate($factory)
	{
		$val = \Validation::forge($factory);
		$val->add_field('name', 'Name', 'required|max_length[255]');
		$val->add_field('country_id', 'Country Id', 'required');

		return $val;
	}

}