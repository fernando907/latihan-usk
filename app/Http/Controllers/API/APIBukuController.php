<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use Illuminate\Http\Request;

class APIBukuController extends Controller
{
    /**
     * Display a data / listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function get($id = null)
    {
        if (isset($id)) {
            $buku = Buku::findOrFail($id);
            return response()->json(['msg' => 'Data retrieved', 'data' => $buku], 200);
        } else {
            $buku = Buku::get();
            return response()->json(['msg' => 'Data retrieved', 'data' => $buku], 200);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $buku = Buku::create($request->all());
        return response()->json(['msg' => 'Data created', 'data' => $buku], 201);

        // fillable : judul str, kategori_id id, penerbit_id id, pengarang str, tahun_terbit char, isbn int (nullable), j_buku_baik int, j_buku_buruk int, photo text (nullable)
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Buku  $buku
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $buku = Buku::findOrFail($id);
        $buku->update($request->all());
        return response()->json(['msg' => 'Data updated', 'data' => $buku], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Buku  $buku
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $buku = Buku::findOrFail($id);
        $buku->delete();
        return response()->json(['msg' => 'Data deleted'], 200);
    }
}
