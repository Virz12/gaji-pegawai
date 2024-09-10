
$(document).ready(function() {    
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
                                                <h4 class="card-title link-underline-dark link-offset-3 text-decoration-underline fw-bold">Role</h4>
                                                <h5 class="card-text fw-normal">${admin.role}</h5>
                                            </li>                                                                                          
                                        </ul>
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