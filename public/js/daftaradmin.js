// public/js/dashboard.js

$(document).ready(function() {
    if ($('#username').hasClass('is-invalid') || $('#password').hasClass('is-invalid')) {
        $('#tambahData').modal('show');
    }

    // Show Password
    $('#togglePassword').on('click', function() {
        let passwordField = $('#password');
        let passwordFieldType = passwordField.attr('type');
        
        if (passwordFieldType === 'password') {
            passwordField.attr('type', 'text');
            $('#reveal-password').removeClass('fa-regular').addClass('fa-solid');
        } else {
            passwordField.attr('type', 'password');
            $('#reveal-password').removeClass('fa-solid').addClass('fa-regular');
        }
    });

    if($('#password').hasClass('is-invalid')) {
        $('#togglePassword').removeClass('end-0 top-50').addClass('end-reveal top-reveal');
    }

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
                    data.forEach(admin => {
                        let adminHtml = `
                            <div class="col">
                                <div class="card">
                                    <div class="overflow-hidden rounded">
                                        <ul class="list-group list-group-flush">                
                                            <li class="list-group-item">
                                                <h4 class="card-title link-underline-dark link-offset-3 text-decoration-underline fw-bold">Nama Admin</h4>
                                                <h5 class="card-text fw-normal">${admin.username}</h5>
                                            </li>
                                            <li class="list-group-item">
                                                <h4 class="card-title link-underline-dark link-offset-3 text-decoration-underline fw-bold">Nomor WhatsApp</h4>
                                                <h5 class="card-text fw-normal"></h5>
                                            </li>
                                            <li class="list-group-item ">
                                                <a data-bs-toggle="modal" data-bs-target="#Hapus${admin.id}" class="btn btn-danger w-100"><i class="fa-solid fa-trash"></i> Hapus</a>
                                            </li>                                                
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="modal fade" id="Hapus${admin.id}" tabindex="-1" aria-labelledby="HapusLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="HapusLabel">Hapus Data</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body text-center">
                                            Apakah anda yakin ingin menghapus data ini?<br>
                                            <b>${admin.username}</b><br>
                                        </div>
                                        <div class="modal-footer">
                                            <form action="/hapusadmin/${admin.id}">
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
                        $('#pegawai-list').append(adminHtml);
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