<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Helper;

class Home extends Controller
{
    public function index()
    {
		return view('welcome');
    }
}
