// public/js/dashboard.js

$(document).ready(function() {
    if ($('#username').hasClass('is-invalid') || $('#password').hasClass('is-invalid')) {
        $('#tambahData').modal('show');
    }

    // Show Password
    $(document).on('click', '.toggle-password-icon', function() {
        let passwordField = $(this).siblings('.form-control');
        let passwordFieldType = passwordField.attr('type');
        
        if (passwordFieldType === 'password') {
            passwordField.attr('type', 'text');
            $(this).children('.fa-eye').removeClass('fa-regular').addClass('fa-solid');
        } else {
            passwordField.attr('type', 'password');
            $(this).children('.fa-eye').removeClass('fa-solid').addClass('fa-regular');
        }
    });

    $('.form-control').each(function() {
        if($(this).hasClass('is-invalid')) {
            $(this).siblings('.toggle-password-icon').removeClass('end-0 top-50').addClass('end-reveal top-reveal');
        }
    })

    

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
                        let status = admin.status;
                        let aktifHtml = '';
                        let nonaktifHtml = '';

                        if ( status === 'Aktif' ){
                            aktifHtml = `<button class="btn fw-normal  rounded-pill btn-success fs-6 w-50 me-1" >Aktif</button>`;
                        } else {
                            aktifHtml = `<a href="/aktif/${admin.id }" class="text-decoration-none  w-50">
                                            <button type="submit" class=" btn fw-normal  rounded-pill btn-outline-success fs-6 w-100 me-1">Aktif</button></a>`;
                        }
                        if ( status === 'Nonaktif' ){
                            nonaktifHtml = `<button type="submit" class="btn fw-normal  rounded-pill btn-danger fs-6 w-50 ms-1" >Nonaktif</button>`;
                        } else {
                            nonaktifHtml = `<a href="/nonaktif/${admin.id }" class="text-decoration-none w-50">
                                                    <button type="submit" class=" btn fw-normal  rounded-pill btn-outline-danger fs-6 w-100 ms-1">Nonaktif</button></a>`;
                        }


                        let adminHtml = `
                            <div class="col">
                                <div class="card">
                                    <div class="overflow-hidden rounded">
                                        <ul class="list-group list-group-flush">
                                            <div class="d-flex justify-content-end pt-2 pe-2">
                                                <a  href="/editadmin/${admin.id}" class="btn btn-warning w-15 " ><i class="fa-solid fa-pencil text-white"></i></a>
                                                <a data-bs-toggle="modal" data-bs-target="#Hapus${admin.id}" class="btn btn-danger w-15  ms-1"><i class="fa-solid fa-trash"></i></a>
                                            </div>                   
                                            <li class="list-group-item">
                                                <h4 class="card-title link-underline-dark link-offset-3 text-decoration-underline fw-bold">Nama Admin</h4>
                                                <h5 class="card-text fw-normal">${admin.username}</h5>
                                            </li>
                                            <li class="list-group-item">
                                                <h4 class="card-title link-underline-dark link-offset-3 text-decoration-underline fw-bold">Role</h4>
                                                <h5 class="card-text fw-normal">${admin.role}</h5>
                                            </li>
                                            <li class="list-group-item ">
                                                <h4 class="card-title link-underline-dark link-offset-3 text-decoration-underline fw-bold">Status</h4>
                                                <div class="d-flex justify-content-between mt-3">
                                                ${aktifHtml}
                                                ${nonaktifHtml}
                                                </div>
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