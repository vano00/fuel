<?php
class Model_Job extends Model_Crud
{
	protected static $_table_name = 'jobs';
	
	public static function validate($factory)
	{
		$val = Validation::forge($factory);
		$val->add_field('title', 'Title', 'required|max_length[255]');
		$val->add_field('intro', 'Intro', 'required');
		$val->add_field('overview', 'Overview', 'required');
		$val->add_field('main_tasks', 'Main Tasks', 'required');
		$val->add_field('profile', 'Profile', 'required');
		$val->add_field('we_offer', 'We Offer', 'required');
		$val->add_field('place_of_work', 'Place Of Work', 'required|max_length[255]');
		$val->add_field('start_date', 'Start Date', 'required|max_length[255]');
		$val->add_field('type_of_contract', 'Type Of Contract', 'required|max_length[255]');
		$val->add_field('activity_rate', 'Activity Rate', 'required|max_length[255]');
		$val->add_field('reference', 'Reference', 'required|max_length[255]');
		$val->add_field('more_info', 'More Info', 'required');
		$val->add_field('open', 'Open', 'required');

		return $val;
	}

}
