@extends('dashboard.layouts.main')

@section('container')
<div class="d-block justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 border-bottom">
    <h2 style="margin-left: 10px;">{{ $title }}</h2>
</div>

@if($pembukaan_name == null)
    <div class="card shadow mb-4 mt-3">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-info"><strong>Belum mendaftar</strong></h6>
        </div>
        <div class="card-body">
            <i><p>Anda belum mendaftar pada seleksi manapun.</strong></p>
            <p class="mb-0">Silahkan mendaftar pada seleksi yang sedang dibuka untuk dapat melihat hasil seleksi.</i></p>
        </div>
    </div>
@else
    <div class="card shadow mb-4 mt-3">
        @if($alter_hasil == 5)
        <div class="card-header py-3" style="background: #ddf7dc;">
            <h6 class="m-0 font-weight-bold text-success"><strong>SELAMAT, ANDA LULUS.</strong></h6>
        </div>
        @elseif($alter_hasil == 6)
        <div class="card-header py-3" style="background: #f5cbcb;">
            <h6 class="m-0 font-weight-bold text-danger"><strong>MAAF, ANDA GAGAL.</strong></h6>
        </div>
        @else
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary"><strong>Proses masih berlangsung.</strong></h6>
        </div>
        @endif
        <div class="card-body"> 
            @if($alter_hasil == 5)
                <i><p>Berikut ini adalah hasil dari pendaftaran Anda pada seleksi <strong style="color: black;">{{ $pembukaan_name }}.</strong></p>
                <p class="mb-0">Anda terpilih untuk dapat bergabung dengan organisasi dan dinyatakan <strong style="color: black;">LULUS.</strong>
                    Untuk informasi selanjutnya, mohon pantau terus akun Instagram @iaaslcunud.</i></p>
            @elseif($alter_hasil == 6)
                <i><p>Berikut ini adalah hasil dari pendaftaran Anda pada seleksi <strong style="color: black;">{{ $pembukaan_name }}.</strong></p>
                <p class="mb-0">Anda belum dapat bergabung menjadi bagian organisasi dan dinyatakan <strong style="color: black;">GAGAL.</strong>
                    Jangan berkecil hati, Anda bisa mencoba kembali pada pembukaan seleksi berikutnya.</i></p>
            @else
                <i><p>Pendaftaran Anda pada seleksi <strong style="color: black;">{{ $pembukaan_name }}</strong>  sedang diproses.</p>
                <p class="mb-0">Silahkan lihat alur yang sedang berlangsung di bawah ini.</i></p>
            @endif
        </div>
    </div>

    <div class="card rounded shadow border-0">
        <div class="card-body p-4 bg-white rounded">
            @foreach($pembukaans as $pembukaan)
                <div class="d-block">
                    <ul class="progressBar mt-3">
                        @if($pembukaan->status_id == 1)
                            <li class="active"></li>
                            <!-- {{ $i = 0 }} -->
                            @for($i = 0; $i < 3; $i++)
                                <li></li>
                            @endfor
                        @elseif($pembukaan->status_id == 2)
                            @if($nilai == 0)
                                <li></li>
                                <li class="active"></li>
                                <!-- {{ $i = 0 }} -->
                                @for($i = 0; $i < 2; $i++)
                                    <li></li>
                                @endfor
                            @elseif($nilai == 1)
                                @if($alter_hasil == 5)
                                    <!-- {{ $i = 0 }} -->
                                    @for($i = 0; $i < 3; $i++)
                                        <li></li>
                                    @endfor
                                    <li class="active"></li>
                                @elseif($alter_hasil == 6)
                                    <!-- {{ $i = 0 }} -->
                                    @for($i = 0; $i < 3; $i++)
                                        <li></li>
                                    @endfor
                                    <li class="fail active"></li>
                                @else
                                    <!-- {{ $i = 0 }} -->
                                    @for($i = 0; $i < 2; $i++)
                                        <li></li>
                                    @endfor
                                    <li class="active"></li>
                                    <li></li>
                                @endif
                            @endif
                        @endif
                    </ul>

                    <ul class="progressText">
                    @if($pembukaan->status_id == 1)
                        <li class="active">
                            <strong>Pendaftaran Seleksi</strong></br>
                            (Calon kandidat mendaftar pada seleksi yang tersedia).
                        </li>
                        <li>
                            <strong>Peninjauan Calon (Seleksi Ditutup)</strong></br>
                            (Peninjauan identitas calon kandidat oleh panitia).
                        </li>
                        <li>
                            <strong>Sedang Dilakukan Perhitungan</strong></br>
                            (Data sedang diolah).
                        </li>
                        <li>
                            <strong>Hasil</strong>
                        </li>
                    @elseif($pembukaan->status_id == 2)
                        @if($nilai == 0)
                            <li>
                                <strong>Pendaftaran Seleksi</strong></br>
                                (Calon kandidat mendaftar pada seleksi yang tersedia).
                            </li>
                            <li class="active">
                                <strong>Peninjauan Calon (Seleksi Ditutup)</strong></br>
                                (Peninjauan identitas calon kandidat oleh panitia).
                            </li>
                            <li>
                                <strong>Sedang Dilakukan Perhitungan</strong></br>
                                (Data sedang diolah).
                            </li>
                            <li>
                                <strong>Hasil</strong>
                            </li>
                        @elseif($nilai == 1)
                            @if($alter_hasil == 5)
                                <li>
                                    <strong>Pendaftaran Seleksi</strong></br>
                                    (Calon kandidat mendaftar pada seleksi yang tersedia).
                                </li>
                                <li>
                                    <strong>Peninjauan Calon (Seleksi Ditutup)</strong></br>
                                    (Peninjauan identitas calon kandidat oleh panitia).
                                </li>
                                <li>
                                    <strong>Sedang Dilakukan Perhitungan</strong></br>
                                    (Data sedang diolah).
                                </li>
                                <li class="active">
                                    <strong>Hasil</strong></br>
                                    (Selamat Anda dinyatakan <strong>LULUS</strong>).
                                </li>
                            @elseif($alter_hasil == 6)
                                <li>
                                    <strong>Pendaftaran Seleksi</strong></br>
                                    (Calon kandidat mendaftar pada seleksi yang tersedia).
                                </li>
                                <li>
                                    <strong>Peninjauan Calon (Seleksi Ditutup)</strong></br>
                                    (Peninjauan identitas calon kandidat oleh panitia).
                                </li>
                                <li>
                                    <strong>Sedang Dilakukan Perhitungan</strong></br>
                                    (Data sedang diolah).
                                </li>
                                <li class="active" style="color: red;">
                                    <strong>Hasil</strong></br>
                                    (Mohon maaf Anda dinyatakan <strong>Gagal</strong>).
                                </li>
                            @else
                                <li>
                                    <strong>Pendaftaran Seleksi</strong></br>
                                    (Calon kandidat mendaftar pada seleksi yang tersedia).
                                </li>
                                <li>
                                    <strong>Peninjauan Calon (Seleksi Ditutup)</strong></br>
                                    (Peninjauan identitas calon kandidat oleh panitia).
                                </li>
                                <li class="active">
                                    <strong>Sedang Dilakukan Perhitungan</strong></br>
                                    (Data sedang diolah).
                                </li>
                                <li>
                                    <strong>Hasil</strong>
                                </li>
                            @endif
                        @endif
                    @endif
                    </ul>
                </div>
            @endforeach

            @if($nilai == 1)
                @if(isset($done))
                    @if($done == 1)
                        <div class="container" style="margin-left: 10px; margin-top: -160px;">
                            @foreach($rankings as $ranking)
                                <div class="panel panel-primary">
                                    <div class="panel-heading"><strong>HASIL AKHIR</strong></div>
                                        <div class="panel-body" style="border: 1px solid #e7e7e7;">      
                                            <div class="table-responsive">
                                                <table id="example" style="width:100%; overflow: scroll;" class="table table-striped table-bordered">
                                                    <tbody>
                                                        <tr>
                                                            <th scope="col" style='text-align:center; vertical-align:middle'>Nama Alternatif</th>
                                                            <th scope="col" style='text-align:center; vertical-align:middle'>Nilai Total</th>
                                                            <th scope="col" style='text-align:center; vertical-align:middle'>Keterangan</th>
                                                        </tr>       
                                                        <tr>
                                                        @foreach($alternatifs as $alternatif)
                                                            @if($ranking->alternatif_id == $alternatif->id)
                                                            <td style='text-align:center; vertical-align:middle;'>{{ $alternatif->name }}</td>
                                                            <td style='text-align:center; vertical-align:middle; font-weight: bold;'>{{ $ranking->nilai_akhir }}</td>                  
                                                                @if($alternatif->hasil_id == 5)
                                                                    <!-- Keterangan -->
                                                                    <td class="text-success" style='text-align:center; vertical-align:middle; font-weight: bold;'>Lulus</td>
                                                                @else
                                                                    <!-- Keterangan -->
                                                                    <td class="text-danger" style='text-align:center; vertical-align:middle; font-weight: bold;'>Gagal</td>
                                                                @endif
                                                            @endif              
                                                        @endforeach
                                                        </tr>
                                                    </tbody>
                                                </table>                       
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                @endif
            @endif
        </div>
    </div>
@endif


@endsection
@extends('dashboard.layouts.footer')