<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    {{-- Bootstrap --}}
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
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
    {{-- Main --}}
    <div class="row mx-2 mb-4 justify-content-between">
        {{-- Cari Pegawai --}}
        <section class="col-md-6 col-xxl-4 mt-3">
            <div class="card p-3">
                <h4 class="mb-3"><strong>Cari Pegawai</strong></h4>
                <form action="">
                    <div class="input-group mb-3">
                        <label class="input-group-text" id="basic-addon1"><i class="fa-solid fa-magnifying-glass"></i></label>
                        <input type="text" class="form-control" placeholder="Nama Pegawai" aria-label="Nama Pegawai" aria-describedby="basic-addon1">
                    </div>
                    <div class="row g-2">
                        <button class="btn btn-success rounded p-2 text-start"> {{-- Status Active --}}
                            Fulan
                        </button>
                        <button class="btn btn-outline-success rounded p-2 text-start"> {{-- Status Normal --}}
                            Budi
                        </button>
                        <h2 class="text-secondary opacity-75 text-center">Pencarian Kosong</h2>
                    </div>
                </form>
            </div>
        </section>
        {{-- Buat Pesan --}}
        <section class="col-md-6 col-xxl-8 mt-4 mt-md-3">
            <div class="card p-3">
                <h4 class="mb-3"><strong>Buat Pesan</strong></h4>
                <form action="{{route('send.whatsapp')}}" method="POST">
                    @csrf
                    @method('POST')
                    <div class="input-group mb-2">
                        <label class="input-group-text" for="nomor">Nomor Telepon</label>
                        <input class="form-control" id="nomor" type="number" placeholder="08354876892" disabled>
                      </div>
                    <div class="row g-2">
                        <div class="col-lg-9">
                            <div class="input-group">
                                <label class="input-group-text" for="template">Template Text</label>
                                <select class="form-select" id="template">
                                    <option selected>Pilih Template</option>
                                    <option value="2">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sit, eveniet?</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-12 col-lg-3">
                            <button type="submit" class="btn btn-success w-100">Simpan</button>
                        </div>
                    </div>
                    <div class="input-group mt-2">
                        <label class="input-group-text" for="pesan">Pesan</label>
                        <textarea class="form-control" placeholder="Masukan Pesan" style="resize: none; height: 150px"></textarea>
                    </div>
                    <input class="form-control mt-2" type="file">
                    <button type="submit" class="btn btn-success mt-2 w-25 min-w">Kirim</button>
                </form>
            </div>
        </section>
    </div>
    <script src="https://kit.fontawesome.com/e814145206.js" crossorigin="anonymous"></script>
</body>
</html>