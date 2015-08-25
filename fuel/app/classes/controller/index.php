<?php
class Controller_Index extends Controller_Base
{

	public $template = 'template.twig';

	public function action_index()
	{
		$data['jobs'] = \Model\Job::query()->get();
		$this->template->title = "Jobs listing";
		$this->template->content = View::forge('index.twig', $data);

	}

}