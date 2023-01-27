<?php

namespace App\Http\Controllers\View;

use App\Http\Controllers\Controller;
use App\Models\Pemberitahuan as ModelsPemberitahuan;
use Illuminate\Http\Request;

class Pemberitahuan extends Controller
{
    public function pemberitahuan_user(){
        $pemberitahuans = ModelsPemberitahuan::where('status', 'aktif')->orWhere('status', 'user')->get();

        return view('user.pemberitahuan', compact('pemberitahuans'));
    }
    public function pemberitahuan_admin(){
        $pemberitahuans = ModelsPemberitahuan::where('status', 'aktif')->orWhere('status', 'admin')->get();

        return view('admin.pemberitahuan', compact('pemberitahuans'));
    }
}
