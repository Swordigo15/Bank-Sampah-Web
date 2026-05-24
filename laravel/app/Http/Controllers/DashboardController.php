<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function input()
    {
        return view('input');
    }

    public function index()
    {
        return view('admin.dashboard');
    }

    public function rekap()
    {
        return view('admin.rekap');
    }

    public function export($jenis)
    {
        // Implementation for export functionality
    }
}
