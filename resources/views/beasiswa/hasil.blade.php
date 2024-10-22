@extends('layout.index')

@section('content')
<div class="mt-4">
    <div class="d-flex justify-content-center align-items-center mb-5">
        <h1 class="text-center"><b>PENDAFTAR</b></h1>
    </div>

    <!-- Tabel Beasiswa -->
    <table class="table table-bordered tb-beasiswa">
        <thead class="bg-primary text-white">
            <tr>
                <th style="text-align: center;">No</th>
                <th style="text-align: center;">Nama Mahasiswa</th>
                <th style="text-align: center;">Email</th>
                <th style="text-align: center;">Nomor Handphone</th>
                <th style="text-align: center;">Semester</th>
                <th style="text-align: center;">IPK</th>
                <th style="text-align: center;">Beasiswa</th>
            </tr>
        </thead>
        <tbody>
            @if( $mahasiswa->isEmpty() )
            <tr>
                <td colspan="7" style="text-align: center;">Tidak ada mahasiswa yang mendaftar beasiswa.</td>
            </tr>
            @else
            @foreach($mahasiswa as $index => $data)
            <tr>
                <td style="text-align: center;">{{ $index + 1 }}</td>
                <td style="text-align: center;">{{ $data->nama }}</td>
                <td style="text-align: center;">{{ $data->email }}</td>
                <td style="text-align: center;">{{ $data->phone }}</td>
                <td style="text-align: center;">{{ $data->semester }}</td>
                <td style="text-align: center;">{{ $data->ipk }}</td>
                <td style="text-align: center;">{{ $data->nama_beasiswa }}</td>
            </tr>
            @endforeach
            @endif
        </tbody>
    </table>
</div>
@endsection