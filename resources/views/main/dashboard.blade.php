<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="A dashboard for WhatsApp Sender">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{-- Bootstrap --}}
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    {{-- JQuery  --}}
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script>
        const search = "{{ route('main.dashboard') }}";
    </script>

    {{-- Custom CSS --}}
    <style>
        @media screen and (min-width: 576px) {
            .w-sm-auto {
                width: auto !important;
            }

            .rounded-sm-none {
                border-radius: 0 !important;
            }

            .rounded-sm-end {
                border-radius: 0 0.25rem 0.25rem 0 !important
            }
        }

        @media screen and (min-width: 992px) {
            .w-lg-25 {
                width: 25% !important;
            }
        }
    </style>
    <title>{{ config('app.name') }} | Dashboard</title>
</head>
<body class="min-vh-100 bg-body-secondary">
    {{-- NavBar --}}
    <nav class="navbar navbar-expand-md bg-white shadow">
        <div class="container-fluid">
            <a class="navbar-brand text-success ms-2" href="#"><strong>Whatsapp Sender</strong></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
                <ul class="nav nav-underline ms-auto mb-2 mb-md-0 me-auto flex-column flex-md-row">
                    <li class="nav-item">
                        <a class="nav-link active fw-medium text-success d-inline-block" aria-current="page" href="#">Kirim Pesan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-black d-inline-block" href="/tambahpegawai">Tambah Pegawai</a>
                    </li>
                </ul>
                <hr>
                <div class="d-md-flex justify-content-end me-2 mt-2 mt-md-0 mb-2 mb-md-0" style="width: 165px">
                    <span class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            {{ Auth::user()->username }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="/ubahpassword">Ubah Password</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="/logout">Log Out</a></li>
                        </ul>
                    </span>                
                </div>
            </div>
        </div>
    </nav>
    {{-- Main --}}
    <main class="row mx-2 mb-4 justify-content-between">
        {{-- Cari Pegawai --}}
        <section class="col-md-6 col-xxl-4 mt-3">
            <div class="card p-3">
                <h4 class="mb-3"><strong>Cari Pegawai</strong></h4>
                <form action="">
                    <div class="input-group mb-3">
                        <label class="input-group-text" for="search"><i class="fa-solid fa-magnifying-glass"></i></label>
                        <input type="text" class="form-control" placeholder="Nama Pegawai" aria-label="search" id="search" aria-describedby="search" autocomplete="off">
                    </div>
                </form>
                <div class="row g-2" id="pegawai-list">
                    {{-- <div class="btn btn-success rounded p-2 text-start"> 
                        
                    </div> --}}
                    <h2 class="text-secondary opacity-75 text-center">Pencarian Kosong</h2>
                </div>
            </div>
        </section>
        {{-- Buat Pesan --}}
        <section class="col-md-6 col-xxl-8 mt-4 mt-md-3">
            <div class="card p-3">
                <h4 class="mb-3"><strong>Buat Pesan</strong></h4>
                <form id="whatsappForm" action="{{route('main.whatsapp')}}" method="POST" enctype="multipart/form-data" data-save-template-url="{{ route('main.simpanTemplate') }}">
                    @csrf
                    @method('POST')
                    <div class="input-group mb-2">
                        <label class="input-group-text" for="nomor">Nomor Telepon</label>
                        <input class="form-control" id="nomor" type="number" placeholder="08354876892" disabled>
                    </div>
                    <div class="row g-2">
                        <div class="col-xl-10">
                            <div class="input-group">
                                <label class="input-group-text" for="nama_template">Template Text</label>
                                <input class="form-control rounded-end rounded-sm-none"  name="nama_template" id="nama_template" type="text"  placeholder="'NamaTemplate1'" autocomplete="off">                                
                                <button class="input-group-text dropdown-toggle w-100 w-sm-auto rounded rounded-sm-end mt-2 mt-sm-0" type="button"  data-bs-toggle="dropdown" aria-expanded="false">
                                    Pilih Template
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="templateSelectBtn">
                                    @forelse ($datatemplate as $template)
                                        <li class="d-flex justify-content-between">
                                            <a class="dropdown-item" href="#" data-value="{{ $template->pesan }}" data-name="{{ $template->nama_template }}">{{ $template->nama_template }}</a>
                                            <a class=" py-1 px-3" role="button" data-bs-toggle="modal" data-bs-target="#Hapus{{ $template->nama_template }}"><i class="fa-solid fa-trash-can fs-6 text-danger"></i></a>
                                        </li>
                                        <li><hr class="dropdown-divider"></li>
                                    @empty
                                        
                                    @endforelse
                                </ul>                                
                            </div>
                            @error('nama_template')
                                <div class="text-danger"><small>{{ $message }}</small></div>
                            @enderror
                        </div>
                        <div class="col-12 col-xl-2 mb-2" >
                            <button id="saveTemplateBtn" class="btn btn-success w-100">Simpan</button>
                        </div>
                    </div>
                    <div class="input-group mt-2">
                        <label class="input-group-text" for="pesan">Pesan</label>
                        <textarea class="form-control" name="pesan" id="pesan" style="resize: none; height: 150px"></textarea>                        
                    </div>
                    @error('pesan')
                        <div class="text-danger"><small>{{ $message }}</small></div>
                    @enderror
                    <div class="input-group mt-2">
                        <input class="form-control " type="file" name="attachment" id="attachment" aria-label="File Attachment">
                        
                        <input type="radio" class="btn-check" name="options-outlined" id="gambar" autocomplete="off" >
                        <label class="btn btn-outline-success" for="gambar">Gambar</label>
                        
                        <input type="radio" class="btn-check" name="options-outlined" id="dokumen" autocomplete="off">
                        <label class="btn btn-outline-success" for="dokumen">Dokumen</label>
                    </div>
                    @error('attachment')
                        <div class="text-danger"><small>{{ $message }}</small></div>
                    @enderror
                    <button type="submit" class="btn btn-success mt-2 w-50 w-lg-25"  id="sendBtn">Kirim</button>
                </form>
            </div>
        </section>
        {{-- Confirmation Modal --}}
        @forelse ( $datatemplate as $template)
            <div class="modal fade" id="Hapus{{ $template->nama_template }}" tabindex="-1" aria-labelledby="Hapus" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="Hapus">Hapus Data</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body text-center">
                            Apakah anda yakin ingin menghapus data ini?<br>
                            <b>{{ $template->nama_template }}</b>
                        </div>
                        <div class="modal-footer">
                            <form action="/hapustemplate/{{ $template->id }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Hapus</button>
                            </form>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kembali</button>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            
        @endforelse
    </main>
    <script src="{{ asset('js/dashboard.js') }}"></script>
    <script src="https://kit.fontawesome.com/e814145206.js" crossorigin="anonymous"></script>
</body>
</html>