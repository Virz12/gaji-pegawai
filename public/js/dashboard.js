// public/js/dashboard.js

$(document).ready(function() {
    $('#saveTemplateBtn').on('click', function(e) {
        e.preventDefault(); // Prevent default form submission
        let saveTemplateUrl = $('#whatsappForm').data('save-template-url');
        $('#whatsappForm').attr('action', saveTemplateUrl);
        $('#whatsappForm').submit();
    });

    $('#sendBtn').on('click', function() {
        $('#whatsappForm').attr('action');
        let pesanType = $('input[name=options-outlined]:checked').attr('id');
        $('#pesan_type').val(pesanType);

        $('#whatsappForm').submit();
    });

    $('#templateSelectBtn').dropdown();
    
    $('.dropdown-item').on('click', function() {
        var selectedTemplate = $(this).data('value');
        var templateName = $(this).data('name');
        $('#pesan').val(selectedTemplate);
        $('#nama_template').val(templateName);
    });

    // Live Search
    $('#search').on('keyup', function() {
        let query = $(this).val();

        $.ajax({
            url: search,
            type: "GET",
            data: { 'query': query },
            success: function(data) {
                $('#pegawai-list').empty();
                if (data.length > 0) {
                    data.forEach(pegawai => {
                        let pegawaiHtml = `
                            <div type="button" class="btn btn-outline-success rounded p-2 text-start d-flex justify-content-between align-items-center search-item"
                                data-nomor="${pegawai.nomorWa}">
                                ${pegawai.nama}
                                <div class="btn-group">
                                    <button type="button" class="btn btn-sm btn-secondary rounded" data-bs-toggle="dropdown" aria-expanded="false" aria-label="dropdown">
                                        <i class="fa-solid fa-ellipsis"></i>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="/arsip">Arsip Pesan</a></li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li><a class="dropdown-item" href="/editpegawai/${pegawai.id}">Edit</a></li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li class="dropdown-item" data-bs-toggle="modal" data-bs-target="#Hapus${pegawai.nip}">Hapus</li>
                                    </ul>
                                </div>
                            </div>
                            <div class="modal fade" id="Hapus${pegawai.nip}" tabindex="-1" aria-labelledby="HapusLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="HapusLabel">Hapus Data</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body text-center">
                                            Apakah anda yakin ingin menghapus data ini?<br>
                                            <b>${pegawai.nama}</b>
                                        </div>
                                        <div class="modal-footer">
                                            <form action="/hapuspegawai/${pegawai.id}" method="POST">
                                                <input type="hidden" name="_token" value="${$('meta[name="csrf-token"]').attr('content')}">
                                                <input type="hidden" name="_method" value="DELETE">
                                                <button type="submit" class="btn btn-danger">Hapus</button>
                                            </form>
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kembali</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `;
                        $('#pegawai-list').append(pegawaiHtml);
                    });
                } else {
                    $('#pegawai-list').append('<h2 class="text-secondary opacity-75 text-center">Pencarian Kosong</h2>');
                }
            }
        });
    });

    // Pegawai List click function
    $(document).on('click','.search-item', function() {
        // Update search item color
        $('.search-item').removeClass('btn-success').addClass('btn-outline-success');
        $(this).removeClass('btn-outline-success').addClass('btn-success');

        var nomor = $(this).data('nomor');
        
        // Update form fields
        $('#nomorWa').attr('placeholder', nomor);
        $('#nama_template').val('');
        $('#pesan').val('');
        $('#attachment').val('');
    });
});