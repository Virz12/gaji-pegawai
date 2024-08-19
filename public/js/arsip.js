// public/js/dashboard.js

$(document).ready(function() {
    // Fetch Data Pegawai
    function fetchData(query = '', page = 1) {

        $.ajax({
            url: search,
            type: "GET",
            data: { query: query, page: page },
            success: function(response) {
                $('#arsip-list').empty();
                let data = response.data || [];

                if (data.length > 0) {
                    data.forEach(arsip => {
                        let createdAt = new Date(arsip.created_at);
                        let options = { timeZone: 'Asia/Jakarta', year: 'numeric', month: 'numeric', day: 'numeric', hour: '2-digit', minute: '2-digit', second: '2-digit' };
                        let formatDate = createdAt.toLocaleString('en-GB', options);
                        let [date, time] = formatDate.split(', ');

                        let attachment = arsip.attachment;

                        let arsipHtml = `
                            <div class="col-12 col-sm-6 col-lg-4 col-xxl-3">
                                <div class="card">
                                    <h5 class="card-header d-flex justify-content-between"><span><i class="fa-solid fa-calendar"></i> ${date}</span><span><i class="fa-solid fa-clock"></i> ${time}</span></h5>
                                    <div class="overflow-hidden rounded">
                                        <ul class="list-group list-group-flush">                                            
                                            <li class="list-group-item">
                                                <h4 class="card-title link-underline-dark link-offset-3 text-decoration-underline fw-bold"><i class="fa-solid fa-envelope text-decoration-underline"></i> Pesan</h4>
                                                <p class="card-text fs-6">${arsip.pesan}</p>
                                            </li>
                                            <li class="list-group-item">
                                                <h4 class="card-title link-underline-dark link-offset-3 text-decoration-underline fw-bold"><i class="fa-solid fa-file text-decoration-underline"></i> File</h4>
                                                ${attachment ? `<a data-bs-toggle="modal" data-bs-target="#Download${attachment}"  class="btn btn-primary">${attachment} Download</a>` : '-'}
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>                            
                            <div class="modal fade" id="Download${attachment}" tabindex="-1" aria-labelledby="DownloadLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="DownlaodLabel">Download File</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body text-center">
                                            Apakah anda yakin ingin donlot data ini?<br>
                                            <b> --</b>
                                        </div>
                                        <div class="modal-footer">
                                            <a href="{{ route('file.download', $arsip->attachment) }}" class="btn btn-primary">Download</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `;
                        $('#arsip-list').append(arsipHtml);
                    });

                    $('#pagination-links').html(response.pagination);
                } else {
                    $('#arsip-list').append('<h2 class="text-secondary opacity-75 text-center">Arsip Kosong</h2>');
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