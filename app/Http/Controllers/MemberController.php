<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MemberController extends Controller
{
    // Return view
    public function index()
    {
        return view('welcome');
    }
}
