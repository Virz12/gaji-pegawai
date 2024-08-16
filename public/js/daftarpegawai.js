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
                        let pegawaiHtml = `
                            <div class="col">
                                <div class="card">
                                    <span class="card-header p-lg-5 p-5">
                                    @if (File::exists($pegawai->foto_pegawai))
                                        <div class="ratio ratio-1x1 ">
                                            <img class="rounded  " src="{{ asset($pegawai->foto_pegawai) }}" alt="Profile picture">                                                    
                                        </div>
                                    @else
                                        <div class="ratio ratio-1x1 ">
                                            <label class="rounded ">
                                                <i class="fa-solid fa-image fs-1 position-absolute top-50 start-50 translate-middle"></i>
                                            </label>
                                        </div>
                                    @endif
                                    </span>
                                    <div class="overflow-hidden rounded">
                                        <ul class="list-group list-group-flush">                
                                            <li class="list-group-item">
                                                <h4 class="card-title link-underline-dark link-offset-3 text-decoration-underline fw-bold"><i class="fa-solid fa-envelope text-decoration-underline"></i> Nama Pegawai</h4>
                                                <h5 class="card-text fw-normal">${pegawai.nama}</h5>
                                            </li>
                                            <li class="list-group-item">
                                                <h4 class="card-title link-underline-dark link-offset-3 text-decoration-underline fw-bold"><i class="fa-solid fa-file text-decoration-underline"></i> NIP</h4>
                                                <h5 class="card-text fw-normal">${$pegawai.nip}</h5>
                                            </li>
                                            <li class="list-group-item">
                                                <h4 class="card-title link-underline-dark link-offset-3 text-decoration-underline fw-bold"><i class="fa-solid fa-envelope text-decoration-underline"></i> Nama Pegawai</h4>
                                                <h5 class="card-text fw-normal">${pegawai.jenis_kelamin}</h5>
                                            </li>
                                            <li class="list-group-item">
                                                <h4 class="card-title link-underline-dark link-offset-3 text-decoration-underline fw-bold"><i class="fa-solid fa-file text-decoration-underline"></i> Nomor Whatsapp</h4>
                                                <h5 class="card-text fw-normal">${pegawai.nomorWa}</h5>
                                            </li>
                                            <li class="list-group-item ">
                                                <div class="d-flex justify-content-between ">
                                                    <a href="{{route('main.editpegawai',['datapegawai' => $pegawai])}}" class="btn btn-primary w-50 me-1"><i class="fa-solid fa-pen-to-square"></i> Edit</a>
                                                    <a data-bs-toggle="modal" data-bs-target="#Hapus{{ $pegawai->nip }}" class="btn btn-danger w-50 ms-1"><i class="fa-solid fa-trash"></i> Hapus</a>
                                                </div>
                                                <a href="{{route('main.arsip',['datapegawai' => $pegawai])}}" class="btn btn-warning w-100 mt-2"><i class="fa-solid fa-message"></i> Arsip Pesan</a>
                                            </li>                                                
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            {{-- Confirmation Modal --}}
                            <div class="modal fade" id="Hapus{{ $pegawai->nip }}" tabindex="-1" aria-labelledby="HapusLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="HapusLabel">Hapus Data</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body text-center">
                                            Apakah anda yakin ingin menghapus data ini?<br>
                                            <b>{{ $pegawai->nama }}</b>
                                        </div>
                                        <div class="modal-footer">
                                            <form action="/hapuspegawai/{{ $pegawai->id }}">
                                            <form action="{{route('main.delete',['datapegawai' => $pegawai])}}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">Hapus</button>
                                            </form>
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kembali</button>
                                        </div>
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