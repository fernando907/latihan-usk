@extends('layouts.user-layout')

@section('content-user')
    <div class="col-10">
        <div class="">
            @foreach ($pemberitahuans as $pemberitahuan)
                <div class="alert alert-primary col-9" role="alert">
                    {{ $pemberitahuan->isi }}
                </div>
            @endforeach
            <div class="row">
                @foreach ($bukus as $buku)
                    <div class="col-3">
                        <div class="card">
                            <div class="card-header">
                                <img src="{{ url('/img' . '/' . $buku->photo) }}" style="height: 150px;object-fit: cover;"
                                    class="card-img" alt="{{ $buku->judul }}">
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
