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
		            $data['message'] = [
		            	'type' => 'danger',
		            	'message' => 'Wrong username/password combo. Try again'
		            	];
		        }
		    }

		    // Show the login form.
		    $this->template->title = "Login";
			$this->template->content = \View::forge('login.twig',$data);
		}

		public function action_create_account()
		{

		    if (\Input::post())
		    {

		    	$user = \Input::post();
		    	$val = \Validation::forge();
		    	$val->add_field('fullname', 'fullname', 'required');
				$val->add_field('username', 'username', 'required');
				$val->add_field('password', 'password', 'required|min_length[3]|max_length[10]');
				$val->add_field('email', 'email', 'required|valid_email');

		        if ($val->run())
		        {
		            \Auth::create_user(
					    $user['username'],
					    $user['password'],
					    $user['email'],
					    1,
					    array(
					        'fullname' => $user['fullname'],
					    )
					);

					$data ['message'] = [
		            	'type' => 'success',
		            	'text' => 'The account has been successfully created'
		            	];
		        }
		        else
		        {
		            // repopulate the username field and give some error text back to the view.
		            $data['fullname'] = $user['fullname'];
		            $data['username'] = $user['username'];
		            $data['email'] = $user['email'];
		            $data['message'] = [
		            	'type' => 'danger',
		            	'text' => $val->error()
		            	];
		        }
		    }

		    // Show the form.
		    $data['actions'] = [
			'back' => [
				'label' => 'Back',
				'url' => 'admin/login'
				]
			];
		    $this->template->title = "Create an account";
			$this->template->content = \View::forge('user/create.twig', $data);
		}

		public function action_logout()
		{
		    \Auth::logout();

		    \Response::redirect('/');
		}
}