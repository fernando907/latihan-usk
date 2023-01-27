@extends('layouts.user-layout')

@section('content-user')
    <div class="col-12">
        <div class="">
            @foreach ($pemberitahuans as $pemberitahuan)
                @if ($pemberitahuans->count() > 3)
                    {{ null }}
                @else
                    @if ($pemberitahuan->status == 'aktif')
                        <div class="alert alert-primary col-12 d-flex justify-content-center" role="alert">
                            {{ $pemberitahuan->isi }}
                        </div>
                    @elseif ($pemberitahuan->status == 'user')
                        <div class="alert alert-info col-12 d-flex justify-content-center" role="alert">
                            {{ $pemberitahuan->isi }}
                        </div>
                    @endif
                @endif
            @endforeach
            @if ($pemberitahuans->count() > 3)
                <div class="alert alert-primary col-12 d-flex justify-content-center" role="alert">
                    Silahkan cek pemberitahuan
                </div>
            @endif
            <div class="row">
                @foreach ($bukus as $buku)
                    <div class="col-4">
                        <div class="card">
                            <div class="card-header">
                                <img src="{{ asset($buku->photo) }}" style="height: 150px;object-fit: cover;"
                                    class="card-img" alt="{{ $buku->photo }}">
                            </div>
                            <div class="card-body">
                                <h4 style="font-size: 24px; font-weight: bold">
                                    {{ $buku->judul }}
                                </h4>
                                <span class="badge bg-secondary">{{ $buku->kategori->nama }}</span>
                                <div class="row">
                                    <div class="col-6">
                                        <p class="text-start">
                                            {{ $buku->pengarang }}
                                        </p>
                                    </div>
                                    <div class="col-6">
                                        <p class="text-end">{{ $buku->penerbit->nama }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <form method="POST" action="{{ route('user.form_peminjaman_dashboard') }}">
                                    @csrf
                                    <input type="hidden" value="{{ $buku->id }}" name="buku_id">
                                    <button class="btn btn-primary">
                                        Pinjam
                                    </button>
                                </form>
                            </div>

                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
