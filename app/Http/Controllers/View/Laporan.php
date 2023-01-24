<?php

namespace App\Http\Controllers\View;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Laporan extends Controller
{
    public function show_laporan()
    {
        return view('admin.laporan');
    }
}
