// public/js/phoneNumber.js
$(document).ready(function() {
    $('#nomorWa').on('input', function() {
        let phoneNumber = $(this).val();
        
        // Jika nomor dimulai dengan "0", hapus "0" tersebut
        if (phoneNumber.startsWith('0')) {
            phoneNumber = phoneNumber.substring(1);
        }

        // Tambahkan kode negara +62 di depan nomor
        if (!phoneNumber.startsWith('62')) {
            phoneNumber = '62' + phoneNumber;
        }

         // Jika setelah +62 masih ada angka 0 di depan nomor, hapus "0" tersebut
        if (phoneNumber.startsWith('620')) {
            phoneNumber = '62' + phoneNumber.substring(4);
        }

        $(this).val(phoneNumber);
    });
});