@extends('layouts.user-layout')

@section('content-user')
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
                                <span class="badge bg-info">Only User</span>

                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
