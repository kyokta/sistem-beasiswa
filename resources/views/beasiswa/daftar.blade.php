@extends('layout.index')

@section('content')
<div class="mt-4">
    <div class="d-flex justify-content-center align-items-center mb-5">
        <h1 class="text-center"><b>DAFTAR BEASISWA</b></h1>
    </div>

    <div class="container">
        <div class="card">
            <div class="card-header bg-primary text-white py-2">
                <b>Registrasi Beasiswa</b>
            </div>
            <div class="card-body d-flex justify-content-center">
                <!-- Form Registrasi Beasiswa -->
                <form action="{{ route('store-mahasiswa') }}" method="POST" class="w-75" id="formMahasiswa">
                    @csrf
                    <div class="mb-3 row">
                        <label for="nama" class="col-sm-4 col-form-label">Nama</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="nama" name="nama" placeholder="Masukkkan nama" required>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="email" class="col-sm-4 col-form-label">Email</label>
                        <div class="col-sm-8">
                            <input type="email" class="form-control" name="email" id="email" placeholder="Masukkan email" required>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="phone" class="col-sm-4 col-form-label">Nomor Handphone</label>
                        <div class="col-sm-8">
                            <input type="tel" class="form-control" name="phone" id="phone" placeholder="Masukkan nomor handphone" required>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="semester" class="col-sm-4 col-form-label">Semester saat ini</label>
                        <div class="col-sm-8">
                            <select name="semester" id="semester" class="form-control" required>
                                <option value="" selected disabled>Pilih semester saat ini</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                                <option value="6">6</option>
                                <option value="7">7</option>
                                <option value="8">8</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="ipk" class="col-sm-4 col-form-label">IPK terakhir</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="ipk" id="ipk" required readonly disabled>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="beasiswa" class="col-sm-4 col-form-label">Pilihan Beasiswa</label>
                        <div class="col-sm-8">
                            <select class="form-control" name="beasiswa" id="beasiswa" required disabled>
                                <option value="" selected disabled>Pilih jenis beasiswa</option>
                                @foreach($beasiswa as $data)
                                <option value="{{ $data-> id}}">{{ $data->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="berkas" class="col-sm-4 col-form-label">Berkas Syarat</label>
                        <div class="col-sm-8">
                            <input type="file" name="berkas" id="berkas" class="form-control" disabled>
                        </div>
                    </div>
                    <div class="mb-3 d-flex justify-content-center gap-5">
                        <button type="submit" class="btn btn-primary" id="submitBtn" disabled>Daftar</button>
                        <button type="button" class="btn btn-danger" id="cancelBtn">Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        function clearForm() {
            $('#nama').val('');
            $('#email').val('');
            $('#phone').val('');
            $('#semester').val('');
            $('#ipk').prop('disabled', true).val('');
            $('#beasiswa').prop('disabled', true).val('').change();
            $('#berkas').prop('disabled', true).val('');
            $('#submitBtn').prop('disabled', true);
        }

        $('#phone').on('input', function() {
            this.value = this.value.replace(/[^0-9]/g, '');
        });

        $('#semester').on('change', function() {
            $('#ipk').prop('disabled', false);

            const nilaiIPK = 1.5;
            const semesterValue = parseInt($(this).val());

            if (!isNaN(semesterValue)) {
                const ipkValue = semesterValue * nilaiIPK;
                $('#ipk').val(ipkValue.toFixed(2));

                if (ipkValue < 3) {
                    $('#beasiswa').prop('disabled', true);
                    $('#berkas').prop('disabled', true);
                    $('#submitBtn').prop('disabled', true);
                } else {
                    $('#beasiswa').prop('disabled', false);
                    $('#berkas').prop('disabled', false);
                    $('#submitBtn').prop('disabled', false);
                }
            } else {
                $('#ipk').val('');
            }
        });

        $('#cancelBtn').on('click', function() {
            clearForm();
        });

        $('#formMahasiswa').on('submit', function(e) {
            e.preventDefault();

            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Anda akan mengirimkan data beasiswa!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Kirim!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    var formData = new FormData(this);

                    $.ajax({
                        url: $(this).attr('action'),
                        type: 'POST',
                        data: formData,
                        contentType: false,
                        processData: false,
                        success: function(response) {
                            Swal.fire({
                                icon: 'success',
                                title: response.status === 'success' ? 'Registrasi berhasil!' : 'Gagal!',
                                text: response.message,
                                showConfirmButton: false,
                                timer: 1500
                            });

                            clearForm()
                        },
                        error: function(xhr) {
                            var errorMessage = 'Terjadi kesalahan.';
                            if (xhr.status === 422) {
                                errorMessage = xhr.responseJSON.message + ' ' + JSON.stringify(xhr.responseJSON.errors);
                            }
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: errorMessage,
                            });
                        }
                    });
                }
            });
        });

    })
</script>
@endpush