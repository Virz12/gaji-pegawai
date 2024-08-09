// public/js/dashboard.js

$(document).ready(function() {
    // Live Search
    $(document).on('keyup', '#search' , function() {
        let query = $(this).val();

        $.ajax({
            url: search,
            type: "GET",
            data: { 'query': query },
            success: function(data) {
                $('#arsip-list').empty();
                if (data.length > 0) {
                    data.forEach(arsip => {
                        let arsipHtml = `
                            <div class="col-12 col-sm-6 col-lg-4 col-xxl-3">
                                <div class="card">
                                    <h5 class="card-header">${arsip.created_at}</h5>
                                    <div class="overflow-hidden rounded">
                                        <ul class="list-group list-group-flush">
                                            <li class="list-group-item">
                                                <h4 class="card-title link-underline-dark link-offset-3 text-decoration-underline fw-bold"><i class="fa-solid fa-user text-decoration-underline"></i> Nama Pegawai</h4>
                                                <span class="card-text fs-5">${arsip.nama}</span>
                                            </li>
                                            <li class="list-group-item">
                                                <h4 class="card-title link-underline-dark link-offset-3 text-decoration-underline fw-bold"><i class="fa-solid fa-envelope text-decoration-underline"></i> Pesan</h4>
                                                <p class="card-text fs-6">${arsip.pesan}</p>
                                            </li>
                                            <li class="list-group-item">
                                                <h4 class="card-title link-underline-dark link-offset-3 text-decoration-underline fw-bold"><i class="fa-solid fa-file text-decoration-underline"></i> File</h4>
                                                <span class="card-text fs-5">${arsip.attachment}</span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        `;
                        $('#arsip-list').append(arsipHtml);
                    });
                } else {
                    $('#arsip-list').append('<h2 class="text-secondary opacity-75 text-center">Arsip Kosong</h2>');
                }
            }
        });
    });
});