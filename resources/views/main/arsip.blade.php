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
    <script>
        const search = "{{ route('main.arsip',['datapegawai' => $datapegawai]) }}";
        const downloadUrlTemplate = "{{ route('file.download', ['arsip_pesan' => '__PLACEHOLDER__']) }}";
    </script>
    
    <title>{{ config('app.name') }} | Arsip Pesan</title>
</head>
<body class="min-vh-100 bg-body-secondary">
    {{-- NavBar --}}
    <nav class="navbar navbar-expand-md bg-white shadow">
        <div class="container-fluid">
            <a class="navbar-brand text-success ms-2" href="#"><strong>WhatsApp Sender</strong></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
                <ul class="nav nav-underline ms-auto mb-2 mb-md-0 me-auto flex-column flex-md-row">
                    <li class="nav-item">
                        <a class="nav-link text-black d-inline-block" href="/dashboard"><i class="fa-solid fa-comment"></i> Kirim Pesan</a>
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
    <main class="container-fluid ps-3 my-4">
        <section class="row g-2 justify-content-between">
            <a href="/daftarpegawai" class="btn btn-success mb-sm-3 ms-1 col-auto"><i class="fa-solid fa-arrow-left me-2"></i>Kembali</a>
            <form action="" class="col-12 col-md-auto">
                <div class="input-group mb-3">
                    <label class="input-group-text shadow-sm" for="search"><i class="fa-solid fa-magnifying-glass"></i></label>
                    <input type="text" class="form-control shadow-sm" placeholder="Cari" aria-label="search" id="search" aria-describedby="search">
                </div>
            </form>
        </section>
        <h4 class="text-center p-2 m-auto mb-2 col-auto"><i class="fa-solid fa-user "></i> {{$datapegawai->nama}}<br><span class="mt-2 badge rounded-pill text-bg-secondary">NIP : {{$datapegawai->nip}}</span></h4>
        <section class="row g-3 mb-3" id="arsip-list">
        @forelse ( $arsipPesan as $arsip)
            {{-- Card --}}
            <div class="col-12 col-sm-6 col-lg-4 col-xxl-3">
                <div class="card">
                    <h5 class="card-header d-flex justify-content-between"><span><i class="fa-solid fa-calendar"></i> {{ $arsip->created_at->timezone('Asia/Jakarta')->format('j/n/Y') }}</span><span><i class="fa-solid fa-clock"></i> {{ $arsip->created_at->timezone('Asia/Jakarta')->format('H:i:s') }}</span></h5>
                    <div class="overflow-hidden rounded">
                        <ul class="list-group list-group-flush">                
                            <li class="list-group-item">
                                <h4 class="card-title link-underline-dark link-offset-3 text-decoration-underline fw-bold"><i class="fa-solid fa-envelope text-decoration-underline"></i> Pesan</h4>
                                <p class="card-text fs-6">{{ $arsip->pesan }}</p>
                            </li>
                            <li class="list-group-item">                                                                    
                                <h4 class="card-title link-underline-dark link-offset-3 text-decoration-underline fw-bold"><i class="fa-solid fa-file text-decoration-underline"></i> File</h4>
                                @if ($arsip->attachment == true)
                                    <span class="card-text fs-5">{{$arsip->attachment}}</span>
                                    <div class="d-flex justify-content-between mt-1">
                                        <a class="btn btn-primary w-75 me-1"  data-bs-toggle="modal" data-bs-target="#Preview{{ $arsip->attachment }}"><i class="fa-solid fa-eye"></i> Preview</a>
                                        <a href="{{ route('file.download', ['arsip_pesan' => $arsip]) }}"  class="btn btn-success w-25 ms-1"><i class="fa-solid fa-circle-down "></i> Unduh</a>
                                    </div>
                                @else
                                    <span class="card-text fs-5">-</span>
                                @endif
                            </li>                                                           
                        </ul>
                    </div>
                </div>
            </div>
            {{-- Preview Modal --}}
            <div class="modal fade" id="Preview{{ $arsip->attachment }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">{{ $arsip->attachment }}</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body text-center">
                            @php
                                $extension = strtolower(pathinfo($arsip->attachment, PATHINFO_EXTENSION));
                                $filePath = asset('attachments/' . $arsip->attachment);
                            @endphp

                            @if(in_array($extension, ['jpg', 'jpeg', 'png']))                                
                                <img src="{{ $filePath }}" alt="Image" class="img-fluid">
                            @elseif($extension == 'pdf')                                
                                <embed src="{{ $filePath }}#page=1" type="application/pdf" width="100%" height="500px" />
                            @elseif($extension == 'txt')
                                {{-- Display the content of the text file --}}
                                <iframe src="{{ $filePath }}" width="100%" height="500px"></iframe>
                            @elseif(in_array($extension, ['doc', 'docx', 'ppt', 'pptx', 'xls', 'xlsx']))
                                {{-- Display the first page of the document using Office Online --}}
                                <iframe src="https://view.officeapps.live.com/op/embed.aspx?src={{ urlencode($filePath) }}&page=1" width="100%" height="500px"></iframe>
                            @else
                                <p>Preview tidak tersedia untuk file ini.</p>
                            @endif
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kembali</button>                        
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <h2 class="text-secondary opacity-75 text-center">Arsip Kosong</h2>
        @endforelse
        </section>
        <div id="pagination-links">{!! $arsipPesan->links() !!}</div>
    </main>
    <script src="{{ asset('js/arsip.js') }}"></script>
    <script src="https://kit.fontawesome.com/e814145206.js" crossorigin="anonymous"></script>
</body>
</html>