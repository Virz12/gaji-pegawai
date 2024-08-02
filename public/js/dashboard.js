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

    $('#templateSelect').change(function() {
        var selectedTemplate = $(this).val();
        $('#pesan').val(selectedTemplate);
    });
    
});

