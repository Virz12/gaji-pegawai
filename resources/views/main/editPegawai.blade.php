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
        @media screen and (min-width: 992px) {
            .w-lg-50 {
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
    <nav class="navbar navbar-expand-md bg-white shadow">
        <div class="container-fluid">
            <a class="navbar-brand text-success ms-2" href="#"><strong>Whatsapp Sender</strong></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
                <ul class="nav nav-underline ms-auto mb-2 mb-md-0 me-auto flex-column flex-md-row">
                    <li class="nav-item">
                        <a class="nav-link text-black d-inline-block" aria-current="page" href="/dashboard">Kirim Pesan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active fw-medium text-success d-inline-block" href="">Tambah Pegawai</a>
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
                            <li><a class="dropdown-item" href="/logout">Log Out</a></li>
                        </ul>
                    </span>                
                </div>
            </div>
        </div>
    </nav>
    {{-- Main Card --}}
    <main class="d-flex align-items-center justify-content-center" style="height: calc(100vh - 58px)">
        <div class="card p-3 w-75 w-lg-50 w-xxl-25">
            <h4 class="mb-3"><strong>Edit Pegawai</strong></h4>
            <form action="{{ route('main.updatepegawai', ['datapegawai' => $datapegawai]) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-floating mb-3">
                    <input type="number" value="{{$datapegawai->nip}}" name="nip" class="form-control border-2 @error('nip') is-invalid @enderror" id="nip" placeholder="" aria-label="nip" autocomplete="off" required>
                    <label for="nip">NIP<span class="text-danger">*</span></label>
                    @error('nip')
                        <div class="text-danger"><small>{{ $message }}</small></div>
                    @enderror
                </div>
                <div class="form-floating mb-3">
                    <input type="text" value="{{$datapegawai->nama}}" name="nama" class="form-control border-2 @error('nama') is-invalid @enderror" id="nama" placeholder="" aria-label="nama" autocomplete="off" required>
                    <label  for="nama">Nama Pegawai<span class="text-danger">*</span></label>
                    @error('nama')
                        <div class="text-danger"><small>{{ $message }}</small></div>
                    @enderror
                </div>
                <div class="form-floating mb-3">
                    <input type="number" value="{{$datapegawai->nomorWa}}" name="nomorWa" class="form-control border-2 @error('nomorWa') is-invalid @enderror" id="nomorWa" placeholder="" aria-label="nomorWa" autocomplete="off" required>
                    <label for="nomorWa">Nomor WhatsApp<span class="text-danger">*</span></label>
                    @error('nomorWa')
                        <div class="text-danger"><small>{{ $message }}</small></div>
                    @enderror
                </div>
                <div class="row">
                    <div class="col-6">
                        <a href="/dashboard"class="btn btn-secondary w-100">Kembali</a>
                    </div>
                    <div class="col-6">
                        <button type="submit" class="btn btn-success w-100">Ubah</button>
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