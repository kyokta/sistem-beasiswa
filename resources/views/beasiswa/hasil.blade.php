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
                <th style="text-align: center;">Berkas</th>
                <th style="text-align: center;">Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($mahasiswa as $index => $data)
            <tr>
                <td style="text-align: center;">{{ $index + 1 }}</td>
                <td style="text-align: center;">{{ $data->nama }}</td>
                <td style="text-align: center;">{{ $data->email }}</td>
                <td style="text-align: center;">{{ $data->phone }}</td>
                <td style="text-align: center;">{{ $data->semester }}</td>
                <td style="text-align: center;">{{ $data->ipk }}</td>
                <td style="text-align: center;">{{ $data->nama_beasiswa }}</td>
                <td style="text-align: center;">
                    <a href="{{ Storage::url($data->berkas) }}" target="_blank">
                        <button class="btn btn-success">Lihat berkas</button>
                    </a>
                </td>
                <td style="text-align: center;">
                    @if($data->status === 'unverified')
                    <span class="badge bg-secondary">Unverified</span>
                    @elseif($data->status === 'on-review')
                    <span class="badge bg-warning text-dark">On Review</span>
                    @elseif($data->status === 'verified')
                    <span class="badge bg-info text-dark">Verified</span>
                    @elseif($data->status === 'accepted')
                    <span class="badge bg-success">Accepted</span>
                    @else
                    <span class="badge bg-dark">Unknown</span>
                    @endif
                </td>

            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection