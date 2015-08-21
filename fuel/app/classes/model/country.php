<?php
namespace Model;

/**
 * Describes a 't_country' table row by using the FuelPHP ORM.
 * The 't_country' table contains all the countries
 *
 * @author ESL
 * @version 1.0
 */
class Country extends \Orm\Model
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
	protected static $_table_name = 't_country';

	/**
	 * @var array
	 * Describes the structure of the 't_map' table
	 */
	protected static $_properties = [
		'id',
		'name',
		'created_at',
		'updated_at'
	];

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
		't_city' => [
			'model_to' => '\Model\City',
			'key_from' => 'id',
			'key_to' => 'country_id',
			'cascade_save' => true,
			'cascade_delete' => true
		]
	];

	public static function validate($factory)
	{
		$val = \Validation::forge($factory);
		$val->add_field('name', 'Name', 'required|max_length[255]');

		return $val;
	}

}