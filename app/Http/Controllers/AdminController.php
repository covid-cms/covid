<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        return file_get_contents(public_path('admin/200.html'));
    }
}
