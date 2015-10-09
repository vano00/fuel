<?php
namespace Model;

/**
 * Describes a 'users' table row by using the FuelPHP ORM.
 * The 'users' table contains all the users
 *
 * @author ESL
 * @version 1.0
 */
class User extends \Auth\Model\Auth_User
{
	protected static $_many_many = array(
	    't_job' => array(
	        'key_from' => 'id',
	        'key_through_from' => 'user_id', // column 1 from the table in between, should match a user.id
	        'table_through' => 't_favorite', // both models plural without prefix in alphabetical order
	        'key_through_to' => 'job_id', // column 2 from the table in between, should match a job.id
	        'model_to' => '\Model\job',
	        'key_to' => 'id',
	    )
	);
}