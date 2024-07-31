<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    {{-- Bootstrap --}}
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <title>{{ config('app.name') }} | Dashboard</title>

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
                    <li class="nav-item">
                        <a class="nav-link text-black d-inline-block" href="#">Arsip Pesan</a>
                    </li>
                </ul>
                <hr>
                <div class="d-md-flex justify-content-end me-2 mt-2 mt-md-0 mb-2 mb-md-0" style="width: 176px">
                    <span class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Sang Admin
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="#">Ubah Password</a></li>
                            <li><a class="dropdown-item" href="/logout">Log Out</a></li>
                        </ul>
                    </span>                
                </div>
            </div>
        </div>
    </nav>
    <div class="d-flex align-items-center justify-content-center" style="height: calc(100vh - 58px)">
        <div class="card p-3 w-75 w-lg-50 w-xxl-25">
            <h4 class="mb-3"><strong>Ubah Password</strong></h4>
            <form action="">
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="passwordSekarang" placeholder="" aria-label="passwordSekarang">
                    <label for="passwordSekarang">Password Sekarang</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="passwordBaru" placeholder="" aria-label="passwordBaru">
                    <label  for="passwordBaru">Password Baru</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="passwordKonfirmasi" placeholder="" aria-label="passwordKonfirmasi">
                    <label for="passwordKonfirmasi">Konfirmasi Password</label>
                </div>
                <div class="row">
                    <div class="col-6">
                        <a href=""><button type="submit" class="btn btn-secondary w-100">Kembali</button></a>
                    </div>
                    <div class="col-6">
                        <button type="submit" class="btn btn-success w-100">Ubah</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script src="https://kit.fontawesome.com/e814145206.js" crossorigin="anonymous"></script>
</body>
</html>