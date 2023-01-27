@extends('layouts.admin-layout')

@section('content-admin')
    <div class="card">
        @if (session('status'))
            <div class="alert alert-{{ session('status') }}" role="alert">
                {{ session('message') }}
            </div>
        @endif

        <div class="card-header d-flex justify-content-between">
            <h3>Laporan Anggota</h3>
            {{-- <a href="{{ route('admin.anggota_pdf') }}" class="btn btn-icon btn-outline-primary block" target="_blank">
                <i class="bi bi-file-pdf-fill"></i></a> --}}
            <button type="button" class="btn btn-icon btn-outline-primary block" data-bs-toggle="modal"
                data-bs-target="#pdfModal">
                <i class="bi bi-file-pdf-fill"></i>
            </button>
        </div>
        <div class="card-body">
            <table class="table" id="table1">
                <thead>
                    <tr>
                        <th>Nama Anggota</th>
                        <th>Judul Buku</th>
                        <th>Tanggal Peminjaman</th>
                        <th>Tanggal Pengembalian</th>
                        <th>Kondisi Buku Saat Dipinjam</th>
                        <th>Kondisi Buku Saat Dikembalikan</th>
                        <th>Denda</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $key => $data)
                        <tr>
                            <td>
                                {{ $data->user->fullname }}
                            </td>
                            <td>{{ $data->buku->judul }}</td>
                            <td>{{ $data->tanggal_peminjaman }}</td>
                            <td>{{ $data->tanggal_pengembalian }}</td>
                            <td>{{ $data->kondisi_buku_saat_dipinjam }}</td>
                            <td>{{ $data->kondisi_buku_saat_dikembalikan }}</td>
                            <td>{{ $data->denda }}</td>

                            <td>
                                @if ($data->done === 1)
                                    <span class="badge bg-success">Sudah Dikembalikan</span>
                                @else
                                    <span class="badge bg-warning text-black">Belum Dikembalikan</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- PDF Modal --}}
        <div class="modal fade" id="pdfModal" tabindex="-1" role="dialog" aria-labelledby="pdfModalTitle"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-centered modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    {{-- <form action="{{ route('admin.submit_buku') }}" enctype="multipart/form-data" method="POST" --}}
                    <form enctype="multipart/form-data" method="POST"
                        class="form-group">
                        @csrf
                        <div class="modal-header">
                            {{-- <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                <i data-feather="x"></i>
                            </button> --}}
                            <h5 class="modal-title" id="pdfModalTitle">
                                Export PDF Anggota
                            </h5>
                        </div>
                        <div class="modal-body">
                            <div class="card-body">
                                <div class="d-flex mb-3 gap-2 justify-content-between">
                                    <div>
                                        <label for="kategori_id">Anggota</label>
                                        <select name="kategori_id" required class="form-select">
                                            <option disabled selected>--Pilih Opsi--</option>
                                            @foreach ($anggotas as $anggota)
                                                <option value="{{ $anggota->id }}"
                                                    {{ isset($anggota_id) ? ($anggota_id == $anggota->id ? 'selected' : '') : '' }}>
                                                    {{ $anggota->fullname }} / {{ $anggota->username }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div>
                                        <label for="">Status</label>
                                        <select name="done" required class="form-select">
                                            <option value="" disabled selected>--Pilih Opsi--</option>
                                            <option value="null">Semua</option>
                                            <option value="false">Belum Dikembalikan</option>
                                            <option value="true">Sudah Dikembalikan</option>
                                        </select>
                                    </div>
                                </div>

                                <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                                <i class="bx bx-x d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Close</span>
                            </button>
                            <button  class="btn btn-primary ml-1">
                                <a href="{{ route('admin.submit_buku', $anggota->id) }}">
                                <i class="bx bx-check d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Submit</span></a>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('assets/extensions/simple-datatables/umd/simple-datatables.js') }}"></script>
    <script src="{{ asset('assets/js/pages/simple-datatables.js') }}"></script>
@endsection
