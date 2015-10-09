<?php
class Controller_Job extends Controller_Base
{
	public $template = 'template.twig';

	public function action_view($id = null)
	{
		is_null($id) and Response::redirect('job');

		$data['job'] = \Model\Job::find($id);
		$data['actions'] = [
			'back' => [
				'label' => 'Back',
				'url' => '/'
			]
		];

		if (\Auth::check())
		{

			list(, $userid) = \Auth::get_user_id();

			// check if the job has been saved by the current user
			$data['favorite'] = \Model\Favorite::find('all', array(
			    'where' => array(
			        array('user_id', $userid),
			        array('job_id', $id)
			        )
			));
		}

		$this->template->title = "Jobs";
		$this->template->content = View::forge('job/_details.twig', $data);

	}

}