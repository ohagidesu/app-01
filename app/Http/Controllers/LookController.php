<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use Illuminate\Http\LookRequest;

class LookController extends Controller
{
    public function index()
    {
       $admins = Admin::all();
        return view('looks.index', compact('admins'));
    }
}
