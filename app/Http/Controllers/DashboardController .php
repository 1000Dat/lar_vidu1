<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        // Your logic here
        return view('admin.dashboard');
    }
}
