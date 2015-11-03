<?php

namespace Scienceguard\SglvCore\Controllers;

use Controller;
use View;
use Auth;

use Scienceguard\SG_Util;

class BaseController extends Controller {

	public $template = 'sglv-core::template_route';
	public $user;
	public $user_id;

	public function __construct()
	{
		$user = \CurrentUser::getUser();

		$this->user = $user;
		$this->user_id = SG_Util::val($user, 'id', 0);
	}

	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */
	protected function setupLayout()
	{
		if ( ! is_null($this->layout))
		{
			$this->layout = View::make($this->layout);
		}
	}

}
