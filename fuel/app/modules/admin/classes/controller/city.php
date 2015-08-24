<?php
namespace Admin;

class Controller_City extends \Admin\Controller_Admin
{

	public function action_index()
	{
		$data['cities'] = \Model\City::query()->get();
		$this->template->title = "Cities";
		$this->template->content = \View::forge('city/index.twig', $data);

	}

	public function action_create()
	{
		if (\Input::method() == 'POST')
		{
			$val = \Model\City::validate('create');

			if ($val->run())
			{
				$city = \Model\City::forge(array(
					'name' => \Input::post('name'),
					'country_id' => \Input::post('country_id'),
				));

				if ($city and $city->save())
				{
					\Session::set_flash('success', 'Added city #'.$city->id.'.');
					\Response::redirect('admin/city');
				}
				else
				{
					\Session::set_flash('error', 'Could not save city.');
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
			'url' => 'admin/city'
			]
		];

		$data['countries'] = \Model\Country::query()->get();

		$this->template->title = "Cities";
		$this->template->content = \View::forge('city/create.twig', $data);

	}

	public function action_edit($id = null)
	{
		is_null($id) and \Response::redirect('city');

		$city = \Model\City::find($id);

		if (\Input::method() == 'POST')
		{
			$val = \Model\City::validate('edit');

			if ($val->run())
			{
				$city->name = \Input::post('name');
				$city->country_id = \Input::post('country_id');

				if ($city->save())
				{
					\Session::set_flash('success', 'Updated city #'.$id);
					\Response::redirect('admin/city');
				}
				else
				{
					\Session::set_flash('error', 'Could not update the city');
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
			'url' => 'admin/city'
			]
		];
		$data['countries'] = \Model\Country::query()->get();
		$this->template->set_global('city', $city, false);
		$this->template->title = "Cities";
		$this->template->content = \View::forge('city/edit.twig', $data);

	}

	public function action_delete($id = null)
	{
		if ($city = \Model\City::find($id))
		{
			$city->delete();

			\Session::set_flash('success', 'Deleted city #'.$id);
		}

		else
		{
			\Session::set_flash('error', 'Could not delete city #'.$id);
		}

		\Response::redirect('admin/city');

	}

}
