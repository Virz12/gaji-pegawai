// public/js/custom.js

$(document).ready(function() {
    $('#saveTemplateBtn').on('click', function(e) {
        e.preventDefault(); // Prevent default form submission
        let saveTemplateUrl = $('#whatsappForm').data('save-template-url');
        $('#whatsappForm').attr('action', saveTemplateUrl);
        $('#whatsappForm').submit();
    });

    $('#sendBtn').on('click', function() {
        $('#whatsappForm').attr('action');
    });

    $('#templateSelectBtn').dropdown();
    
    $('.dropdown-item').on('click', function() {
        var selectedTemplate = $(this).data('value');
        var templateName = $(this).data('name');
        $('#pesan').val(selectedTemplate);
        $('#nama_template').val(templateName);
    });
    

});

