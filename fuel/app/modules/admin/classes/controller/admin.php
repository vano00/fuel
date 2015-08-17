<?php
namespace Admin;

class Controller_Admin extends \Controller_Template
{

	public $template = 'template.twig';

	public function before()
    {
        parent::before(); // Without this line, templating won't work!


        if (\Auth::check())
		{
			# Set user info
			$this->template->set_global('auth', [
				'user' => [
					'screen_name'		 => \Auth::get_screen_name(),
				]
			], false);

		}
		else{
			\Response::redirect('admin/auth');
		}

    }

}