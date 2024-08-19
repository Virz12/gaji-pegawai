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
        const dataPegawai = "{{ route('main.datapegawai') }}";
    </script>

    {{-- Select2 CSS --}}
    <link href="{{ asset('vendor/select2/css/select2.min.css') }}" rel="stylesheet" />

    {{-- Custom CSS --}}
    <style>
        .dropdown-menu-scrollable {
            max-height: 200px;
            overflow-y: auto;
        }
        
        .search-menu-scrollable {
            min-height: 300px;
            max-height: 300px;
            overflow-y: auto;
        }

        .h-49 {
            max-height: 49px;
        }

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
                        <a class="nav-link active fw-medium text-success d-inline-block" aria-current="page" href="#"><i class="fa-solid fa-comment"></i> Kirim Pesan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-black d-inline-block" href="/daftarpegawai"><i class="fa-solid fa-users"></i> Daftar Pegawai</a>
                    </li>
                </ul>
                <hr>
                <div class="d-md-flex justify-content-end me-2 mt-2 mt-md-0 mb-2 mb-md-0" style="width: 165px">
                    <span class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            {{ Auth::user()->username }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="/ubahpassword"><i class="fa-solid fa-lock me-2"></i> Ubah Password</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="/settings"><i class="fa-solid fa-gear me-2"></i> Settings</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="/logout"><i class="fa-solid fa-right-from-bracket me-2"></i> Log Out</a></li>
                        </ul>
                    </span>                
                </div>
            </div>
        </div>
    </nav>
    {{-- Main --}}
    <main class="row mx-2 mb-4 justify-content-center">

        {{-- Buat Pesan --}}
        <section class="col-md-8 col-xxl-8 mt-4 mt-md-3">
            <div class="card p-3">
                <h4 class="mb-3"><strong>Buat Pesan</strong></h4>
                <div class="mb-2">
                    <select class="w-100" id="pegawai-list">
                        <option></option>
                    </select>
                </div>
                <form id="whatsappForm" action="{{route('main.whatsapp')}}" method="POST" enctype="multipart/form-data" data-save-template-url="{{ route('main.simpanTemplate') }}">
                    @csrf
                    @method('POST')
                    <input type="hidden" id="nipHidden" name="nip" type="text" value="">
                    <input type="hidden" id="namaHidden" name="nama" type="text" value="">
                    <input type="hidden" id="nomorWaHidden" name="nomorWa" type="number" value="">
                    
                    <div class="row mb-2 g-2">
                        <div class="col-12 col-sm-3 col-md-4 col-lg-4 col-xl-3 col-xxl-2">
                            <div class="ratio ratio-1x1">
                                <img id="fotoPegawai" class="rounded" src="{{ asset($datapegawai->foto_pegawai) }}" alt="Profile picture">                    
                            </div>
                        </div>
                        <div class="col">
                            <div class="row h-100">
                                <div class="input-group mb-2">
                                    <label class="input-group-text" for="nama">Nama Pegawai</label>
                                    <input class="form-control @error('nama') is-invalid @enderror " id="nama" type="text" placeholder="-" disabled>
                                </div>
                                @error('nama')
                                    <div class="text-danger"><small>{{ $message }}</small></div>
                                @enderror
    
                                <div class="input-group mb-2">
                                    <label class="input-group-text" for="nip">NIP Pegawai</label>
                                    <input class="form-control @error('nip') is-invalid @enderror" id="nip" type="number" placeholder="-" disabled>
                                </div>
                                @error('nip')
                                    <div class="text-danger"><small>{{ $message }}</small></div>
                                @enderror
            
                                <div class="input-group">
                                    <label class="input-group-text" for="nomorWa">Nomor Telepon</label>
                                    <input class="form-control @error('nomorWa') is-invalid @enderror" id="nomorWa" type="number" placeholder="-" disabled>
                                </div>
                                @error('nomorWa')
                                    <div class="text-danger"><small>{{ $message }}</small></div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="text-success">
                        <hr>
                    </div>
                    <div class="row row-cols-2 row-cols-md-4 g-2 mb-2">
                        <div class="col">
                            <input type="radio" class="btn-check" name="waktu" id="pagi" value="pagi" checked autocomplete="off" >
                            <label class="btn btn-outline-success rounded w-100" for="pagi">Pagi</label>
                        </div>
                        <div class="col">
                            <input type="radio" class="btn-check" name="waktu" id="siang" value="siang" autocomplete="off" >
                            <label class="btn btn-outline-success rounded w-100" for="siang">Siang</label>
                        </div>
                        <div class="col">
                            <input type="radio" class="btn-check" name="waktu" id="sore" value="sore" autocomplete="off" >
                            <label class="btn btn-outline-success rounded w-100" for="sore">Sore</label>
                        </div>
                        <div class="col">
                            <input type="radio" class="btn-check" name="waktu" id="malam" value="malam" autocomplete="off" >
                            <label class="btn btn-outline-success rounded w-100" for="malam">Malam</label>
                        </div>
                    </div>
                    <div class="row g-2">
                        <div class="col-xl-9">
                            <div class="input-group">
                                <label class="input-group-text" for="nama_template">Template Text</label>
                                <input class="form-control rounded-end rounded-sm-none  @error('nama_template') is-invalid @enderror" name="nama_template" id="nama_template" type="text"  placeholder="'NamaTemplate1'" autocomplete="off">                                
                                <button class="input-group-text dropdown-toggle w-100 w-sm-auto rounded rounded-sm-end mt-2 mt-sm-0" type="button"  data-bs-toggle="dropdown" aria-expanded="false">
                                    Pilih Template
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-scrollable" aria-labelledby="templateSelectBtn">
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
                        <div class="col-12 col-xl-3" >
                            <button id="saveTemplateBtn" class="btn btn-success w-100"><i class="fa-solid fa-file-arrow-up"></i> Simpan</button>
                        </div>
                    </div>
                    <div class="input-group mt-2">
                        <label class="input-group-text" for="pesan">Pesan<span class="text-danger">*</span></label>
                        <textarea class="form-control @error('pesan') is-invalid @enderror" name="pesan" id="pesan" style="resize: none; height: 150px"></textarea>                        
                    </div>
                    @error('pesan')
                        <div class="text-danger"><small>{{ $message }}</small></div>
                    @enderror
                    <div class="input-group mt-2">
                        <label class="input-group-text" for="footer">Footer<span class="text-danger">*</span></label>
                        <textarea class="form-control @error('footer') is-invalid @enderror" name="footer" id="footer" style="resize: none; height: 40px"></textarea>                        
                    </div>
                    @error('footer')
                        <div class="text-danger"><small>{{ $message }}</small></div>
                    @enderror
                    <div class="input-group mt-2">
                        <label class="input-group-text" for="attachment" data-toggle="tooltip" data-placement="top" title="Lampiran"><i class="fa-solid fa-file-circle-plus"></i></label>
                        <input class="form-control @error('attachment') is-invalid @enderror" type="file" name="attachment" id="attachment" aria-label="File Attachment">
                        <div class="w-100 w-sm-auto mt-2 mt-sm-0 d-flex">
                            <input type="radio" class="btn-check" name="options-outlined" id="gambar" checked autocomplete="off" >
                            <label class="btn btn-outline-success flex-fill rounded-start-2 rounded-end-0 rounded-sm-none" for="gambar"><i class="fa-solid fa-image"></i> Gambar</label>
                            
                            <input type="radio" class="btn-check" name="options-outlined" id="dokumen" autocomplete="off">
                            <label class="btn btn-outline-success flex-fill rounded-start-0 rounded-end-2" for="dokumen"><i class="fa-solid fa-file"></i> Dokumen</label>
                        </div>
                    </div>
                    @error('attachment')
                        <div class="text-danger"><small>{{ $message }}</small></div>
                    @enderror
                    @error('pesan_type')
                        <div class="text-danger"><small>{{ $message }}</small></div>
                    @enderror
                    <input type="hidden" name="pesan_type" id="pesan_type" value="">

                    {{-- Progress Bar --}}
                    <div id="progress-container" style="display: none; margin-top: 10px;">
                        <div id="progress-bar" style="width: 0; height: 20px; background-color: #4caf50; transition: 1s;"></div>
                    </div>
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
                            <h1 class="modal-title fs-5" id="Hapus">Hapus Template</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body text-center">
                            Apakah anda yakin ingin menghapus Template ini?<br>
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
    {{-- Select2 Js --}}
    <script src="{{ asset('vendor/select2/js/select2.min.js') }}"></script>
    <script src="{{ asset('js/dashboard.js') }}"></script>
    <script src="https://kit.fontawesome.com/e814145206.js" crossorigin="anonymous"></script>
</body>
</html>