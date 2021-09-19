<?php

namespace App\Controllers;

use App\Models\DishModel;
use App\Controllers\BaseController;

class HomeController extends BaseController
{
	public function index()
	{
		return view('login');
	}

	public function speech()
	{
		return view('app');
	}
}
