<?php
class Controller_Job extends Controller_Template
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

		$this->template->title = "Jobs";
		$this->template->content = View::forge('job/_details.twig', $data);

	}

}
