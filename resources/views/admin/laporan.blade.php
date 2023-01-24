@extends('layouts.admin-layout')

@section('content-admin')
    <div class="card">
        <div class="card-header">Laporan Perpustakaan</div>
        <div class="card-body">
            {{-- <table class="table" id="table1">
                <thead>
                    <tr>
                        <th>Judul</th>
                        <th>Kategori</th>
                        <th>Penerbit</th>
                        <th>Tahun Terbit</th>
                        <th>ISBN</th>
                        <th>Foto</th>
                        <th>Pengarang</th>
                        <th>Jumlah Buku Baik</th>
                        <th>Jumlah Buku Buruk</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($bukus as $buku)
                        <tr>
                            <td>{{ $buku->judul }}</td>
                            <td>{{ $buku->kategori->nama }}</td>
                            <td>{{ $buku->penerbit->nama }}</td>
                            <td>{{ $buku->tahun_terbit }}</td>
                            <td>{{ $buku->isbn }}</td>
                            <td><img src="{{ asset($buku->photo) }}" alt="{{ $buku->judul }}" width="100px" height="100px">
                            </td>
                            <td>{{ $buku->pengarang }}</td>
                            <td>{{ $buku->j_buku_baik }}</td>
                            <td>{{ $buku->j_buku_buruk }}</td>
                            <td>
                                <div class="buttons">
                                    <a href="#" class="btn icon btn-primary"><i class="bi bi-pencil"></i></a>
                                    <a href="#" class="btn icon btn-danger"><i class="bi bi-trash"></i></a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table> --}}
        </div>
    </div>

    <script src="{{ asset('assets/extensions/simple-datatables/umd/simple-datatables.js') }}"></script>
    <script src="{{ asset('assets/js/pages/simple-datatables.js') }}"></script>
@endsection
