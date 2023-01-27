<?php

namespace App\Http\Controllers\View;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\Pemberitahuan;
use App\Models\Peminjaman;
use App\Models\User;
use Illuminate\Http\Request;

class Dashboard extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function admin()
    {
        $anggota = User::where('role', 'user')->get();
        $buku = Buku::get();
        $peminjaman = Peminjaman::where('done', false)->get();
        $pengembalian = Peminjaman::where('done', true)->get();
        $pemberitahuans = Pemberitahuan::where('status' , 'aktif')->orWhere('status' , 'admin')->get();

        return view('admin.dashboard', compact('anggota', 'buku', 'peminjaman', 'pengembalian', 'pemberitahuans'));
    }
    public function user()
    {
        $pemberitahuans = Pemberitahuan::where('status' , 'aktif')->orWhere('status' , 'user')->get();
        $bukus = Buku::all();

        // dd($pemberitahuans);
        return view('user.dashboard', compact('pemberitahuans', 'bukus'));
    }

    public function nonactive_notif(Request $request)
    {
        $status = Pemberitahuan::where('id', $request->id)->first();
        $status->update([
            'status' => 'nonaktif'
        ]);
        return redirect()->back();
    }
}