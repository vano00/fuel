<?php
namespace Admin;

class Controller_Auth extends \Controller_Template
{

	public $template = 'template.twig';

	public function action_index()
		{
		    $data = array();

		    if (\Input::post())
		    {
		        $username = \Input::post('username');
		        $password = \Input::post('password');

		        if (\Auth::login($username,$password))
		        {
		            \Response::redirect('admin');
		        }
		        else
		        {
		            // Oops, no soup for you. Try to login again. Set some values to
		            // repopulate the username field and give some error text back to the view.
		            $data['username']    = $username;
		            $data['login_error'] = 'Wrong username/password combo. Try again';
		        }
		    }

		    // Show the login form.
		    $this->template->title = "Login";
			$this->template->content = \View::forge('login.twig',$data);
		}

		public function action_logout()
		{
		    \Auth::logout();

		    \Response::redirect('/');
		}
}