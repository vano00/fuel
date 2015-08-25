<?php

class Controller_Auth extends \Controller_Base
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

		        	// does the user want to be remembered?
			        if (\Input::post('remember_me'))
			        {
			            // create the remember-me cookie
			            \Auth::remember_me();
			        }
			        else
			        {
			            // delete the remember-me cookie if present
			            \Auth::dont_remember_me();
			        }

		            \Response::redirect_back('/');
		        }
		        else
		        {
		            // Oops, no soup for you. Try to login again. Set some values to
		            // repopulate the username field and give some error text back to the view.
		            $data['username']    = $username;
		            \Session::set_flash('error', 'Wrong username/password combo. Try again');
		        }
		    }

		    // Show the login form.
		    $this->template->title = "Login";
			$this->template->content = \View::forge('auth/login.twig',$data);
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
		            try
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
		        	}
		        	catch(\SimpleUserUpdateException $e)
					{
					    \Session::set_flash('error', 'An account with this email address already exist');
					    \Response::redirect('auth');
					}

					\Session::set_flash('success', 'The account has been successfully created');
					\Response::redirect('/');

		        }
		        else
		        {
		            // repopulate the username field and give some error text back to the view.
		            $data['fullname'] = $user['fullname'];
		            $data['username'] = $user['username'];
		            $data['email'] = $user['email'];

		            \Session::set_flash('error', $val->error());
		        }
		    }

		    $data['actions'] = [
			'back' => [
				'label' => 'Back',
				'url' => 'auth'
				]
			];
		    $this->template->title = "Create an account";
			$this->template->content = \View::forge('user/create.twig', $data);
		}

		public function action_logout()
		{
		    \Auth::logout();
		    
		    // delete the remember-me cookie if present
			\Auth::dont_remember_me();

		    \Response::redirect('/');
		}

		public function action_reset_password()
		{

			if (\Input::post())
		    {

		    	$to = trim(\Input::post('email'));

		    	$user = \DB::select_array(\Config::get('simpleauth.table_columns', array('*')))
    				->where('email', '=', $to)
    				->from(\Config::get('simpleauth.table_name'))
    				->as_object()->execute(\Config::get('simpleauth.db_connection'))->current();

		    	$data['password'] = \Auth::reset_password($user->username);

		    	$val = \Validation::forge();
		    	$val->add_field('email', 'email', 'required|valid_email');

		        if ($val->run())
		        {

		        	// Create an instance
					$email = \Email::forge();

					// Set the from address
					$email->from('jobs@esl.ch', 'Les RHs');

					// Set the to address
					$email->to($to);

					// Set a subject
					$email->subject('New password');

					// And set the body.
					$email->html_body(\View::forge('email/template.twig', $data));

					try
					{
					    $email->send();
					}
					catch(\EmailValidationFailedException $e)
					{
					    // The validation failed
					}
					catch(\EmailSendingFailedException $e)
					{
					    // The driver could not send the email
					}


					\Session::set_flash('success', 'A new password has been sent');
					\Response::redirect('/');

		        }
		        else
		        {
		            // repopulate the email field and give some error text back to the view.
		            $data['email'] = $to;

		            \Session::set_flash('error', $val->error());
		        }
		    }

		    $data['actions'] = [
			'back' => [
				'label' => 'Back',
				'url' => 'auth'
				]
			];
		    $this->template->title = "Reset password";
			$this->template->content = \View::forge('auth/password.twig', $data);
		}
}