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
                $('#pegawai-list').empty();
                if (data.length > 0) {
                    data.forEach(pegawai => {
                        let createdAt = new Date(pegawai.created_at);
                        let options = { timeZone: 'Asia/Jakarta', year: 'numeric', month: 'numeric', day: 'numeric', hour: '2-digit', minute: '2-digit', second: '2-digit' };
                        let formatDate = createdAt.toLocaleString('en-GB', options);
                        let [date, time] = formatDate.split(', ');

                        let pegawaiHtml = `
                            <div class="col">
                                <div class="card">
                                    <h5 class="card-header d-flex justify-content-between"><span><i class="fa-solid fa-calendar"></i> ${date}</span><span><i class="fa-solid fa-clock"></i> ${time}</span></h5>
                                    <div class="overflow-hidden rounded">
                                        <ul class="list-group list-group-flush">                
                                            <li class="list-group-item">
                                                <h4 class="card-title link-underline-dark link-offset-3 text-decoration-underline fw-bold"><i class="fa-solid fa-envelope text-decoration-underline"></i> Nama Pegawai</h4>
                                                <h5 class="card-text fw-normal">${pegawai.nama}</h5>
                                            </li>
                                            <li class="list-group-item">
                                                <h4 class="card-title link-underline-dark link-offset-3 text-decoration-underline fw-bold"><i class="fa-solid fa-file text-decoration-underline"></i> NIP</h4>
                                                <h5 class="card-text fw-normal">${pegawai.nip}</h5>
                                            </li>
                                            <li class="list-group-item">
                                                <h4 class="card-title link-underline-dark link-offset-3 text-decoration-underline fw-bold"><i class="fa-solid fa-file text-decoration-underline"></i> Nomor Whatsapp</h4>
                                                <h5 class="card-text fw-normal">${pegawai.nomorWa}</h5>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        `;
                        $('#pegawai-list').append(pegawaiHtml);
                    });
                } else {
                    $('#pegawai-list').append('<h2 class="m-auto text-secondary opacity-75 text-center">Data Kosong</h2>');
                }
            }
        });
    });
});