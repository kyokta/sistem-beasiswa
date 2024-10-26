<div class="modal fade" id="tambahBeasiswa" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Beasiswa</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="mb-3 row">
                        <label for="namaBeasiswa" class="col-sm-4 col-form-label">Nama Beasiswa</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="namaBeasiswa" name="namaBeasiswa" placeholder="Masukkan nama beasiswa">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="jenisBeasiswa" class="col-sm-4 col-form-label">Jenis Beasiswa</label>
                        <div class="col-sm-8">
                            <select name="jenisBeasiswa" id="jenisBeasiswa" class="form-control">
                                <option value="" disabled selected>Pilih jenis beasiswa</option>
                                <option value="akademik">Akademik</option>
                                <option value="non-akademik">Non Akademik</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="sumberDana" class="col-sm-4 col-form-label">Sumber Dana</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="sumberDana" id="sumberDana" placeholder="Masukkan sumber dana">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="syaratContainer" class="col-sm-4 col-form-label">Syarat</label>
                        <div class="col-sm-8" id="syaratContainer">
                            <div class="d-flex align-items-center mb-2">
                                <input type="text" class="form-control" name="syarat[]" placeholder="Masukkan syarat">
                                <button type="button" class="btn btn-success ms-2 add-syarat">+</button>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="jumlahKuota" class="col-sm-4 col-form-label">Jumlah Kuota</label>
                        <div class="col-sm-8">
                            <input type="number" class="form-control" name="jumlahKuota" id="jumlahKuota" placeholder="Masukkan jumlah kuota">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="btnSimpanBeasiswa">Save changes</button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    $(document).ready(function() {
        // Menambahkan syarat baru
        $('#syaratContainer').on('click', '.add-syarat', function() {
            const $currentInput = $(this).siblings('input');
            const currentValue = $currentInput.val();

            if (currentValue) {
                // Menonaktifkan input yang ada
                $currentInput.prop('disabled', true);
                $(this).text('-').removeClass('add-syarat btn-success').addClass('remove-syarat btn-danger');

                // Menambahkan input syarat baru
                const newInput = `
                    <div class="d-flex align-items-center mb-2">
                        <input type="text" class="form-control" name="syarat[]" placeholder="Masukkan syarat" required>
                        <button type="button" class="btn btn-success ms-2 add-syarat">+</button>
                    </div>
                `;
                $('#syaratContainer').append(newInput);
            }
        });

        // Menghapus syarat
        $('#syaratContainer').on('click', '.remove-syarat', function() {
            const $currentInput = $(this).siblings('input');
            $currentInput.prop('disabled', false).val('');
            $(this).parent().remove();
        });

        // Menyimpan beasiswa
        $('#btnSimpanBeasiswa').on('click', function() {
            var namaBeasiswa = $('#namaBeasiswa').val();
            var jenisBeasiswa = $('#jenisBeasiswa').val();
            var sumberDana = $('#sumberDana').val();
            var syarat = $('input[name="syarat[]"]').map(function() {
                return $(this).val();
            }).get().filter(function(value) {
                return value.trim() !== "";
            });
            var jumlahKuota = $('#jumlahKuota').val();

            if (!namaBeasiswa) {
                Swal.fire({
                    title: "Peringatan",
                    text: "Nama beasiswa belum diisi.",
                    icon: "warning",
                    confirmButtonText: "OK"
                });
                return;
            }

            if (!jenisBeasiswa) {
                Swal.fire({
                    title: "Peringatan",
                    text: "Jenis beasiswa belum dipilih.",
                    icon: "warning",
                    confirmButtonText: "OK"
                });
                return;
            }

            if (!sumberDana) {
                Swal.fire({
                    title: "Peringatan",
                    text: "Sumber dana beasiswa belum diisi.",
                    icon: "warning",
                    confirmButtonText: "OK"
                });
                return;
            }

            if (syarat.length < 2) {
                Swal.fire({
                    title: "Peringatan",
                    text: "Minimal syarat beasiswa adalah 2 syarat.",
                    icon: "warning",
                    confirmButtonText: "OK"
                });
                return;
            }

            if (!jumlahKuota) {
                Swal.fire({
                    title: "Peringatan",
                    text: "Jumlah kuota beasiswa belum diisi.",
                    icon: "warning",
                    confirmButtonText: "OK"
                });
                return;
            }

            $.ajax({
                url: `{{ route('store-beasiswa') }}`,
                type: 'POST',
                data: {
                    namaBeasiswa: namaBeasiswa,
                    jenisBeasiswa: jenisBeasiswa,
                    sumberDana: sumberDana,
                    syarat: syarat,
                    jumlahKuota: jumlahKuota,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    Swal.fire({
                        icon: "success",
                        title: response.message,
                        showConfirmButton: false,
                        timer: 1500
                    }).then(() => {
                        location.reload();
                    });
                },
                error: function(xhr, status, error) {
                    Swal.fire({
                        title: "Oopss",
                        text: error,
                        icon: "error"
                    });
                }
            });
        })
    });
</script>
@endpush