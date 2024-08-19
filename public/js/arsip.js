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
                        let downloadUrl = downloadUrlTemplate.replace('__PLACEHOLDER__', arsip.id);

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
                                                ${attachment ? `
                                                <span class="card-text fs-5">${attachment}</span>
                                                <div class="d-flex justify-content-between mt-1">
                                                    <a class="btn btn-primary w-75 me-1"  data-bs-toggle="modal" data-bs-target="#Preview${attachment}"><i class="fa-solid fa-eye"></i> Preview</a>
                                                    <a href="${downloadUrl}"  class="btn btn-success w-25 ms-1"><i class="fa-solid fa-circle-down "></i> Unduh</a>
                                                </div>` : 
                                                '<span class="card-text fs-5">-</span>'}
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        `;

                        if (attachment) {
                            let extension = attachment.split('.').pop().toLowerCase(); // Get file extension
                            let filePath = `/attachments/${attachment}`; // Assuming this is the path

                            // Determine modal content based on file extension
                            let modalContent = '';

                            if (['jpg', 'jpeg', 'png'].includes(extension)) {
                                modalContent = `<img src="${filePath}" alt="Image" class="img-fluid">`;
                            } else if (extension === 'pdf') {
                                modalContent = `<embed src="${filePath}#page=1" type="application/pdf" width="100%" height="500px" />`;
                            } else if (extension === 'txt') {
                                modalContent = `<iframe src="${filePath}" width="100%" height="500px"></iframe>`;
                            } else if (['doc', 'docx', 'ppt', 'pptx', 'xls', 'xlsx'].includes(extension)) {
                                modalContent = `<iframe src="https://view.officeapps.live.com/op/embed.aspx?src=${encodeURIComponent(filePath)}&page=1" width="100%" height="500px"></iframe>`;
                            } else {
                                modalContent = '<p>Preview tidak tersedia untuk file ini.</p>';
                            }

                            let modalHtml = `
                                <div class="modal fade" id="Preview${attachment}" tabindex="-1" aria-labelledby="PreviewLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="PreviewLabel">${attachment}</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body text-center">
                                                ${modalContent}
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kembali</button>                        
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            `;
                            // Append modal to the page
                            $('#arsip-list').append(modalHtml);
                        }

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