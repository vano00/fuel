<?php
namespace Admin;

class Controller_Job extends \Admin\Controller_Admin
{

	public function action_index()
	{
		
		$data['jobs'] = \Model\Job::query()->get();
		$this->template->title = "Jobs";
		$this->template->content = \View::forge('job/index.twig', $data);

	}

	public function action_view($id = null)
	{
		is_null($id) and \Response::redirect('job');

		$data['job'] = \Model\Job::find($id);
		$data['actions'] = [
			'back' => [
				'label' => 'Back',
				'url' => 'admin/job'
			]
		];

		$this->template->title = "Job";
		$this->template->content = \View::forge('job/view.twig', $data);

	}

	public function action_create()
	{
		if (\Input::method() == 'POST')
		{
			$val = \Model\Job::validate('create');

			if ($val->run())
			{
				$job = \Model\Job::forge(array(
					'title' => \Input::post('title'),
					'intro' => \Input::post('intro'),
					'overview' => \Input::post('overview'),
					'main_tasks' => \Input::post('main_tasks'),
					'profile' => \Input::post('profile'),
					'we_offer' => \Input::post('we_offer'),
					'place_of_work' => \Input::post('place_of_work'),
					'start_date' => \Input::post('start_date'),
					'type_of_contract' => \Input::post('type_of_contract'),
					'activity_rate' => \Input::post('activity_rate'),
					'reference' => \Input::post('reference'),
					'more_info' => \Input::post('more_info'),
					'open' => \Input::post('open'),
				));

				if ($job and $job->save())
				{
					\Session::set_flash('success', 'Added job #'.$job->id.'.');
					\Response::redirect('admin/job');
				}
				else
				{
					\Session::set_flash('error', 'Could not save job.');
				}
			}
			else
			{
				\Session::set_flash('error', $val->error());
			}
		}

		$data['actions'] = [
			'back' => [
				'label' => 'Back',
				'url' => 'admin/job'
			]
		];
		$data['cities'] = \Model\City::query()->get();
		$this->template->title = "Jobs";
		$this->template->content = \View::forge('job/create.twig', $data);

	}

	public function action_edit($id = null)
	{
		is_null($id) and \Response::redirect('job');

		$job = \Model\Job::find($id);

		if (\Input::method() == 'POST')
		{
			$val = \Model\Job::validate('edit');

			if ($val->run())
			{
				$job->title = \Input::post('title');
				$job->intro = \Input::post('intro');
				$job->overview = \Input::post('overview');
				$job->main_tasks = \Input::post('main_tasks');
				$job->profile = \Input::post('profile');
				$job->we_offer = \Input::post('we_offer');
				$job->place_of_work = \Input::post('place_of_work');
				$job->start_date = \Input::post('start_date');
				$job->type_of_contract = \Input::post('type_of_contract');
				$job->activity_rate = \Input::post('activity_rate');
				$job->reference = \Input::post('reference');
				$job->more_info = \Input::post('more_info');
				$job->open = \Input::post('open');

				if ($job->save())
				{
					\Session::set_flash('success', 'Updated job #'.$id);
					\Response::redirect('admin/job');
				}
				else
				{
					\Session::set_flash('error', 'Nothing updated.');
				}
			}
			else
			{
				\Session::set_flash('error', $val->error());
			}
		}

		$data['actions'] = [
			'view' => [
				'label' => 'View',
				'url' => 'admin/job/view'
			],
			'back' => [
				'label' => 'Back',
				'url' => 'admin/job'
			]
		];
		$data['cities'] = \Model\City::query()->get();
		$this->template->set_global('job', $job, false);
		$this->template->title = "Jobs";
		$this->template->content = \View::forge('job/edit.twig', $data);

	}

	public function action_delete($id = null)
	{
		if ($job = \Model\Job::find($id))
		{
			$job->delete();

			\Session::set_flash('success', 'Deleted job #'.$id);
		}

		else
		{
			\Session::set_flash('error', 'Could not delete job #'.$id);
		}

		\Response::redirect('admin/job');

	}

}
