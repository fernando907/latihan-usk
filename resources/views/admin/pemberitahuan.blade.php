@extends('layouts.admin-layout')

@section('content-admin')
    <div>
        <div class="row">
            <div class="col-10">
                <h1>Pemberitahuan</h1>
            </div>
        </div>
        <div>
            <table class="table">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Isi</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pemberitahuans as $key => $pemberitahuan)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $pemberitahuan->isi }}</td>
                            <td>
                                @if ($pemberitahuan->status == 'aktif')
                                <span class="badge bg-primary">General</span>
                                @else
                                <span class="badge bg-info">Only Admin</span>

                                @endif
                            </td>
                            <td>
                                <form action="{{ route('admin.nonactive_notif', ['id' => $pemberitahuan->id]) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="penerima_id" value="{{ Auth::user()->id }}">
                                    <button type="submit" class="btn btn-danger">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
