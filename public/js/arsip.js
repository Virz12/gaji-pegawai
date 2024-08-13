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
                                                ${attachment ? `<span class="card-text fs-5">${attachment}</span>` : '-'}
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