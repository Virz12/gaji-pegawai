// public/js/dashboard.js

$(document).ready(function() {
    // Select2
    $('#pegawai-list').select2({
        placeholder: "Cari Pegawai",
        language: {
            noResults : function() {
                return "Tidak ada hasil";
            },
            searching: function() {
                return "Mencari..."; // Customize searching text
            }
        },
        ajax: {
            url: search,
            dataType: 'json',
            delay: 100,
            data: function(params) {
                return {
                    query: params.term
                };
            },
            processResults: function(data) {
                return {
                    results: data.map(function(item) {
                        return {
                            id: item.id,
                            text: item.nama
                        };
                    })
                };
            },
            cache: true
        }
    });

    // Search data
    $('#pegawai-list').on('select2:select', function(e) {
        var data = e.params.data;
        $.ajax({
            url: dataPegawai,
            type: 'GET',
            data: { id: data.id },
            success: function(response) {
                $('#nipHidden').val(response.nip);
                $('#namaHidden').val(response.nama);
                $('#nomorWaHidden').val(response.nomorWa);

                $('#nama').val(response.nama).prop('disabled', true);
                $('#nip').val(response.nip).prop('disabled', true);
                $('#nomorWa').val(response.nomorWa).prop('disabled', true);

                $('#fotoPegawai').attr('src', response.foto_pegawai);
            }
        });
    });

    $('#saveTemplateBtn').on('click', function(e) {
        e.preventDefault(); // Prevent default form submission
        let saveTemplateUrl = $('#whatsappForm').data('save-template-url');
        $('#whatsappForm').attr('action', saveTemplateUrl);
        $('#whatsappForm').submit();
    });

    $('#templateSelectBtn').dropdown();
    
    $('.dropdown-item').on('click', function() {
        var selectedTemplate = $(this).data('value');
        var templateName = $(this).data('name');
        $('#pesan').val(selectedTemplate);
        $('#nama_template').val(templateName);
    });

    $('[data-toggle="tooltip"]').tooltip();

    // Progress Bar
    $('#sendBtn').on('click', function(e) {
        e.preventDefault(); // Prevent the default form submission

        var form = $('#whatsappForm')[0]; // Get the form element
        var formData = new FormData(form);

        // Tipe Pesan
        let pesanType = $('input[name=options-outlined]:checked').attr('id');
        $('#pesan_type').val(pesanType);

        var xhr = new XMLHttpRequest();

        // Set up progress listener
        xhr.upload.addEventListener('progress', function(e) {
            if (e.lengthComputable) {
                $('#progress-container').show();
            }
        });

        // Handle form submission completion
        xhr.onload = function() {
            if (xhr.status === 200) {
                // Simulate a delay before actually submitting the form
                var delay = 5000; // 5 seconds
                var startTime = Date.now();
                var interval = setInterval(function() {
                    var elapsedTime = Date.now() - startTime;
                    var progress = Math.min(100, (elapsedTime / delay) * 100);
    
                    $('#progress-bar').css('width', progress + '%');
    
                    if (progress >= 100) {
                        clearInterval(interval);
                        setTimeout(function() {
                            form.submit();
                        }, 0); // Immediately submit the form after the progress completes
                    }
                }, 50); // Update the progress bar every 50ms
                
            }
        };

        // Handle network errors
        xhr.onerror = function() {
            alert('Network error.');
            $('#progress-bar').css('width', '0%'); // Reset progress bar
            $('#progress-container').hide(); // Hide progress bar
        };

        // Submit the form data using AJAX
        xhr.open('POST', $('#whatsappForm').attr('action'), true);
        xhr.send(formData);
    });
});