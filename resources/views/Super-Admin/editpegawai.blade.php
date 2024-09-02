<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    {{-- Bootstrap --}}
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    {{-- JQuery  --}}
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

    {{-- Custom CSS --}}
    <style>
        @media screen and (min-width: 576px) {
            .h-card-edit {
                height: calc(100vh - 58px) !important;
            }

            .w-sm-100 {
                width: 100% !important;
            }
        }

        @media screen and (min-width: 768px) {
            .w-md-50 {
                width: 50% !important;
            }
        }

        @media screen and (min-width: 1400px) {
            .w-xxl-25 {
                width: 25% !important;
            }
        }

        /* Remove Arrow on Number Input */
        /* Chrome, Safari, Edge, Opera */
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        /* Firefox */
        input[type=number] {
            -moz-appearance: textfield;
        }
    </style>
    <title>{{ config('app.name') }} | Edit Pegawai</title>
</head>
<body class="min-vh-100 bg-body-secondary">
    {{-- NavBar --}}
    <nav class="navbar navbar-expand-lg bg-white shadow">
        <div class="container-fluid">
            <a class="navbar-brand text-success ms-2" href="#"><strong>Whatsapp Sender</strong></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
                <ul class="nav nav-underline ms-auto mb-2 mb-lg-0 me-auto flex-column flex-lg-row">
                    <li class="nav-item">
                        <a class="nav-link text-black d-inline-block" aria-current="page" href="/dashboard"><i class="fa-solid fa-comment"></i> Kirim Pesan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-black d-inline-block" href="/daftarpegawai"><i class="fa-solid fa-users"></i> Daftar Pegawai</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-black d-inline-block" href="/daftaradmin"><i class="fa-solid fa-user-tie"></i> Daftar Admin</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-black d-inline-block" href="/riwayatpesan"><i class="fa-solid fa-clock-rotate-left"></i> Riwayat Pesan</a>
                    </li>
                </ul>
                <hr>
                <div class="d-lg-flex justify-content-end me-2 mt-2 mt-lg-0 mb-2 mb-lg-0" style="width: 165px">
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
    {{-- Main Card --}}
    <main class="d-flex align-items-sm-center justify-content-center mt-3 mb-3 mb-sm-0 mt-sm-0 h-card-edit">
        <div class="card p-3 w-100 mx-3 w-md-50 w-xxl-25">
            <h4 class="mb-3"><strong>Edit Pegawai</strong></h4>
            <form action="{{ route('Super-Admin.updatepegawai', ['datapegawai' => $datapegawai]) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row mb-2 g-2 align-items-center">
                    <div class="col-12 col-sm-3 col-md-4 col-xl-3">
                        <div class="ratio ratio-1x1 w-50 w-sm-100 mx-auto">
                        @if (File::exists($datapegawai->foto_pegawai))                            
                            <img class="rounded  " src="{{ asset($datapegawai->foto_pegawai) }}" alt="Profile picture">                                                                                
                        @elseif ( $datapegawai->jenis_kelamin == 'Laki-laki' )                
                            <label class="rounded" style="background-color:rgb(47, 196, 255)">
                                <i class="fa-solid fa-user  position-absolute top-50 start-50 translate-middle" style="font-size: 5rem;"></i>
                            </label>
                        @elseif ( $datapegawai->jenis_kelamin == 'Perempuan' )
                            <label class="rounded " style="background-color:rgb(243, 173, 196)">
                                <i class="fa-solid fa-user  position-absolute top-50 start-50 translate-middle" style="font-size: 5rem;"></i>                                
                            </label>
                        @endif                    
                        </div>
                    </div>
                    <div class="col-12 col-sm-9 col-md-8 col-xl-9">                    
                        <div class="row">                        
                            <div class="input-group mb-3 mt-3">
                                <input class="form-control @error('foto_pegawai') is-invalid @enderror" type="file" accept="image/png, image/jpeg, image/jpg" name="foto_pegawai" id="foto_pegawai" aria-label="Foto Pegawai">
                                <label class="input-group-text" for="foto_pegawai">Foto Pegawai</label>
                            </div>
                                @error('foto_pegawai')
                                    <div class="text-danger"><small>{{ $message }}</small></div>
                                @enderror
                            <div class="form-floating ">
                                <input type="number" value="{{$datapegawai->nip}}" name="nip" class="form-control border-2 @error('nip') is-invalid @enderror" id="nip" placeholder="" aria-label="nip" autocomplete="off" required>
                                <label class="ms-2" for="nip">NIP<span class="text-danger ">*</span></label>
                                @error('nip')
                                    <div class="text-danger"><small>{{ $message }}</small></div>
                                @enderror
                            </div>
                        </div>
                    </div>                    
                </div>
                <div class="form-floating mb-3">
                    <input type="text" value="{{$datapegawai->nama}}" name="nama" class="form-control border-2 @error('nama') is-invalid @enderror" id="nama" placeholder="" aria-label="nama" autocomplete="off" required>
                    <label  for="nama">Nama Pegawai<span class="text-danger">*</span></label>
                    @error('nama')
                        <div class="text-danger"><small>{{ $message }}</small></div>
                    @enderror
                </div>
                <div class="form-floating mb-3">
                    <select name="jenis_kelamin" class="form-select border-2 @error('jenis_kelamin') is-invalid @enderror" id="jenis_kelamin" aria-label="jenis_kelamin" autocomplete="off" required>
                        <option value="{{ $datapegawai->jenis_kelamin }}" selected hidden>{{ $datapegawai->jenis_kelamin }}</option>
                        <option value="Laki-laki">Laki-laki</option>
                        <option value="Perempuan">Perempuan</option>
                    </select>
                    <label  for="jenis_kelamin">Pilih Jenis Kelamin<span class="text-danger">*</span></label>
                    @error('jenis_kelamin')
                        <div class="text-danger"><small>{{ $message }}</small></div>
                    @enderror
                </div>
                <div class="form-floating mb-3">
                    <input type="number" value="{{$datapegawai->nomorWa}}" name="nomorWa" class="form-control border-2 @error('nomorWa') is-invalid @enderror" id="nomorWa" placeholder="" aria-label="nomorWa" autocomplete="off" required>
                    <label for="nomorWa">Nomor WhatsApp<span class="text-danger">*</span></label>
                    <div class="text-sedondary opacity-75"><small>Awali nomor dengan angka 62.</small></div>
                    @error('nomorWa')
                        <div class="text-danger"><small>{{ $message }}</small></div>
                    @enderror
                </div>
                <div class="row">
                    <div class="col-6">
                        <a href="/daftarpegawai"class="btn btn-secondary w-100">Kembali</a>
                    </div>
                    <div class="col-6">
                        <a class="btn btn-success w-100" data-bs-toggle="modal" data-bs-target="#konfirmasiButton">Ubah</a>
                    </div>
                </div>
                {{-- Confirmation Modal --}}
                <div class="modal fade" id="konfirmasiButton" tabindex="-1" aria-labelledby="ubahLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="ubahLabel">Ubah Data Pegawai</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body text-center">
                                <strong>Apakah anda yakin ingin mengubah Data ini?</strong><br>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kembali</button>
                                <button type="submit" class="btn btn-success">Ubah</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </main>
    {{-- Script --}}
    <script src="{{ asset('js/phoneNumber.js') }}"></script>
    <script src="https://kit.fontawesome.com/e814145206.js" crossorigin="anonymous"></script>
</body>
</html>