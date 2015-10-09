<?php
class Controller_Favorite extends Controller_Base
{

	public $template = 'template.twig';

	public function action_index()
	{
		list(, $userid) = \Auth::get_user_id();

		$data['jobs'] = \Model\Job::query()->related('users')->where('users.id', $userid)->get();

		$data['actions'] = [
			'back' => [
				'label' => 'Back',
				'url' => '/'
			]
		];
	
		$this->template->title = "My Favorite jobs";
		$this->template->content = View::forge('job/list.twig', $data);

	}

	public function action_add($id = null)
	{
		if ($id)
		{
			$job = \Model\Job::find($id);
			list(, $userid) = \Auth::get_user_id();

			if ($job and $userid)
			{
				$favorite = \Model\Favorite::find('first', array(
				    'where' => array(
				        array('user_id', $userid),
				        array('job_id', $id)
				        )
				));
				
				if ($favorite)
				{
					$favorite->delete();
					unset($favorite);

					\Session::set_flash('success', 'The job has been removed from your favorites.');
					\Response::redirect('/job/view/'.$job->id.'');
				}

				$props = array('user_id' => $userid, 'job_id' => $id);
				$favorite = new \Model\Favorite($props);

				try 
				{
					$favorite->save();
				} 
				catch (Exception $e) 
				{
					\Session::set_flash('error', 'Job already saved');
					\Response::redirect('/job/view/'.$job->id.'');
				}

				\Session::set_flash('success', 'Job #'.$job->id.' has been added to your favorites.');
				\Response::redirect('/job/view/'.$job->id.'');
			}
			else if ($job == null)
			{
				\Session::set_flash('error', 'This job doesn\'t exist.');
				\Response::redirect('/');
			}
			else if ($userid == null)
			{
				\Session::set_flash('error', 'You must be logged in in order to add a job to your favorite');
				\Response::redirect('/');
			}
		}
		else
		{
			\Response::redirect('/');
		}
	}

}