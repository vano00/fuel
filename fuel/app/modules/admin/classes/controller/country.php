<?php
namespace Admin;

class Controller_Country extends \Admin\Controller_Admin
{

	public function action_index()
	{
		$data['countries'] = \Model\Country::query()->get();
		$this->template->title = "Countries";
		$this->template->content = \View::forge('country/index.twig', $data);

	}

	public function action_create()
	{
		if (\Input::method() == 'POST')
		{
			$val = \Model\Country::validate('create');

			if ($val->run())
			{
				$country = \Model\Country::forge(array(
					'name' => \Input::post('name'),
				));

				if ($country and $country->save())
				{
					\Session::set_flash('success', 'Added country #'.$country->id.'.');
					\Response::redirect('admin/country');
				}
				else
				{
					\Session::set_flash('error', 'Could not save the country');
				}
			}
			else
			{
				\Session::set_flash('error', $val->error());
			}
		}
		// Show the form.
	    $data['actions'] = [
		'back' => [
			'label' => 'Back',
			'url' => 'admin/country'
			]
		];
		$this->template->title = "Countries";
		$this->template->content = \View::forge('country/create.twig', $data);

	}

	public function action_edit($id = null)
	{
		is_null($id) and \Response::redirect('admin/country');

		$country = \Model\Country::find($id);

		if (\Input::method() == 'POST')
		{
			$val = \Model\Country::validate('edit');

			if ($val->run())
			{
				$country->name = \Input::post('name');

				if ($country->save())
				{
					\Session::set_flash('success', 'Updated country #'.$id);
					\Response::redirect('admin/country');
				}
				else
				{
					\Session::set_flash('error', 'Could not update the country');
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
			'url' => 'admin/country'
			]
		];
		$this->template->set_global('country', $country, false);
		$this->template->title = "Countries";
		$this->template->content = \View::forge('country/edit.twig', $data);

	}

	public function action_delete($id = null)
	{
		if ($country = \Model\Country::find($id))
		{
			$country->delete();

			\Session::set_flash('success', 'Deleted country #'.$id);
		}

		else
		{
			\Session::set_flash('error', 'Could not delete country #'.$id);
		}

		\Response::redirect('admin/country');

	}

}
