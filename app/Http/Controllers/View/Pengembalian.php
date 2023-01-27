<?php

namespace App\Http\Controllers\View;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Pengembalian extends Controller
{
    public function show_pengembalian()
    {
        $datas = Peminjaman::where('user_id', Auth::user()->id)->where('done', true)->get();

        return view('user.pengembalian', compact('datas'));
    }

    public function pengembalian_form()
    {
        $buku = Peminjaman::where('user_id', Auth::user()->id)->whereNotNull('tanggal_peminjaman')->where('done', false)->with('buku')->get();

        // dd($buku);
        return view('user.form_pengembalian', compact('buku'));
    }

    public function submit_pengembalian(Request $request)
    {
        $request->validate([
            'kondisi_buku_saat_dikembalikan' => 'required',
            'buku_id' => 'required',
            'tanggal_pengembalian' => 'required'
        ]);

        $cek = Peminjaman::where('user_id', Auth::user()->id)
            ->where('buku_id', $request->buku_id)
            ->where('done', false)
            ->first();

        $cek->update([
            'tanggal_pengembalian'  => $request->tanggal_pengembalian,
            'kondisi_buku_saat_dikembalikan' => $request->kondisi_buku_saat_dikembalikan,
            'done' => true
        ]);

        if ($request->kondisi_buku_saat_dikembalikan == 'baik' && $cek->kondisi_buku_saat_dipinjam == "baik" && $cek->denda == null) {
            $buku = Buku::where('id', $request->buku_id)->first();

            $buku->update([
                'j_buku_baik' => $buku->j_buku_baik + 1
            ]);

            $cek->update([
                'denda' => null
            ]);
        }

        if ($request->kondisi_buku_saat_dikembalikan == 'buruk' && $cek->kondisi_buku_saat_dipinjam == 'baik') {
            $buku = Buku::where('id', $request->buku_id)->first();

            $buku->update([
                'j_buku_buruk' => $buku->j_buku_buruk + 1

            ]);

            $cek->update([
                'denda' => 25000
            ]);
        }

        if ($request->kondisi_buku_saat_dikembalikan == 'buruk' && $cek->kondisi_buku_saat_dipinjam == 'buruk') {
            $buku = Buku::where('id', $request->buku_id)->first();

            $buku->update([
                'j_buku_rusak' => $buku->j_buku_rusak + 1
            ]);

            $cek->update([
                'denda' => null
            ]);
        }

        if ($request->kondisi_buku_saat_dikembalikan == 'hilang') {

            $cek->update([
                'denda' => 50000
            ]);
        }

        if (!$cek) {
            return redirect()->back()->with('status_pengembalian', 'danger')->with('message', "Gagal Mengembalikan buku");
        }
        return redirect()->route('user.pengembalian')->with('status_pengembalian', 'success')->with('message', 'Berhasil Mengembalikan Buku');
    }

    // public function submit_pengembalian(Request $request)
    // {
    //     // $y_return = explode("-", $tanggal_peminjaman)[0];
    //     // $m_return = explode("-", $tanggal_peminjaman)[1];
    //     // $tanggal_pengembalian = "$y_return" . "-" . "$m_return" . "-" . "$d_return";
    //     // $buku_id = $request->buku_id;

    //     $pengembalian = Peminjaman::where(['user_id' => Auth::user()->id, 'buku_id' => $request->buku_id])->first();
    //     $jadwal_pengembalian = $pengembalian->tanggal_pengembalian;
    //     $d_return = explode("-", $jadwal_pengembalian)[2];
    //     $tanggal_pengembalian = $request->tanggal_pengembalian;
    //     $returned = explode("-", $tanggal_pengembalian)[2];


    //     // Function update data
    //     function terlambat_rusak($date, $denda, $pengembalian, $request)
    //     {
    //         $update = $pengembalian->update([
    //             "tanggal_pengembalian" => $request->tanggal_pengembalian,
    //             "kondisi_buku_saat_dikembalikan" => $request->kondisi_buku_saat_dikembalikan,
    //             "denda" => $denda[0] + $denda[1],
    //             "done" => 1
    //         ]);

    //         if ($update) {
    //             return redirect()->route('user.peminjaman')->with("status_pengembalian", "success")->with("message", "Anda merusak buku dan terlambat mengembalikan buku selama " . $date[0] - $date[1] . " hari, dikenakan denda sebesar Rp" . ($denda[0] + $denda[1]));
    //         }
    //         return redirect()->back()->with("status_pengembalian", "danger")->with("message", "Gagal Mengembalikan Buku");
    //     }
    //     function terlambat_hilang($date, $denda, $pengembalian, $request)
    //     {
    //         $update = $pengembalian->update([
    //             "tanggal_pengembalian" => $request->tanggal_pengembalian,
    //             "kondisi_buku_saat_dikembalikan" => $request->kondisi_buku_saat_dikembalikan,
    //             "denda" => $denda[0] + $denda[1],
    //             "done" => 1
    //         ]);

    //         if ($update) {
    //             return redirect()->route('user.peminjaman')->with("status_pengembalian", "success")->with("message", "Anda menghilangkan buku dan terlambat mengembalikan buku selama " . $date[0] - $date[1] . " hari, dikenakan denda sebesar Rp" . ($denda[0] + $denda[1]));
    //         }
    //         return redirect()->back()->with("status_pengembalian", "danger")->with("message", "Gagal Mengembalikan Buku");
    //     }
    //     function terlambat($date, $denda_terlambat, $pengembalian, $request)
    //     {
    //         $update = $pengembalian->update([
    //             "tanggal_pengembalian" => $request->tanggal_pengembalian,
    //             "kondisi_buku_saat_dikembalikan" => $request->kondisi_buku_saat_dikembalikan,
    //             "denda" => $denda_terlambat,
    //             "done" => 1
    //         ]);

    //         // dd($date);

    //         if ($update) {
    //             return redirect()->route('user.peminjaman')->with("status_pengembalian", "success")->with("message", "Pengembalian buku terlambat " . $date[0] - $date[1] . " hari, dikenakan denda sebesar Rp" . $denda_terlambat);
    //         }
    //         return redirect()->back()->with("status_pengembalian", "danger")->with("message", "Gagal Mengembalikan Buku");
    //     }
    //     function rusak($denda_rusak, $pengembalian, $request)
    //     {
    //         $update = $pengembalian->update([
    //             "tanggal_pengembalian" => $request->tanggal_pengembalian,
    //             "kondisi_buku_saat_dikembalikan" => $request->kondisi_buku_saat_dikembalikan,
    //             "denda" => $denda_rusak,
    //             "done" => 1
    //         ]);

    //         if ($update) {
    //             return redirect()->route('user.peminjaman')->with("status_pengembalian", "success")->with("message", "Anda merusak buku, dikenakan denda sebesar Rp" . $denda_rusak);
    //         }
    //         return redirect()->back()->with("status_pengembalian", "danger")->with("message", "Gagal Mengembalikan Buku");
    //     }
    //     function hilang($denda_hilang, $pengembalian, $request)
    //     {
    //         $update = $pengembalian->update([
    //             "tanggal_pengembalian" => $request->tanggal_pengembalian,
    //             "kondisi_buku_saat_dikembalikan" => $request->kondisi_buku_saat_dikembalikan,
    //             "denda" => $denda_hilang,
    //             "done" => 1
    //         ]);

    //         if ($update) {
    //             return redirect()->route('user.peminjaman')->with("status_pengembalian", "success")->with("message", "Anda menghilangkan buku, dikenakan denda sebesar Rp" . $denda_hilang);
    //         }
    //         return redirect()->back()->with("status_pengembalian", "danger")->with("message", "Gagal Mengembalikan Buku");
    //     }
    //     function baik($pengembalian, $request)
    //     {
    //         $update = $pengembalian->update([
    //             "tanggal_pengembalian" => $request->tanggal_pengembalian,
    //             "kondisi_buku_saat_dikembalikan" => $request->kondisi_buku_saat_dikembalikan,
    //             "done" => 1
    //         ]);

    //         if ($update) {
    //             return redirect()->route('user.peminjaman')->with("status_pengembalian", "success")->with("message", "Terimakasih telah mengembalikan buku dengan baik");
    //         }
    //         return redirect()->back()->with("status_pengembalian", "danger")->with("message", "Gagal Mengembalikan Buku");
    //     }


    //     // Kondisi Pengembalian Buku
    //     switch ($request) {
    //             // terlambat dan rusak/hilang
    //         case $request->tanggal_pengembalian > $pengembalian->tanggal_pengembalian && $request->kondisi_buku_saat_dikembalikan != $pengembalian->kondisi_buku_saat_dipinjam  && ($request->kondisi_buku_saat_dikembalikan == "buruk" || $request->kondisi_buku_saat_dikembalikan == "hilang"):
    //             $denda_terlambat = 5000 * ($returned - $d_return);
    //             if ($request->kondisi_buku_saat_dikembalikan == "buruk") {
    //                 $denda_rusak = 25000;
    //                 $date = [$returned, $d_return];
    //                 $denda = [$denda_terlambat, $denda_rusak];

    //                 terlambat_rusak($date, $denda, $pengembalian, $request);
    //             }
    //             $denda_hilang = 100000;
    //             $date = [$returned, $d_return];
    //             $denda = [$denda_terlambat, $denda_hilang];

    //             terlambat_hilang($date, $denda, $pengembalian, $request);
    //             break;

    //             // terlambat
    //         case $request->tanggal_pengembalian > $pengembalian->tanggal_pengembalian:
    //             $denda = 5000 * ($returned - $d_return);
    //             $date = [$returned, $d_return];

    //             terlambat($date, $denda, $pengembalian, $request);
    //             break;

    //             // rusak
    //         case $request->kondisi_buku_saat_dikembalikan != $pengembalian->kondisi_buku_saat_dipinjam  && $request->kondisi_buku_saat_dikembalikan == "buruk":
    //             $denda = 25000;

    //             rusak($denda, $pengembalian, $request);
    //             break;

    //             // hilang
    //         case $request->kondisi_buku_saat_dikembalikan == "hilang":
    //             $denda = 100000;

    //             hilang($denda, $pengembalian, $request);
    //             break;
    //         default:
    //             baik($pengembalian, $request);
    //     }

    //     // dd($request->kondisi_buku_saat_dikembalikan);
    // }
}
