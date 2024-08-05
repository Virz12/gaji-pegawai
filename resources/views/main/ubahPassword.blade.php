<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    {{-- Bootstrap --}}
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    
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
    </style>
    <title>{{ config('app.name') }} | Ubah Password</title>
</head>
<body class="min-vh-100 overflow-hidden bg-body-secondary">
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
                        <a class="nav-link text-black d-inline-block" href="/dashboard">Kirim Pesan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-black d-inline-block" href="#">Tambah Pegawai</a>
                    </li>
                </ul>
                <hr>
                <div class="d-md-flex justify-content-end me-2 mt-2 mt-md-0 mb-2 mb-md-0" style="width: 165px">
                    <span class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            {{ Auth::user()->username }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">                           
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
            <h4 class="mb-3"><strong>Ubah Password</strong></h4>
            <form action="{{route('main.updatepassword')}}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-floating mb-3">
                    <input type="password" name="passwordSekarang" class="form-control border-2 @error('passwordSekarang') is-invalid @enderror" id="passwordSekarang" placeholder="" aria-label="passwordSekarang" required>
                    <label for="passwordSekarang">Password Sekarang<span class="text-danger">*</span></label>
                    @error('passwordSekarang')
                        <div class="text-danger"><small>{{ $message }}</small></div>
                    @enderror
                </div>
                <div class="form-floating mb-3">
                    <input type="password" name="password" class="form-control border-2 @error('password') is-invalid @enderror" id="passwordBaru" placeholder="" aria-label="passwordBaru" required>
                    <label  for="passwordBaru">Password Baru<span class="text-danger">*</span></label>
                    @error('password')
                        <div class="text-danger"><small>{{ $message }}</small></div>
                    @enderror
                </div>
                <div class="form-floating mb-3">
                    <input type="password" name="passwordKonfirmasi" class="form-control border-2 @error('passwordKonfirmasi') is-invalid @enderror" id="passwordKonfirmasi" placeholder="" aria-label="passwordKonfirmasi" required>
                    <label for="passwordKonfirmasi">Konfirmasi Password<span class="text-danger">*</span></label>
                    @error('passwordKonfirmasi')
                        <div class="text-danger"><small>{{ $message }}</small></div>
                    @enderror
                </div>
                <div class="row">
                    <div class="col-6">
                        <a href="/dashboard"class="btn btn-secondary w-100">Kembali</a>
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
                                <h1 class="modal-title fs-5" id="ubahLabel">Ubah Password</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body text-center">
                                <strong>Apakah anda yakin ingin mengubah Password?</strong><br>
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
    <script src="https://kit.fontawesome.com/e814145206.js" crossorigin="anonymous"></script>
</body>
</html>