<?php
class Controller_Index extends Controller_Template
{

	public $template = 'template.twig';

	public function action_index()
	{
		$data['jobs'] = Model_Job::find_all();
		$this->template->title = "Jobs listing";
		$this->template->content = View::forge('index.twig', $data);

	}

}