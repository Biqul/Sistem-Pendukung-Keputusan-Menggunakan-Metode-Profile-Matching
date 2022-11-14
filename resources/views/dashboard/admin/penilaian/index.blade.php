@extends('dashboard.layouts.main')

@section('container')
@include('sweetalert::alert')

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 border-bottom">
    <h1 class="h2">{{ $title }}</h1>
</div>

<div class="card shadow mb-4 mt-3">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Pilih Seleksi dan Aspek</h6>
    </div>
    <div class="card-body">
        <i><p>Pilihan seleksi akan muncul jika <strong>status seleksi sudah tutup</strong>.
        Pastikan anda sudah menutup seleksi, sebelum memasukkan nilai.</p></i>
        <div class="mb-3">
            <form class="mt-4" method="post" action="{{ url('penilaians/input') }}">
            @csrf
                <div class="mb-3">
                    <label for="pembukaan_id" class="form-label"><b>Pilih Seleksi</b></label>
                        <select class="form-select" name="pembukaan_id"  id="pembukaan_id" required>
                            <option value="" disabled selected></option>
                            @foreach($pembukaans as $pembukaan)
                                @if($pembukaan->status_id == 2)
                                    <option value="{{ $pembukaan->id }}">{{ $pembukaan->name }}</option>
                                @endif
                            @endforeach
                        </select>
                </div>
                <div class="mb-3">
                    <label for="aspek_id" class="form-label"><b>Pilih Aspek</b></label>
                        <select class="form-select" name="aspek_id" id="aspek_id" required>
                            <option value="" disabled selected></option>
                            @foreach($aspeks as $aspek)
                                @if($aspek->status_id == 3)
                                    <option value="{{ $aspek->id }}">{{ $aspek->name }}</option>
                                @endif
                            @endforeach
                        </select>
                </div>
                <button type="submit" class="btn btn-primary" style="float: right; border-radius: 20px;">Beri Nilai</button>
            </form>
        </div>
    </div>
</div>


@endsection
@extends('dashboard.layouts.footer')