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
                return "Mencari...";
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
                            nama: item.nama,
                            nip: item.nip
                        };
                    })
                };
            },
            cache: true
        },
        templateResult: function(item) {
            if (item.loading) {
                return item.text;
            }
            return $(
                `<div>
                    <strong>${item.nama}</strong><br>
                    <small>NIP : ${item.nip}</small>
                </div>`
            );
        },
        templateSelection: function(item) {
            return item.nama || item.text;
        },
        escapeMarkup: function(markup) {
            return markup;
        }
    });

    // Search data
    $('#pegawai-list').on('select2:select', function(e) {
        const data = e.params.data;
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

                const foto = response.foto_pegawai;
                const kelamin = response.jenis_kelamin;

                if (foto) {
                    profilHtml = `<img class="rounded" src="${foto}" alt="Profile picture">`
                } else {
                    const backgroundColor = kelamin == 'Laki-laki' ? 'rgb(47, 196, 255)' : 'rgb(243, 173, 196)';
                    profilHtml = `
                        <label class="rounded " style="background-color:${backgroundColor}">
                            <i class="fa-solid fa-user  position-absolute top-50 start-50 translate-middle" style="font-size: 10rem;"></i>                                
                        </label>
                    `
                }
                
                $('#fotoPegawai').append(profilHtml);
                
                // Atur Textarea sesuai radio
                function updateTextarea() {
                    const selectedValue = $('input[name="waktu"]:checked').val();
                    const namaValue = $('#namaHidden').val();
                    $('#pesan').val('Selamat ' + selectedValue + ' ' + namaValue);
                }

                updateTextarea();
    
                $('input[name="waktu"]').on('change', updateTextarea);

                // Atur Waktu Saat Ini
                function setDefaultTime() {
                    const currentHour = new Date().getHours();
                    
                    let defaultId;
                    
                    if (currentHour >= 5 && currentHour < 12) {
                        defaultId = "pagi";
                    } else if (currentHour >= 12 && currentHour < 15) {
                        defaultId = "siang";
                    } else if (currentHour >= 15 && currentHour < 18) {
                        defaultId = "sore";
                    } else {
                        defaultId = "malam";
                    }
                    
                    // Set the default radio button
                    $('#' + defaultId).prop('checked', true);
                    
                    // Trigger the change event to update the textarea with the default value
                    $('#' + defaultId).trigger('change');
                }
            
                setDefaultTime();
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
        e.preventDefault();

        $(this).prop('disabled', true);

        var form = $('#whatsappForm')[0];
        var formData = new FormData(form);

        // Tipe Pesan
        let pesanType = $('input[name=options-outlined]:checked').attr('id');
        $('#pesan_type').val(pesanType);

        var xhr = new XMLHttpRequest();

        // Set up progress listener
        xhr.upload.addEventListener('progress', function(e) {
            if (e.lengthComputable) {
                $('#progress-container').show();

                var percentComplete = (e.loaded / e.total) * 100;
                $('#progress-bar').css('width', percentComplete + '%');

                if (percentComplete >= 100) {
                    // Ensure the progress bar stays at 100% for a minimum of 5 seconds
                    setTimeout(function() {
                        $('#progress-bar').css('width', '100%');
                    }, 3000);
            }
            }
        });

        // Handle form submission completion
        xhr.onload = function() {
            if (xhr.status === 200) {
                form.submit();
            }
        };

        // Handle network errors
        xhr.onerror = function() {
            alert('Network error.');
            $('#progress-bar').css('width', '0%'); // Reset progress bar
            $('#progress-container').hide(); // Hide progress bar

            $('#sendBtn').prop('disabled', false);
        };

        // Submit the form data using AJAX
        xhr.open('POST', $('#whatsappForm').attr('action'), true);
        xhr.send(formData);
    });
});