<?php
namespace Model;

/**
 * Describes a 't_favorite' table row by using the FuelPHP ORM.
 * The 't_favorite' table contains all the favorite jobs saved by the users
 *
 * @author ESL
 * @version 1.0
 */
class Favorite extends \Orm\Model
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
	protected static $_table_name = 't_favorite';

	/**
	 * @var array
	 * Describes the structure of the 't_city' table
	 */
	protected static $_properties = [
		'favorite_id',
		'job_id',
		'user_id',
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
	protected static $_primary_key = ['favorite_id'];

}