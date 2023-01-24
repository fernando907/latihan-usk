@extends('layouts.admin-layout')

@section('content-admin')
    <div class="card">
        @if (session('status'))
            <div class="alert alert-{{ session('status') }}" role="alert">
                {{ session('message') }}
            </div>
        @endif
        <div class="card-header d-flex justify-content-between">
            Data Penerbit
            <button type="button" class="btn btn-icon btn-outline-primary block" data-bs-toggle="modal"
                data-bs-target="#exampleModalCenter">
                <i class="bi bi-plus"></i>
            </button>
        </div>
        <div class="card-body">
            <table class="table" id="table1">
                <thead>
                    <tr>
                        <th>Kode</th>
                        <th>Nama</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($penerbits as $penerbit)
                        <tr>
                            <td>{{ $penerbit->kode }}</td>
                            <td>{{ $penerbit->nama }}</td>
                            <td>
                                @if ($penerbit->verif_penerbit === 'verified')
                                    <span class="badge bg-success">Verified</span>
                                @else
                                    <span class="badge bg-warning text-black">Unverified</span>
                                @endif
                            </td>
                            <td>
                                <div class="buttons">
                                    <a href="#" class="btn icon btn-primary"><i class="bi bi-pencil"></i></a>
                                    <form method="post" action="{{ route('admin.hapus_penerbit', $penerbit->id) }}">
                                        @method('delete')
                                        @csrf
                                        <button type="submit" class="btn btn-danger">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Modal --}}
        <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-centered modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalCenterTitle">
                            Tambah Kategori
                        </h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <i data-feather="x"></i>
                        </button>
                    </div>
                    <form action="{{ route('admin.submit_penerbit') }}" method="POST" class="form-group">
                        @csrf
                        <div class="modal-body">
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="">Kode</label>
                                    <input type="text" name="kode" value="" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label for="">Nama</label>
                                    <input type="text" name="nama" value="" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label for="">Status</label>
                                    <select name="verif_penerbit" required class="form-select">
                                        <option value="" disabled selected>--Pilih Opsi--</option>
                                        <option value="verified">Verified</option>
                                        <option value="unverified">Unverified</option>
                                    </select>
                                </div>

                                <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                                <i class="bx bx-x d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Close</span>
                            </button>
                            <button class="btn btn-primary ml-1">
                                <i class="bx bx-check d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Submit</span>
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
