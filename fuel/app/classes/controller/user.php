<?php
class Controller_User extends Controller_Base
{

	public $template = 'template.twig';

	public function action_index()
	{
		$data['actions'] = [
			'back' => [
				'label' => 'Back',
				'url' => '/'
			]
		];
		$data['user'] = [
			'details' => \Auth::get_profile_fields(),
			'email' => \Auth::get_email()
		];
	
		$this->template->title = "Profile";
		$this->template->content = View::forge('user/view.twig', $data);

	}

	public function action_edit()
	{
		$data['user'] = \Auth::get_profile_fields();
		$data['user']['email'] = \Auth::get_email();

		if (\Input::post())
	    {

	    	$user = \Input::post();
	    	$val = \Validation::forge();
	    	$val->add_field('fullname', 'fullname', 'required');
			if (\Input::post('password'))
			{
				$val->add_field('password', 'new password', 'required|min_length[3]|max_length[10]');
				$val->add_field('old_password', 'old password', 'required|min_length[3]|max_length[10]');
			}
			$val->add_field('email', 'email', 'required|valid_email');

	        if ($val->run())
	        {
	        	if ($user['password'] === '')
	            {
            		\Auth::update_user(
					    array(
					        'email'        => $user['email'],  // set a new email address
					        'fullname'        => $user['fullname']  // and add the phone fullname to the metadata
					    )
					);
            	} 
            	else 
            	{
		            \Auth::update_user(
					    array(
					        'email'        => $user['email'],  // set a new email address
					        'password'     => $user['password'],    // set a new password
					        'old_password' => $user['old_password'], // to do so, give the current one!
					        'fullname'        => $user['fullname'],	    // and add the phone fullname to the metadata
					    )
					);
				}

				\Session::set_flash('success', 'The profile has been successfully updated');
				\Response::redirect('/user');

	        }
	        else
	        {
	            // repopulate the username field and give some error text back to the view.
	            $data['user'] = [
						'fullname' => $user['fullname'],
						'email' => $user['email'],
						'password' => $user['password'],
						'old_password' => $user['old_password']
					];

	            \Session::set_flash('error', $val->error());
	        }
	    }

		$data['actions'] = [
			'back' => [
				'label' => 'Back',
				'url' => '/user'
			]
		];

		$this->template->title = "Edit profile";
		$this->template->content = View::forge('user/edit.twig', $data);

	}

}