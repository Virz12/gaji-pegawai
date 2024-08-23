<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{-- Bootstrap --}}
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    {{-- JQuery  --}}
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script>
        const search = "{{ route('main.daftaradmin') }}";
    </script>

    {{-- Custom CSS --}}
    <style>
        .end-reveal {
            right: 1.3rem;
        }

        .top-reveal {
            top: 1.85rem;
        }

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
    <title>{{ config('app.name') }} | Daftar Admin</title>
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
                        <a class="nav-link text-black d-inline-block" href="/dashboard"><i class="fa-solid fa-comment"></i> Kirim Pesan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-black d-inline-block" href="/daftarpegawai"><i class="fa-solid fa-users"></i> Daftar Pegawai</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active fw-medium text-success d-inline-block" aria-current="page" href="/daftaradmin"><i class="fa-solid fa-user-tie"></i> Daftar Admin</a>
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
    {{-- Main --}}
    <main class="container-fluid ps-3 my-4">
        <section class="row g-2 justify-content-between">
            <a data-bs-toggle="modal" data-bs-target="#tambahData" class="btn btn-success mb-sm-3 ms-1 col-auto"><i class="fa-solid fa-plus me-2"></i> Tambah Admin</a>
            <form action="" class="col-12 col-sm-auto">
                <div class="input-group mb-3">
                    <label class="input-group-text shadow-sm" for="search"><i class="fa-solid fa-magnifying-glass"></i></label>
                    <input type="text" class="form-control shadow-sm" placeholder="Cari" aria-label="search" id="search" aria-describedby="search">
                </div>
            </form>
        </section>
        <section class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 row-cols-xxl-6 g-3 mb-3" id="pegawai-list">
        @forelse ( $dataadmin as $admin)
            {{-- Card --}}
            <div class="col">
                <div class="card">
                    <div class="overflow-hidden rounded">
                        <ul class="list-group list-group-flush">                
                            <li class="list-group-item">
                                <h4 class="card-title link-underline-dark link-offset-3 text-decoration-underline fw-bold"> Nama Admin</h4>
                                <h5 class="card-text fw-normal">{{ $admin->username }}</h5>
                            </li>
                            <li class="list-group-item">
                                <h4 class="card-title link-underline-dark link-offset-3 text-decoration-underline fw-bold"> Nomor WhatsApp</h4>
                                <h5 class="card-text fw-normal">9868769086</h5>
                            </li>
                            <li class="list-group-item ">
                                <a data-bs-toggle="modal" data-bs-target="#Hapus{{ $admin->id }}" class="btn btn-danger w-100"><i class="fa-solid fa-trash"></i> Hapus</a>
                            </li>                                                
                        </ul>
                    </div>
                </div>
            </div>
            {{-- Confirmation Modal --}}
            <div class="modal fade" id="Hapus{{ $admin->id }}" tabindex="-1" aria-labelledby="HapusLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="HapusLabel">Hapus Data</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body text-center">
                            Apakah anda yakin ingin menghapus data ini?<br>
                            <b>{{ $admin->username }}</b><br>
                        </div>
                        <div class="modal-footer">
                            <form action="/hapusadmin/{{ $admin->id }}">
                            <form action="{{route('main.deleteadmin',['dataadmin' => $admin])}}">
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
            <h2 class="m-auto text-secondary opacity-75 text-center">Arsip Kosong</h2>
        @endforelse
        </section>
        {{-- Add Modal --}}
        <div class="modal fade" id="tambahData" tabindex="-1" aria-labelledby="TambahLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="TambahLabel">Tambah Data</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="" method="POST">
                            @csrf
                            <div class="form-floating mb-3">
                                <input type="text" name="username" class="form-control border-2 @error('username') is-invalid @enderror" id="username" placeholder="" aria-label="username" autocomplete="off" required>
                                <label  for="username">Username Admin<span class="text-danger">*</span></label>
                                @error('username')
                                    <div class="text-danger"><small>{{ $message }}</small></div>
                                @enderror
                            </div>
                            <div class="form-floating mb-3">
                                <input type="password" name="password" class="form-control border-2 @error('password') is-invalid @enderror" id="password" placeholder="" aria-label="password" autocomplete="off" required>
                                <label  for="password">Password Admin<span class="text-danger">*</span></label>
                                <span id="togglePassword" class="toggle-password-icon position-absolute end-0 top-50 translate-middle-y me-3" style="cursor: pointer;">
                                    <i class="fa-regular fa-eye fa-lg" id="reveal-password"></i>
                                </span>
                                @error('password')
                                    <div class="text-danger text-left"><small>{{ $message }}</small></div>
                                @enderror
                            </div>
                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-success me-2">Tambah</button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kembali</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div id="pagination-links">{!! $dataadmin->links() !!}</div>
    </main>
    {{-- Script --}}
    <script src="{{ asset('js/daftaradmin.js') }}"></script>
    <script src="https://kit.fontawesome.com/e814145206.js" crossorigin="anonymous"></script>
</body>
</html>