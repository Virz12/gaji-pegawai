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
        const search = "{{ route('Super-Admin.daftarpegawai') }}";
    </script>

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
    <title>{{ config('app.name') }} | Daftar Pegawai</title>
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
                        <a class="nav-link active fw-medium text-success d-inline-block" aria-current="page" href="/daftarpegawai"><i class="fa-solid fa-users"></i> Daftar Pegawai</a>
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
    {{-- Main --}}
    <main class="container-fluid ps-3 my-4">
        <section class="row g-2 justify-content-between">
            <a href="/tambahpegawai" class="btn btn-success mb-sm-3 ms-1 col-auto"><i class="fa-solid fa-plus me-2"></i>Tambah Pegawai</a>
            <form action="" class="col-12 col-sm-auto">
                <div class="input-group mb-3">
                    <label class="input-group-text shadow-sm" for="search"><i class="fa-solid fa-magnifying-glass"></i></label>
                    <input type="text" class="form-control shadow-sm" placeholder="Cari" aria-label="search" id="search" aria-describedby="search">
                </div>
            </form>
        </section>
        <section class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 row-cols-xxl-6 g-3 mb-3" id="pegawai-list">
        @forelse ( $datapegawai as $pegawai)
            {{-- Card --}}
            <div class="col">
                <div class="card">
                    <span class="card-header p-lg-5 p-5">
                        <div class="ratio ratio-1x1">
                        @if (File::exists($pegawai->foto_pegawai))                            
                            <img class="rounded" src="{{ asset($pegawai->foto_pegawai) }}" alt="Profile picture">                                                                                
                        @elseif ( $pegawai->jenis_kelamin == 'Laki-laki' )                
                            <label class="rounded" style="background-color:rgb(47, 196, 255)">
                                <i class="fa-solid fa-user  position-absolute top-50 start-50 translate-middle" style="font-size: 5rem;"></i>
                            </label>
                        @elseif ( $pegawai->jenis_kelamin == 'Perempuan' )
                            <label class="rounded " style="background-color:rgb(243, 173, 196)">
                                <i class="fa-solid fa-user  position-absolute top-50 start-50 translate-middle" style="font-size: 5rem;"></i>                                
                            </label> 
                        @endif
                        </div>
                    </span>
                    <div class="overflow-hidden rounded">
                        <ul class="list-group list-group-flush">                
                            <li class="list-group-item">
                                <h4 class="card-title link-underline-dark link-offset-3 text-decoration-underline fw-bold"> Nama Pegawai</h4>
                                <h5 class="card-text fw-normal">{{ $pegawai->nama }}</h5>
                            </li>
                            <li class="list-group-item">
                                <h4 class="card-title link-underline-dark link-offset-3 text-decoration-underline fw-bold"> NIP</h4>
                                <h5 class="card-text fw-normal">{{ $pegawai->nip }}</h5>
                            </li>
                            <li class="list-group-item">
                                <h4 class="card-title link-underline-dark link-offset-3 text-decoration-underline fw-bold"> Jenis Kelamin</h4>
                                <h5 class="card-text fw-normal">{{ $pegawai->jenis_kelamin }}</h5>
                            </li>
                            <li class="list-group-item">
                                <h4 class="card-title link-underline-dark link-offset-3 text-decoration-underline fw-bold"> Nomor Whatsapp</h4>
                                <h5 class="card-text fw-normal">{{ $pegawai->nomorWa }}</h5>
                            </li>
                            <li class="list-group-item ">
                                <div class="d-flex justify-content-between ">
                                    <a href="{{route('Super-Admin.editpegawai',['datapegawai' => $pegawai])}}" class="btn btn-primary w-50 me-1"><i class="fa-solid fa-pen-to-square"></i> Edit</a>
                                    <a data-bs-toggle="modal" data-bs-target="#Hapus{{ $pegawai->nip }}" class="btn btn-danger w-50 ms-1"><i class="fa-solid fa-trash"></i> Hapus</a>
                                </div>
                                <a href="{{route('Super-Admin.arsip',['datapegawai' => $pegawai])}}" class="btn btn-warning w-100 mt-2"><i class="fa-solid fa-message"></i> Arsip Pesan</a>
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
                            <b>{{ $pegawai->nama }}</b><br>
                            <b>[NIP : {{ $pegawai->nip }}]</b>
                        </div>
                        <div class="modal-footer">
                            <form action="/hapuspegawai/{{ $pegawai->id }}">
                            <form action="{{route('Super-Admin.delete',['datapegawai' => $pegawai])}}">
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
        <div id="pagination-links">{!! $datapegawai->links() !!}</div>
    </main>
    {{-- Script --}}
    <script src="{{ asset('js/daftarpegawai.js') }}"></script>
    <script src="https://kit.fontawesome.com/e814145206.js" crossorigin="anonymous"></script>
</body>
</html>