// public/js/dashboard.js

$(document).ready(function() {
    // Fetch Data Pegawai
    function fetchData(query = '', page = 1) {
        
        $.ajax({
            url: search,
            type: "GET",
            data: { query: query, page: page },
            success: function(response) {
                $('#pegawai-list').empty();
                let data = response.data || [];

                if (data.length > 0) {
                    data.forEach(pegawai => {
                        let foto_pegawai = pegawai.foto_pegawai;
                        let jenis_kelamin = pegawai.jenis_kelamin;
                        let imgHtml = '';
                
                        if (foto_pegawai && foto_pegawai !== '') {
                            imgHtml = `<img class="rounded" src="/${foto_pegawai}" alt="Profile picture">`;
                        } else if (jenis_kelamin === 'Laki-laki') {
                            imgHtml = `
                                <label class="rounded" style="background-color:rgb(47, 196, 255)">
                                    <i class="fa-solid fa-user position-absolute top-50 start-50 translate-middle" style="font-size: 10rem;"></i>
                                </label>`;
                        } else if (jenis_kelamin === 'Perempuan') {
                            imgHtml = `
                                <label class="rounded" style="background-color:rgb(243, 173, 196)">
                                    <i class="fa-solid fa-user position-absolute top-50 start-50 translate-middle" style="font-size: 10rem;"></i>
                                </label>`;
                        }

                        let pegawaiHtml = `
                            <div class="col">
                                <div class="card">
                                    <span class="card-header p-lg-5 p-5">
                                        <div class="ratio ratio-1x1 ">
                                        ${imgHtml}
                                        </div>
                                    </span>
                                    <div class="overflow-hidden rounded">
                                        <ul class="list-group list-group-flush">                
                                            <li class="list-group-item">
                                                <h4 class="card-title link-underline-dark link-offset-3 text-decoration-underline fw-bold">Nama Pegawai</h4>
                                                <h5 class="card-text fw-normal">${pegawai.nama}</h5>
                                            </li>
                                            <li class="list-group-item">
                                                <h4 class="card-title link-underline-dark link-offset-3 text-decoration-underline fw-bold">NIP</h4>
                                                <h5 class="card-text fw-normal">${pegawai.nip}</h5>
                                            </li>
                                            <li class="list-group-item">
                                                <h4 class="card-title link-underline-dark link-offset-3 text-decoration-underline fw-bold">Jenis Kelamin</h4>
                                                <h5 class="card-text fw-normal">${pegawai.jenis_kelamin}</h5>
                                            </li>
                                            <li class="list-group-item">
                                                <h4 class="card-title link-underline-dark link-offset-3 text-decoration-underline fw-bold">Nomor Whatsapp</h4>
                                                <h5 class="card-text fw-normal">${pegawai.nomorWa}</h5>
                                            </li>
                                            <li class="list-group-item ">
                                                <div class="d-flex justify-content-between ">
                                                    <a href="/editpegawai/${pegawai.id}" class="btn btn-primary w-50 me-1"><i class="fa-solid fa-pen-to-square"></i> Edit</a>
                                                    <a data-bs-toggle="modal" data-bs-target="#Hapus${pegawai.nip}" class="btn btn-danger w-50 ms-1"><i class="fa-solid fa-trash"></i> Hapus</a>
                                                </div>
                                                <a href="/arsip/${pegawai.id}" class="btn btn-warning w-100 mt-2"><i class="fa-solid fa-message"></i> Arsip Pesan</a>
                                            </li>                                                
                                        </ul>
                                    </div>
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
                                            <b>${pegawai.nama}</b><br>
                                            <b>[NIP : ${pegawai.nip}]</b>
                                        </div>
                                        <div class="modal-footer">
                                            <form action="/hapuspegawai/${pegawai.id}">
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

                    $('#pagination-links').html(response.pagination);
                } else {
                    $('#pegawai-list').append('<h2 class="m-auto text-secondary opacity-75 text-center">Data Kosong</h2>');
                }
            }
        });
    }

    // Initial fetch
    fetchData();

    // Live Search
    $(document).on('keyup', '#search', function() {
        let query = $(this).val();
        fetchData(query);
    });

    // Handle pagination click
    $(document).on('click', '#pagination-links a', function(e) {
        e.preventDefault();
        let page = $(this).attr('href').split('page=')[1];
        let query = $('#search').val();
        fetchData(query, page);
    });
});