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
    
    <title>{{ config('app.name') }} | Arsip Pesan</title>
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
                        <a class="nav-link text-black d-inline-block" href="/dashboard">Kirim Pesan</a>
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
    <main class="container-fluid ps-3 my-4">
        <section class="row g-2 justify-content-between">
            <a href="/dashboard" class="btn btn-success mb-sm-3 ms-1 col-auto"><i class="fa-solid fa-arrow-left me-2"></i>Kembali</a>
            <form action="" class="col-12 col-sm-auto">
                <div class="input-group mb-3">
                    <label class="input-group-text shadow-sm" for="search"><i class="fa-solid fa-magnifying-glass"></i></label>
                    <input type="text" class="form-control shadow-sm" placeholder="Nama Pegawai" aria-label="search" id="search" aria-describedby="search">
                </div>
            </form>
        </section>
        <section class="row g-3">
            {{-- Card --}}
            <div class="col-12 col-sm-6 col-lg-4 col-xxl-3">
                <div class="card">
                    <h5 class="card-header">05/08/2024 - Senin</h5>
                    <div class="overflow-hidden rounded">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                <h4 class="card-title link-underline-dark link-offset-3 text-decoration-underline fw-bold"><i class="fa-solid fa-user text-decoration-underline"></i> Nama Pegawai</h4>
                                <span class="card-text fs-5">Asep Garong</span>
                            </li>
                            <li class="list-group-item">
                                <h4 class="card-title link-underline-dark link-offset-3 text-decoration-underline fw-bold"><i class="fa-solid fa-envelope text-decoration-underline"></i> Pesan</h4>
                                <p class="card-text fs-6">Lorem ipsum dolor sit amet consectetur, adipisicing elit. Nihil eaque ad officia voluptatum aut. Asperiores voluptates molestiae dolorum laudantium sunt.</p>
                            </li>
                            <li class="list-group-item">
                                <h4 class="card-title link-underline-dark link-offset-3 text-decoration-underline fw-bold"><i class="fa-solid fa-file text-decoration-underline"></i> File</h4>
                                <span class="card-text fs-5">Elden-Ring-DE-SteamRIP.com.rar</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-lg-4 col-xxl-3">
                <div class="card">
                    <h5 class="card-header">05/08/2024 - Senin</h5>
                    <div class="overflow-hidden rounded">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                <h4 class="card-title link-underline-dark link-offset-3 text-decoration-underline fw-bold"><i class="fa-solid fa-user text-decoration-underline"></i> Nama Pegawai</h4>
                                <span class="card-text fs-5">Asep Garong</span>
                            </li>
                            <li class="list-group-item">
                                <h4 class="card-title link-underline-dark link-offset-3 text-decoration-underline fw-bold"><i class="fa-solid fa-envelope text-decoration-underline"></i> Pesan</h4>
                                <p class="card-text fs-6">Lorem ipsum dolor sit amet consectetur, adipisicing elit. Nihil eaque ad officia voluptatum aut. Asperiores voluptates molestiae dolorum laudantium sunt.</p>
                            </li>
                            <li class="list-group-item">
                                <h4 class="card-title link-underline-dark link-offset-3 text-decoration-underline fw-bold"><i class="fa-solid fa-file text-decoration-underline"></i> File</h4>
                                <span class="card-text fs-5">Elden-Ring-DE-SteamRIP.com.rar</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-lg-4 col-xxl-3">
                <div class="card">
                    <h5 class="card-header">05/08/2024 - Senin</h5>
                    <div class="overflow-hidden rounded">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                <h4 class="card-title link-underline-dark link-offset-3 text-decoration-underline fw-bold"><i class="fa-solid fa-user text-decoration-underline"></i> Nama Pegawai</h4>
                                <span class="card-text fs-5">Asep Garong</span>
                            </li>
                            <li class="list-group-item">
                                <h4 class="card-title link-underline-dark link-offset-3 text-decoration-underline fw-bold"><i class="fa-solid fa-envelope text-decoration-underline"></i> Pesan</h4>
                                <p class="card-text fs-6">Lorem ipsum dolor sit amet consectetur, adipisicing elit. Nihil eaque ad officia voluptatum aut. Asperiores voluptates molestiae dolorum laudantium sunt.</p>
                            </li>
                            <li class="list-group-item">
                                <h4 class="card-title link-underline-dark link-offset-3 text-decoration-underline fw-bold"><i class="fa-solid fa-file text-decoration-underline"></i> File</h4>
                                <span class="card-text fs-5">Elden-Ring-DE-SteamRIP.com.rar</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-lg-4 col-xxl-3">
                <div class="card">
                    <h5 class="card-header">05/08/2024 - Senin</h5>
                    <div class="overflow-hidden rounded">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                <h4 class="card-title link-underline-dark link-offset-3 text-decoration-underline fw-bold"><i class="fa-solid fa-user text-decoration-underline"></i> Nama Pegawai</h4>
                                <span class="card-text fs-5">Asep Garong</span>
                            </li>
                            <li class="list-group-item">
                                <h4 class="card-title link-underline-dark link-offset-3 text-decoration-underline fw-bold"><i class="fa-solid fa-envelope text-decoration-underline"></i> Pesan</h4>
                                <p class="card-text fs-6">Lorem ipsum dolor sit amet consectetur, adipisicing elit. Nihil eaque ad officia voluptatum aut. Asperiores voluptates molestiae dolorum laudantium sunt.</p>
                            </li>
                            <li class="list-group-item">
                                <h4 class="card-title link-underline-dark link-offset-3 text-decoration-underline fw-bold"><i class="fa-solid fa-file text-decoration-underline"></i> File</h4>
                                <span class="card-text fs-5">Elden-Ring-DE-SteamRIP.com.rar</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>
    <script src="https://kit.fontawesome.com/e814145206.js" crossorigin="anonymous"></script>
</body>
</html>