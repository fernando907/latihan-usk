<?php

namespace App\Http\Controllers\View;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use App\Models\User;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\PDF;

class Laporan extends Controller
{
    public function laporan_peminjaman()
    {
        $peminjamans = Peminjaman::where('done', 0)->get();

        return view('admin.laporan_peminjaman', compact('peminjamans'));
    }
    public function laporan_pengembalian()
    {
        $pengembalians = Peminjaman::where('done', 1)->get();
        // dd($pengembalians);

        return view('admin.laporan_pengembalian', compact('pengembalians'));
    }
    // public function show_laporan_anggota()
    // {
    //     return view('admin.laporan_anggota');
    // }
    public function laporan_anggota()
    {
        $datas = Peminjaman::get();
        $anggotas = User::where('role', 'user')->get();

        return view('admin.laporan_anggota', compact('datas', 'anggotas'));
    }

    public function peminjaman_pdf()
    {
        $peminjamans = Peminjaman::where('done', 1)->get();

        $pdf = PDF::loadview('admin.laporan_peminjaman', ['peminjamans' => $peminjamans]);
        return $pdf->download('laporan-peminjaman-pdf');
    }
    public function pengembalian_pdf()
    {
        $pengembalians = Peminjaman::where('done', 1)->get();
        // dd($pengembalians);

        $pdf = PDF::loadview('admin.laporan_pengembalian', ['pengembalians' => $pengembalians]);
        return $pdf->download('laporan-pengembalian-pdf');
    }
    public function anggota_pdf()
    {
        $datas = Peminjaman::where('user_id', 1)->get();
        dd($datas);

        $pdf = PDF::loadview('admin.pdf_anggota', ['datas' => $datas]);
        return $pdf->download('laporan-pengembalian-pdf');
    }
}
