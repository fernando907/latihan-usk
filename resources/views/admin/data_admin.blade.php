@extends('layouts.admin-layout')

@section('content-admin')
    <div class="card">
        @if (session('status'))
            <div class="alert alert-{{ session('status') }}" role="alert">
                {{ session('message') }}
            </div>
        @endif
        <div class="card-header d-flex justify-content-between">
            Data Admin
            <button type="button" class="btn btn-icon btn-outline-primary block" data-bs-toggle="modal"
                data-bs-target="#storeModal">
                <i class="bi bi-plus"></i>
            </button>
        </div>
        <div class="card-body">
            <table class="table" id="table1">
                <thead>
                    <tr>
                        <th>Kode</th>
                        <th>Nama Lengkap</th>
                        <th>Nama Pengguna</th>
                        <th>Alamat</th>
                        <th>Foto</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($admins as $admin)
                        <tr>
                            <td>{{ $admin->kode }}</td>
                            <td>{{ $admin->fullname }}</td>
                            <td>{{ $admin->username }}</td>
                            <td>{{ $admin->alamat }}</td>
                            <td>
                                @if ($admin->photo)
                                    <img src="{{ asset($admin->photo) }}" style="height: 100px; width: 100px;"
                                        class="card-img" alt="{{ $admin->username }}">
                                @endif
                            </td>
                            <td>
                                <span class="badge bg-success">verified</span>
                            </td>
                            <td>
                                <div class="buttons">
                                    <button type="button" class="btn btn-icon btn-primary block" data-bs-toggle="modal"
                                        data-bs-target="#updateModal{{ $admin->id }}">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                    <form method="post" action="{{ route('admin.hapus_admin', $admin->id) }}">
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
                    <div class="modal-header">
                        <h5 class="modal-title" id="storeModalTitle">
                            Tambah Admin
                        </h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <i data-feather="x"></i>
                        </button>
                    </div>
                    <form action="{{ route('admin.submit_admin') }}" enctype="multipart/form-data" method="POST"
                        class="form-group">
                        @csrf
                        <div class="modal-body">
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="">Fullname</label>
                                    <input type="text" name="fullname" value="" class="form-control" required>
                                </div>
                                <div class="d-flex gap-5">
                                    <div class="mb-3">
                                        <label for="">Username</label>
                                        <input type="text" name="username" value="" class="form-control" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="">Password</label>
                                        <input type="password" name="password" value="" class="form-control" required>
                                    </div>
                                </div>
                                <div class="d-flex gap-5">
                                    <div class="mb-3">
                                        <label for="">NIS</label>
                                        <input type="number" name="nis" value="" class="form-control">
                                    </div>
                                    <div class="mb-3">
                                        <label for="">Kelas</label>
                                        <input type="text" name="kelas" value="" class="form-control">
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="">Alamat</label>
                                    <input type="text" name="alamat" value="" class="form-control">
                                </div>
                                <div class="mb-3">
                                    <label for="">Foto</label>
                                    <input type="file" name="photo" value="" class="form-control">
                                </div>

                                <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                                <input type="hidden" name="kode" value="generate">
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

        {{-- Update Modal --}}
        @foreach ($admins as $admin)
            <div class="modal fade" id="updateModal{{ $admin->id }}" tabindex="-1" role="dialog"
                aria-labelledby="updateModalTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="storeModalTitle">
                                Update Anggota
                            </h5>
                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                <i data-feather="x"></i>
                            </button>
                        </div>
                        <form action="{{ route('admin.update_admin', $admin->id) }}" enctype="multipart/form-data"
                            method="post" class="form-group">
                            @method('put')
                            @csrf
                            <div class="modal-body">
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label for="">Fullname</label>
                                        <input type="text" name="fullname" value="{{ $admin->fullname }}"
                                            class="form-control" required>
                                    </div>
                                    <div class="d-flex gap-5">
                                        <div class="mb-3">
                                            <label for="">Username</label>
                                            <input type="text" name="username" value="{{ $admin->username }}"
                                                class="form-control" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="">NIS</label>
                                            <input type="number" name="nis" value="{{ $admin->nis }}"
                                                class="form-control">
                                        </div>
                                    </div>
                                    <div class="d-flex gap-5">
                                        <div class="mb-3">
                                            <label for="">Kelas</label>
                                            <input type="text" name="kelas" value="{{ $admin->kelas }}"
                                                class="form-control">
                                        </div>
                                        <div class="mb-3">
                                            <label for="">Alamat</label>
                                            <input type="text" name="alamat" value="{{ $admin->alamat }}"
                                                class="form-control">
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="">Foto</label>
                                        @if ($admin->photo)
                                            <br><img src="{{ $admin->photo }}" alt="{{ $admin->username }}"
                                                width="100px" height="100px">
                                        @endif
                                        <input type="file" name="photo" value="" class="form-control">
                                    </div>
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
        @endforeach
    </div>

    <script src="{{ asset('assets/extensions/simple-datatables/umd/simple-datatables.js') }}"></script>
    <script src="{{ asset('assets/js/pages/simple-datatables.js') }}"></script>
@endsection
