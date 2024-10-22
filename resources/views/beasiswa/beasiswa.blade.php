@extends('layout.index')

@section('content')
<div class="mt-4">
    <div class="d-flex justify-content-center align-items-center mb-4">
        <h1 class="text-center"><b>LIST BEASISWA</b></h1>
    </div>

    <!-- Tombol Tambah Beasiswa -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahBeasiswa">
            <b>Tambah Beasiswa</b>
        </button>
    </div>

    <!-- Tabel Beasiswa -->
    <table class="table table-bordered tb-beasiswa">
        <thead class="bg-primary text-white">
            <tr>
                <th style="text-align: center;">No</th>
                <th style="text-align: center;">Nama Beasiswa</th>
                <th style="text-align: center;">Sumber Dana</th>
                <th style="text-align: center;">Syarat</th>
                <th style="text-align: center;">Jumlah Kuota</th>
            </tr>
        </thead>
        <tbody>
            @if($beasiswa->isEmpty())
            <tr>
                <td colspan="5" style="text-align: center;">Tidak ada data beasiswa yang tersedia.</td>
            </tr>
            @else
            @foreach($beasiswa as $index => $data)
            <tr>
                <td style="text-align: center;">{{ $index + 1 }}</td>
                <td style="text-align: center;">{{ $data->nama }}</td>
                <td style="text-align: center;">{{ $data->sumber_dana }}</td>
                <td style="text-align: center;">
                    <ul>
                        @foreach($data->syarat as $syarat)
                        <li>{{ $syarat->syarat }}</li>
                        @endforeach
                    </ul>
                </td>
                <td style="text-align: center;">{{ $data->jumlah_kuota }} mahasiswa</td>
            </tr>
            @endforeach
            @endif
        </tbody>
    </table>
</div>

@include('beasiswa.tambah-beasiswa')

@endsection