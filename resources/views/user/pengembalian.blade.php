@extends('layouts.user-layout')

@section('content-user')
    {{-- @if (session('status_pengembalian'))
        <div class="alert alert-{{ session('status_pengembalian') }}">
            {{ session('message') }}
        </div>
    @endif
    <div style="max-width: 40%">
        <div class="card">
            <div class="card-header">
                <h4>Data Pengembalian</h4>
            </div>

            <div class="card-body">
                <form action="{{ route('user.submit_pengembalian') }}" method="POST" enctype="multipart/form-data"
                    class="form-group">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="">Buku yang Dikembalikan</label>

                        <select name="buku_id" required class="form-select">
                            <option disabled selected>--Pilih Opsi--</option>

                            @foreach ($bukus as $buku)
                                <option value="{{ $buku->id }}"
                                    {{ isset($buku_id) ? ($buku_id == $buku->id ? 'selected' : '') : '' }}>
                                    {{ $buku->judul }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="">Tanggal Pengembalian</label>
                        <input type="date" readonly name="tanggal_pengembalian" value="<?php echo $today; ?>"
                            class="form-control">
                    </div>

                    <div class="mb-3">
                        <label for="">Kondisi buku</label>
                        <select name="kondisi_buku_saat_dikembalikan" required class="form-select">
                            <option value="" disabled selected>--Pilih Opsi--</option>
                            <option value="baik">Baik</option>
                            <option value="buruk">Buruk</option>
                            <option value="hilang">Hilang</option>
                        </select>
                    </div>
                    <button class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div> --}}

    <div>
        @if (session('status_pengembalian'))
            <div class="alert alert-{{ session('status_pengembalian') }}">
                {{ session('message') }}
            </div>
        @endif
        <div class="row">
            <div class="col-10">
                <h1>Data Pengembalian</h1>
            </div>
            <div class="col-2">
                <a href="{{ route('user.form_pengembalian') }}" class="btn btn-primary float">Kembalikan</a>
            </div>
        </div>
        <div>
            <table class="table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Judul Buku</th>
                        <th>Tanggal Peminjaman</th>
                        <th>Tanggal Pengembalian</th>
                        <th>Kondisi Buku Saat Dipinjam</th>
                        <th>Kondisi Buku Saat Dikembalikan</th>
                        <th>Denda</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($datas as $key => $data)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $data->buku->judul }}</td>
                            <td>{{ $data->tanggal_peminjaman }}</td>
                            <td>{{ $data->tanggal_pengembalian }}</td>
                            <td>{{ $data->kondisi_buku_saat_dipinjam }}</td>
                            <td>{{ $data->kondisi_buku_saat_dikembalikan }}</td>
                            <td>{{ $data->denda }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
