@extends('layouts.admin-layout')

@section('content-admin')
    <div class="card">
        @if (session('status'))
            <div class="alert alert-{{ session('status') }}" role="alert">
                {{ session('message') }}
            </div>
        @endif
        <div class="card-header d-flex justify-content-between">
            <h3>Data Buku</h3>
            <button type="button" class="btn btn-icon btn-outline-primary block" data-bs-toggle="modal"
                data-bs-target="#storeModal">
                <i class="bi bi-plus"></i>
            </button>
        </div>
        <div class="card-body">
            <table class="table" id="table1">
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
                            <td>
                                @if ($buku->photo)
                                    <img src="{{ asset($buku->photo) }}" alt="{{ $buku->judul }}" width="100px"
                                        height="100px">
                                @endif
                            </td>
                            <td>{{ $buku->pengarang }}</td>
                            <td>{{ $buku->j_buku_baik }}</td>
                            <td>{{ $buku->j_buku_buruk }}</td>
                            <td>
                                <div class="buttons">
                                    <button type="button" class="btn btn-icon btn-primary block" data-bs-toggle="modal"
                                        data-bs-target="#updateModal{{ $buku->id }}">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                    <form method="post" action="{{ route('admin.hapus_buku', $buku->id) }}">
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

        {{-- Store Modal --}}
        <div class="modal fade" id="storeModal" tabindex="-1" role="dialog" aria-labelledby="storeModalTitle"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-centered modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <form action="{{ route('admin.submit_buku') }}" enctype="multipart/form-data" method="POST"
                        class="form-group">
                        @csrf
                        <div class="modal-header">
                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                <i data-feather="x"></i>
                            </button>
                            <h5 class="modal-title" id="storeModalTitle">
                                Tambah Buku
                            </h5>
                            <button class="btn btn-primary ml-1">
                                <i class="bx bx-check d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Submit</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="">Judul</label>
                                    <input type="text" name="judul" value="" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label for="pengarang">Pengarang</label>
                                    <input type="text" name="pengarang" value="" class="form-control" required>
                                </div>
                                <div class="d-flex mb-3 gap-2 justify-content-between">
                                    <div>
                                        <label for="kategori_id">Kategori</label>
                                        <select name="kategori_id" required class="form-select">
                                            <option disabled selected>--Pilih Opsi--</option>
                                            @foreach ($kategoris as $kategori)
                                                <option value="{{ $kategori->id }}"
                                                    {{ isset($kategori_id) ? ($kategori_id == $kategori->id ? 'selected' : '') : '' }}>
                                                    {{ $kategori->nama }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div>
                                        <label for="penerbit_id">Penerbit</label>
                                        <select name="penerbit_id" required class="form-select">
                                            <option disabled selected>--Pilih Opsi--</option>
                                            @foreach ($penerbits as $penerbit)
                                                <option value="{{ $penerbit->id }}"
                                                    {{ isset($penerbit_id) ? ($penerbit_id == $penerbit->id ? 'selected' : '') : '' }}>
                                                    {{ $penerbit->nama }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="d-flex mb-3 gap-2 justify-content-between">
                                    <div>
                                        <label for="tahun_terbit">Tahun Terbit</label>
                                        <input type="number" min="0" max="5000" name="tahun_terbit"
                                            value="" class="form-control" required>
                                    </div>
                                    <div>
                                        <label for="isbn">ISBN</label>
                                        <input type="number" name="isbn" value="" class="form-control">
                                    </div>
                                </div>
                                <div class="d-flex mb-3 gap-2 justify-content-between">
                                    <div>
                                        <label for="j_buku_baik">Jumlah Buku Baik</label>
                                        <input type="number" min="0" max="5000" name="j_buku_baik"
                                            value="" class="form-control" required>
                                    </div>
                                    <div>
                                        <label for="j_buku_buruk">Jumlah Buku Rusak</label>
                                        <input type="number" name="j_buku_buruk" value="" class="form-control"
                                            required>
                                    </div>
                                </div>

                                <div class="d-flex mb-3 gap-2 justify-content-between">
                                    <div>
                                        <label for="photo">Photo</label>
                                        <input type="file" name="photo" value="" class="form-control">
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
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- Update Modal --}}
        @foreach ($bukus as $buku)
            <div class="modal fade" id="updateModal{{ $buku->id }}" tabindex="-1" role="dialog"
                aria-labelledby="updateModalTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-dialog-centered modal-dialog-scrollable"
                    role="document">
                    <div class="modal-content">
                        <form action="{{ route('admin.update_buku', $buku->id) }}" enctype="multipart/form-data"
                            method="post" class="form-group">
                            @method('put')
                            @csrf
                            <div class="modal-header">
                                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                    <i data-feather="x"></i>
                                </button>
                                <h5 class="modal-title" id="updateModalTitle">
                                    Update Buku
                                </h5>
                                <button class="btn btn-primary ml-1">
                                    <i class="bx bx-check d-block d-sm-none"></i>
                                    <span class="d-none d-sm-block">Submit</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label for="">Judul</label>
                                        <input type="text" name="judul" value="{{ $buku->judul }}"
                                            class="form-control" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="pengarang">Pengarang</label>
                                        <input type="text" name="pengarang" value="{{ $buku->pengarang }}"
                                            class="form-control" required>
                                    </div>
                                    <div class="d-flex mb-3 gap-2 justify-content-between">
                                        <div>
                                            <label for="kategori_id">Kategori</label>
                                            <select name="kategori_id" required class="form-select">
                                                <option disabled selected>--Pilih Opsi--</option>
                                                @foreach ($kategoris as $kategori)
                                                    <option value="{{ $kategori->id }}"
                                                        {{ isset($kategori_id) ? ($kategori_id == $kategori->id ? 'selected' : '') : '' }}>
                                                        {{ $kategori->nama }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div>
                                            <label for="penerbit_id">Penerbit</label>
                                            <select name="penerbit_id" required class="form-select">
                                                <option disabled selected>--Pilih Opsi--</option>
                                                @foreach ($penerbits as $penerbit)
                                                    <option value="{{ $penerbit->id }}"
                                                        {{ isset($penerbit_id) ? ($penerbit_id == $penerbit->id ? 'selected' : '') : '' }}>
                                                        {{ $penerbit->nama }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="d-flex mb-3 gap-2 justify-content-between">
                                        <div>
                                            <label for="tahun_terbit">Tahun Terbit</label>
                                            <input type="number" min="0" max="5000" name="tahun_terbit"
                                                value="{{ $buku->tahun_terbit }}" class="form-control" required>
                                        </div>
                                        <div>
                                            <label for="isbn">ISBN</label>
                                            <input type="number" name="isbn" value="{{ $buku->isbn }}"
                                                class="form-control">
                                        </div>
                                    </div>
                                    <div class="d-flex mb-3 gap-2 justify-content-between">
                                        <div>
                                            <label for="j_buku_baik">Jumlah Buku Baik</label>
                                            <input type="number" min="0" max="5000" name="j_buku_baik"
                                                value="{{ $buku->j_buku_baik }}" class="form-control" required>
                                        </div>
                                        <div>
                                            <label for="j_buku_buruk">Jumlah Buku Rusak</label>
                                            <input type="number" name="j_buku_buruk" value="{{ $buku->j_buku_buruk }}"
                                                class="form-control" required>
                                        </div>
                                    </div>

                                    <div class="d-flex mb-3 gap-2 justify-content-between">
                                        <div>
                                            <label for="photo">Photo</label>
                                            @if ($buku->photo)
                                                <img src="{{ $buku->photo }}" alt="{{ $buku->judul }}">
                                            @endif
                                            <input type="file" name="photo" value="" class="form-control">
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
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <script src="{{ asset('assets/extensions/simple-datatables/umd/simple-datatables.js') }}"></script>
    <script src="{{ asset('assets/js/pages/simple-datatables.js') }}"></script>
@endsection
